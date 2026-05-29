<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LetterController extends Controller
{
    private const TYPES = ['incoming', 'outgoing'];

    private const CATEGORIES = [
        'Undangan',
        'Pemberitahuan',
        'Permohonan',
        'Keterangan',
        'Keputusan/SK',
        'Laporan',
        'Lainnya',
    ];

    private const STATUSES = ['draft', 'sent', 'received', 'archived', 'cancelled'];

    public function index(Request $request): View
    {
        $letters = Letter::query()
            ->with('activity')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('letter_number', 'like', '%'.$request->search.'%')
                        ->orWhere('subject', 'like', '%'.$request->search.'%')
                        ->orWhere('sender', 'like', '%'.$request->search.'%')
                        ->orWhere('recipient', 'like', '%'.$request->search.'%');
                });
            })
            ->when($request->filled('type'), function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->category);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('letter_date'), function ($query) use ($request) {
                $query->whereDate('letter_date', $request->letter_date);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('letters.index', [
            'letters' => $letters,
            'types' => self::TYPES,
            'categories' => self::CATEGORIES,
            'statuses' => self::STATUSES,
            'filters' => $request->only(['search', 'type', 'category', 'status', 'letter_date']),
        ]);
    }

    public function create(Request $request): View
    {
        return view('letters.create', [
            'letter' => new Letter([
                'type' => $request->query('type', 'incoming'),
                'status' => 'draft',
            ]),
            'activities' => $this->activityOptions(),
            'types' => self::TYPES,
            'categories' => self::CATEGORIES,
            'statuses' => self::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateLetter($request);

        Letter::create($this->letterPayload($validated, $request));

        return redirect()
            ->route('letters.index', ['type' => $validated['letter_type']])
            ->with('success', 'Data surat berhasil ditambahkan.');
    }

    public function show(Letter $letter): View
    {
        $letter->load(['activity', 'creator']);

        return view('letters.show', compact('letter'));
    }

    public function edit(Letter $letter): View
    {
        return view('letters.edit', [
            'letter' => $letter,
            'activities' => $this->activityOptions(),
            'types' => self::TYPES,
            'categories' => self::CATEGORIES,
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, Letter $letter): RedirectResponse
    {
        $validated = $this->validateLetter($request, $letter);

        $letter->update($this->letterPayload($validated, $request, $letter, false));

        return redirect()
            ->route('letters.index', ['type' => $validated['letter_type']])
            ->with('success', 'Data surat berhasil diperbarui.');
    }

    public function destroy(Letter $letter): RedirectResponse
    {
        $letter->update(['status' => 'archived']);

        return redirect()
            ->route('letters.index', ['type' => $letter->type])
            ->with('success', 'Data surat berhasil diarsipkan.');
    }

    private function validateLetter(Request $request, ?Letter $letter = null): array
    {
        return $request->validate([
            'letter_type' => ['required', Rule::in(self::TYPES)],
            'letter_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('letters', 'letter_number')->ignore($letter?->id),
            ],
            'letter_date' => ['required', 'date'],
            'received_or_sent_date' => ['nullable', 'date'],
            'sender' => ['nullable', 'string', 'max:255'],
            'recipient' => ['nullable', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'category' => ['nullable', Rule::in(self::CATEGORIES)],
            'activity_id' => ['nullable', 'exists:activities,id'],
            'file_path' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'status' => ['required', Rule::in(self::STATUSES)],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function letterPayload(array $validated, Request $request, ?Letter $letter = null, bool $withCreator = true): array
    {
        $payload = [
            'type' => $validated['letter_type'],
            'letter_number' => $validated['letter_number'],
            'letter_date' => $validated['letter_date'],
            'received_or_sent_date' => $validated['received_or_sent_date'] ?? null,
            'received_date' => $validated['received_or_sent_date'] ?? null,
            'sender' => $validated['sender'] ?? null,
            'recipient' => $validated['recipient'] ?? null,
            'subject' => $validated['subject'],
            'category' => $validated['category'] ?? null,
            'activity_id' => $validated['activity_id'] ?? null,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
            'description' => $validated['notes'] ?? null,
        ];

        if ($request->hasFile('file_path')) {
            if ($letter?->file_path) {
                Storage::disk('public')->delete($letter->file_path);
            }

            $payload['file_path'] = $request->file('file_path')->store('letters', 'public');
        }

        if ($withCreator) {
            $payload['created_by'] = $request->user()->id;
        }

        return $payload;
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
