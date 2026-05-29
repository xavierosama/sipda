<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Department;
use App\Models\Member;
use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ActivityController extends Controller
{
    private const STATUSES = ['planned', 'ongoing', 'completed', 'postponed', 'cancelled'];

    public function index(Request $request): View
    {
        $activities = Activity::query()
            ->with(['program', 'department', 'pic'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->search.'%')
                        ->orWhere('name', 'like', '%'.$request->search.'%');
                });
            })
            ->when($request->filled('department_id'), function ($query) use ($request) {
                $query->where('department_id', $request->department_id);
            })
            ->when($request->filled('program_id'), function ($query) use ($request) {
                $query->where('program_id', $request->program_id);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('activity_date'), function ($query) use ($request) {
                $query->whereDate('activity_date', $request->activity_date);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('activities.index', [
            'activities' => $activities,
            'departments' => $this->departmentOptions(),
            'programs' => $this->programOptions(),
            'statuses' => self::STATUSES,
            'filters' => $request->only(['search', 'department_id', 'program_id', 'status', 'activity_date']),
        ]);
    }

    public function create(): View
    {
        return view('activities.create', [
            'activity' => new Activity(['status' => 'planned']),
            'departments' => $this->departmentOptions(),
            'programs' => $this->programOptions(),
            'members' => $this->memberOptions(),
            'statuses' => self::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateActivity($request);

        Activity::create($this->activityPayload($validated, $request));

        return redirect()
            ->route('activities.index')
            ->with('success', 'Agenda kegiatan berhasil ditambahkan.');
    }

    public function show(Activity $activity): View
    {
        $activity->load(['program', 'department', 'pic', 'creator']);

        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        return view('activities.edit', [
            'activity' => $activity,
            'departments' => $this->departmentOptions(),
            'programs' => $this->programOptions(),
            'members' => $this->memberOptions(),
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, Activity $activity): RedirectResponse
    {
        $validated = $this->validateActivity($request);

        $activity->update($this->activityPayload($validated, $request, false));

        return redirect()
            ->route('activities.index')
            ->with('success', 'Agenda kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->update(['status' => 'cancelled']);

        return redirect()
            ->route('activities.index')
            ->with('success', 'Agenda kegiatan berhasil dibatalkan.');
    }

    private function validateActivity(Request $request): array
    {
        return $request->validate([
            'program_id' => ['nullable', 'exists:programs,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'pic_id' => ['nullable', 'exists:members,id'],
            'title' => ['required', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(self::STATUSES)],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function activityPayload(array $validated, Request $request, bool $withCreator = true): array
    {
        $payload = [
            ...$validated,
            'member_id' => $validated['pic_id'] ?? null,
            'name' => $validated['title'],
            'started_at' => $this->dateTimeFrom($validated['activity_date'], $validated['start_time'] ?? null),
            'ended_at' => $this->dateTimeFrom($validated['activity_date'], $validated['end_time'] ?? null),
        ];

        if ($withCreator) {
            $payload['created_by'] = $request->user()->id;
        }

        return $payload;
    }

    private function dateTimeFrom(string $date, ?string $time): ?Carbon
    {
        if (! $time) {
            return null;
        }

        return Carbon::createFromFormat('Y-m-d H:i', $date.' '.$time);
    }

    private function departmentOptions()
    {
        return Department::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
    }

    private function programOptions()
    {
        return Program::query()
            ->where('status', '!=', 'cancelled')
            ->orderBy('title')
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
