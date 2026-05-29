<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Department;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DocumentController extends Controller
{
    private const CATEGORIES = [
        'SK',
        'Surat',
        'Proposal',
        'LPJ',
        'Notulensi',
        'Daftar Hadir',
        'Dokumentasi',
        'Template',
        'Lainnya',
    ];

    public function index(Request $request): View
    {
        $documents = Document::query()
            ->with(['department', 'activity', 'uploader'])
            ->whereNull('archived_at')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->search.'%')
                        ->orWhere('description', 'like', '%'.$request->search.'%');
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->category);
            })
            ->when($request->filled('department_id'), function ($query) use ($request) {
                $query->where('department_id', $request->department_id);
            })
            ->when($request->filled('activity_id'), function ($query) use ($request) {
                $query->where('activity_id', $request->activity_id);
            })
            ->when($request->filled('document_date'), function ($query) use ($request) {
                $query->whereDate('document_date', $request->document_date);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('documents.index', [
            'documents' => $documents,
            'categories' => self::CATEGORIES,
            'departments' => $this->departmentOptions(),
            'activities' => $this->activityOptions(),
            'filters' => $request->only(['search', 'category', 'department_id', 'activity_id', 'document_date']),
        ]);
    }

    public function create(): View
    {
        return view('documents.create', [
            'document' => new Document(),
            'categories' => self::CATEGORIES,
            'departments' => $this->departmentOptions(),
            'activities' => $this->activityOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateDocument($request, requireFile: true);

        Document::create($this->documentPayload($validated, $request));

        return redirect()
            ->route('documents.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function show(Document $document): View
    {
        $document->load(['department', 'activity', 'uploader']);

        return view('documents.show', compact('document'));
    }

    public function edit(Document $document): View
    {
        return view('documents.edit', [
            'document' => $document,
            'categories' => self::CATEGORIES,
            'departments' => $this->departmentOptions(),
            'activities' => $this->activityOptions(),
        ]);
    }

    public function update(Request $request, Document $document): RedirectResponse
    {
        $validated = $this->validateDocument($request, requireFile: false);

        $document->update($this->documentPayload($validated, $request, $document, false));

        return redirect()
            ->route('documents.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        $document->update(['archived_at' => now()]);

        return redirect()
            ->route('documents.index')
            ->with('success', 'Dokumen berhasil diarsipkan.');
    }

    private function validateDocument(Request $request, bool $requireFile): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', Rule::in(self::CATEGORIES)],
            'department_id' => ['nullable', 'exists:departments,id'],
            'activity_id' => ['nullable', 'exists:activities,id'],
            'document_date' => ['nullable', 'date'],
            'file_path' => [$requireFile ? 'required' : 'nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'max:10240'],
            'description' => ['nullable', 'string'],
        ]);
    }

    private function documentPayload(array $validated, Request $request, ?Document $document = null, bool $withUploader = true): array
    {
        $payload = [
            'title' => $validated['title'],
            'category' => $validated['category'] ?? null,
            'department_id' => $validated['department_id'] ?? null,
            'activity_id' => $validated['activity_id'] ?? null,
            'document_date' => $validated['document_date'] ?? null,
            'description' => $validated['description'] ?? null,
        ];

        if ($request->hasFile('file_path')) {
            if ($document?->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file_path');
            $payload['file_path'] = $file->store('documents', 'public');
            $payload['mime_type'] = $file->getMimeType();
            $payload['file_size'] = $file->getSize();
        }

        if ($withUploader) {
            $payload['uploaded_by'] = $request->user()->id;
        }

        return $payload;
    }

    private function departmentOptions()
    {
        return Department::query()
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
