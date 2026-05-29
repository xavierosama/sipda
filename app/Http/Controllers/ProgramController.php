<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Member;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProgramController extends Controller
{
    private const STATUSES = ['draft', 'planned', 'ongoing', 'completed', 'postponed', 'cancelled'];

    public function index(Request $request): View
    {
        $programs = Program::query()
            ->with(['department', 'pic'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->search.'%')
                        ->orWhere('name', 'like', '%'.$request->search.'%');
                });
            })
            ->when($request->filled('department_id'), function ($query) use ($request) {
                $query->where('department_id', $request->department_id);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('programs.index', [
            'programs' => $programs,
            'departments' => $this->departmentOptions(),
            'statuses' => self::STATUSES,
            'filters' => $request->only(['search', 'department_id', 'status']),
        ]);
    }

    public function create(): View
    {
        return view('programs.create', [
            'program' => new Program(['status' => 'draft']),
            'departments' => $this->departmentOptions(),
            'members' => $this->memberOptions(),
            'statuses' => self::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProgram($request);

        Program::create($this->programPayload($validated, $request));

        return redirect()
            ->route('programs.index')
            ->with('success', 'Program kerja berhasil ditambahkan.');
    }

    public function show(Program $program): View
    {
        $program->load(['department', 'pic', 'creator']);

        return view('programs.show', compact('program'));
    }

    public function edit(Program $program): View
    {
        return view('programs.edit', [
            'program' => $program,
            'departments' => $this->departmentOptions(),
            'members' => $this->memberOptions(),
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, Program $program): RedirectResponse
    {
        $validated = $this->validateProgram($request);

        $program->update($this->programPayload($validated, $request, false));

        return redirect()
            ->route('programs.index')
            ->with('success', 'Program kerja berhasil diperbarui.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $program->update(['status' => 'cancelled']);

        return redirect()
            ->route('programs.index')
            ->with('success', 'Program kerja berhasil dibatalkan.');
    }

    private function validateProgram(Request $request): array
    {
        return $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'pic_id' => ['nullable', 'exists:members,id'],
            'title' => ['required', 'string', 'max:255'],
            'objective' => ['nullable', 'string'],
            'target' => ['nullable', 'string'],
            'audience' => ['nullable', 'string', 'max:255'],
            'planned_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'estimated_budget' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(self::STATUSES)],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function programPayload(array $validated, Request $request, bool $withCreator = true): array
    {
        $payload = [
            ...$validated,
            'member_id' => $validated['pic_id'] ?? null,
            'name' => $validated['title'],
            'description' => $validated['objective'] ?? null,
            'start_date' => $validated['planned_date'] ?? null,
        ];

        if ($withCreator) {
            $payload['created_by'] = $request->user()->id;
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

    private function memberOptions()
    {
        return Member::query()
            ->where('member_status', 'active')
            ->orderBy('full_name')
            ->orderBy('name')
            ->get();
    }
}
