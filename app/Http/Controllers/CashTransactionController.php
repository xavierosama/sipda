<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\CashCategory;
use App\Models\CashTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CashTransactionController extends Controller
{
    private const TYPES = ['income', 'expense'];

    public function index(Request $request): View
    {
        $baseQuery = CashTransaction::query()
            ->whereNull('archived_at')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('description', 'like', '%'.$request->search.'%');
            })
            ->when($request->filled('type'), function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when($request->filled('cash_category_id'), function ($query) use ($request) {
                $query->where('cash_category_id', $request->cash_category_id);
            })
            ->when($request->filled('activity_id'), function ($query) use ($request) {
                $query->where('activity_id', $request->activity_id);
            })
            ->when($request->filled('date_from'), function ($query) use ($request) {
                $query->whereDate('transaction_date', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                $query->whereDate('transaction_date', '<=', $request->date_to);
            });

        $summaryQuery = clone $baseQuery;
        $totalIncome = (clone $summaryQuery)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $summaryQuery)->where('type', 'expense')->sum('amount');

        $cashTransactions = $baseQuery
            ->with(['cashCategory', 'activity', 'creator'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('cash-transactions.index', [
            'cashTransactions' => $cashTransactions,
            'cashCategories' => $this->cashCategoryOptions(),
            'activities' => $this->activityOptions(),
            'types' => self::TYPES,
            'filters' => $request->only(['search', 'type', 'cash_category_id', 'activity_id', 'date_from', 'date_to']),
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $totalIncome - $totalExpense,
        ]);
    }

    public function create(Request $request): View
    {
        return view('cash-transactions.create', [
            'cashTransaction' => new CashTransaction([
                'type' => $request->query('type', 'income'),
                'transaction_date' => now(),
            ]),
            'cashCategories' => $this->cashCategoryOptions(),
            'activities' => $this->activityOptions(),
            'types' => self::TYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateCashTransaction($request);

        CashTransaction::create($this->cashTransactionPayload($validated, $request));

        return redirect()
            ->route('cash-transactions.index', ['type' => $validated['transaction_type']])
            ->with('success', 'Transaksi kas berhasil ditambahkan.');
    }

    public function show(CashTransaction $cashTransaction): View
    {
        $cashTransaction->load(['cashCategory', 'activity', 'creator']);

        return view('cash-transactions.show', compact('cashTransaction'));
    }

    public function edit(CashTransaction $cashTransaction): View
    {
        return view('cash-transactions.edit', [
            'cashTransaction' => $cashTransaction,
            'cashCategories' => $this->cashCategoryOptions(),
            'activities' => $this->activityOptions(),
            'types' => self::TYPES,
        ]);
    }

    public function update(Request $request, CashTransaction $cashTransaction): RedirectResponse
    {
        $validated = $this->validateCashTransaction($request);

        $cashTransaction->update($this->cashTransactionPayload($validated, $request, $cashTransaction, false));

        return redirect()
            ->route('cash-transactions.index', ['type' => $validated['transaction_type']])
            ->with('success', 'Transaksi kas berhasil diperbarui.');
    }

    public function destroy(CashTransaction $cashTransaction): RedirectResponse
    {
        $cashTransaction->update(['archived_at' => now()]);

        return redirect()
            ->route('cash-transactions.index', ['type' => $cashTransaction->type])
            ->with('success', 'Transaksi kas berhasil diarsipkan.');
    }

    private function validateCashTransaction(Request $request): array
    {
        return $request->validate([
            'transaction_date' => ['required', 'date'],
            'transaction_type' => ['required', Rule::in(self::TYPES)],
            'cash_category_id' => ['required', 'exists:cash_categories,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'activity_id' => ['nullable', 'exists:activities,id'],
            'proof_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);
    }

    private function cashTransactionPayload(array $validated, Request $request, ?CashTransaction $cashTransaction = null, bool $withCreator = true): array
    {
        $payload = [
            'transaction_date' => $validated['transaction_date'],
            'type' => $validated['transaction_type'],
            'cash_category_id' => $validated['cash_category_id'],
            'amount' => $validated['amount'],
            'description' => $validated['description'] ?? null,
            'activity_id' => $validated['activity_id'] ?? null,
            'title' => $validated['description'] ?: ($validated['transaction_type'] === 'income' ? 'Kas Masuk' : 'Kas Keluar'),
        ];

        if ($request->hasFile('proof_file')) {
            if ($cashTransaction?->proof_file_path) {
                Storage::disk('public')->delete($cashTransaction->proof_file_path);
            }

            $payload['proof_file_path'] = $request->file('proof_file')->store('transactions', 'public');
        }

        if ($withCreator) {
            $payload['created_by'] = $request->user()->id;
        }

        return $payload;
    }

    private function cashCategoryOptions()
    {
        return CashCategory::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
    }

    private function activityOptions()
    {
        return Activity::query()
            ->where('status', '!=', 'cancelled')
            ->orderBy('activity_date')
            ->orderBy('title')
            ->orderBy('name')
            ->get();
    }
}
