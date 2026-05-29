<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    private const STATUSES = ['present', 'permission', 'absent'];

    public function index(Request $request): View
    {
        $baseQuery = Attendance::query()
            ->with(['activity', 'member.department'])
            ->when($request->filled('activity_id'), function ($query) use ($request) {
                $query->where('activity_id', $request->activity_id);
            })
            ->when($request->filled('member_id'), function ($query) use ($request) {
                $query->where('member_id', $request->member_id);
            })
            ->when($request->filled('attendance_status'), function ($query) use ($request) {
                $query->where('status', $request->attendance_status);
            })
            ->when($request->filled('activity_date'), function ($query) use ($request) {
                $query->whereHas('activity', function ($query) use ($request) {
                    $query->whereDate('activity_date', $request->activity_date);
                });
            });

        $summary = [
            'present' => (clone $baseQuery)->where('status', 'present')->count(),
            'permission' => (clone $baseQuery)->where('status', 'permission')->count(),
            'absent' => (clone $baseQuery)->where('status', 'absent')->count(),
            'total' => (clone $baseQuery)->count(),
        ];

        $attendances = $baseQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('attendances.index', [
            'attendances' => $attendances,
            'activities' => $this->activityOptions(),
            'members' => $this->memberOptions(),
            'statuses' => self::STATUSES,
            'filters' => $request->only(['activity_id', 'member_id', 'attendance_status', 'activity_date']),
            'summary' => $summary,
        ]);
    }

    public function create(): View
    {
        return view('attendances.create', [
            'attendance' => new Attendance(['status' => 'present']),
            'activities' => $this->activityOptions(),
            'members' => $this->memberOptions(),
            'statuses' => self::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateAttendance($request);

        Attendance::create($this->attendancePayload($validated, $request));

        return redirect()
            ->route('attendances.index', ['activity_id' => $validated['activity_id']])
            ->with('success', 'Data kehadiran berhasil ditambahkan.');
    }

    public function show(Attendance $attendance): View
    {
        $attendance->load(['activity', 'member.department', 'creator']);

        return view('attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance): View
    {
        return view('attendances.edit', [
            'attendance' => $attendance,
            'activities' => $this->activityOptions(),
            'members' => $this->memberOptions(),
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, Attendance $attendance): RedirectResponse
    {
        $validated = $this->validateAttendance($request, $attendance);

        $attendance->update($this->attendancePayload($validated, $request, false));

        return redirect()
            ->route('attendances.index', ['activity_id' => $validated['activity_id']])
            ->with('success', 'Data kehadiran berhasil diperbarui.');
    }

    public function destroy(Attendance $attendance): RedirectResponse
    {
        $activityId = $attendance->activity_id;
        $attendance->delete();

        return redirect()
            ->route('attendances.index', ['activity_id' => $activityId])
            ->with('success', 'Data kehadiran berhasil dihapus.');
    }

    public function bulkCreate(Request $request): View
    {
        $activity = $request->filled('activity_id')
            ? Activity::with('attendances')->find($request->activity_id)
            : null;

        $existingAttendances = $activity
            ? Attendance::where('activity_id', $activity->id)->get()->keyBy('member_id')
            : collect();

        return view('attendances.bulk', [
            'activities' => $this->activityOptions(),
            'members' => $this->memberOptions(),
            'statuses' => self::STATUSES,
            'selectedActivity' => $activity,
            'existingAttendances' => $existingAttendances,
        ]);
    }

    public function bulkStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'activity_id' => ['required', 'exists:activities,id'],
            'attendances' => ['required', 'array'],
            'attendances.*.member_id' => ['required', 'exists:members,id'],
            'attendances.*.attendance_status' => ['required', Rule::in(self::STATUSES)],
            'attendances.*.notes' => ['nullable', 'string'],
        ]);

        $activity = Activity::findOrFail($validated['activity_id']);
        $attendanceDate = $this->attendanceDateFor($activity);

        foreach ($validated['attendances'] as $attendanceData) {
            Attendance::updateOrCreate(
                [
                    'activity_id' => $activity->id,
                    'member_id' => $attendanceData['member_id'],
                ],
                [
                    'created_by' => $request->user()->id,
                    'attendance_date' => $attendanceDate,
                    'status' => $attendanceData['attendance_status'],
                    'notes' => $attendanceData['notes'] ?? null,
                ]
            );
        }

        return redirect()
            ->route('attendances.index', ['activity_id' => $activity->id])
            ->with('success', 'Daftar hadir massal berhasil disimpan.');
    }

    private function validateAttendance(Request $request, ?Attendance $attendance = null): array
    {
        return $request->validate([
            'activity_id' => ['required', 'exists:activities,id'],
            'member_id' => [
                'required',
                'exists:members,id',
                Rule::unique('attendances', 'member_id')
                    ->where(fn ($query) => $query->where('activity_id', $request->activity_id))
                    ->ignore($attendance?->id),
            ],
            'attendance_status' => ['required', Rule::in(self::STATUSES)],
            'notes' => ['nullable', 'string'],
        ], [
            'member_id.unique' => 'Anggota ini sudah tercatat pada kegiatan yang dipilih.',
        ]);
    }

    private function attendancePayload(array $validated, Request $request, bool $withCreator = true): array
    {
        $activity = Activity::findOrFail($validated['activity_id']);

        $payload = [
            'activity_id' => $validated['activity_id'],
            'member_id' => $validated['member_id'],
            'attendance_date' => $this->attendanceDateFor($activity),
            'status' => $validated['attendance_status'],
            'notes' => $validated['notes'] ?? null,
        ];

        if ($withCreator) {
            $payload['created_by'] = $request->user()->id;
        }

        return $payload;
    }

    private function attendanceDateFor(Activity $activity): string
    {
        return ($activity->activity_date ?? $activity->started_at ?? now())->format('Y-m-d');
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

    private function memberOptions()
    {
        return Member::query()
            ->with('department')
            ->where('member_status', 'active')
            ->orderBy('full_name')
            ->orderBy('name')
            ->get();
    }
}
