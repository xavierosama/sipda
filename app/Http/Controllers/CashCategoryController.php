<?php

namespace App\Http\Controllers;

use App\Models\CashCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CashCategoryController extends Controller
{
    private const TYPES = ['income', 'expense', 'both'];

    private const STATUSES = ['active', 'inactive'];

    public function index(Request $request): View
    {
        $cashCategories = CashCategory::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%');
            })
            ->when($request->filled('type'), function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('cash-categories.index', [
            'cashCategories' => $cashCategories,
            'types' => self::TYPES,
            'statuses' => self::STATUSES,
            'filters' => $request->only(['search', 'type', 'status']),
        ]);
    }

    public function create(): View
    {
        return view('cash-categories.create', [
            'cashCategory' => new CashCategory(['status' => 'active']),
            'types' => self::TYPES,
            'statuses' => self::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        CashCategory::create($this->validateCashCategory($request));

        return redirect()
            ->route('cash-categories.index')
            ->with('success', 'Kategori kas berhasil ditambahkan.');
    }

    public function show(CashCategory $cashCategory): View
    {
        return view('cash-categories.show', compact('cashCategory'));
    }

    public function edit(CashCategory $cashCategory): View
    {
        return view('cash-categories.edit', [
            'cashCategory' => $cashCategory,
            'types' => self::TYPES,
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, CashCategory $cashCategory): RedirectResponse
    {
        $cashCategory->update($this->validateCashCategory($request, $cashCategory));

        return redirect()
            ->route('cash-categories.index')
            ->with('success', 'Kategori kas berhasil diperbarui.');
    }

    public function destroy(CashCategory $cashCategory): RedirectResponse
    {
        $cashCategory->update(['status' => 'inactive']);

        return redirect()
            ->route('cash-categories.index')
            ->with('success', 'Kategori kas berhasil dinonaktifkan.');
    }

    private function validateCashCategory(Request $request, ?CashCategory $cashCategory = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cash_categories', 'name')->ignore($cashCategory?->id),
            ],
            'type' => ['nullable', Rule::in(self::TYPES)],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);
    }
}
