<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\MeetingNote;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MeetingNoteController extends Controller
{
    private const FOLLOW_UP_STATUSES = ['pending', 'in_progress', 'completed', 'cancelled'];

    public function index(Request $request): View
    {
        $meetingNotes = MeetingNote::query()
            ->with(['activity', 'leader', 'noteTaker'])
            ->whereNull('archived_at')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%'.$request->search.'%')
                        ->orWhere('location', 'like', '%'.$request->search.'%')
                        ->orWhere('agenda', 'like', '%'.$request->search.'%')
                        ->orWhere('discussion', 'like', '%'.$request->search.'%')
                        ->orWhere('content', 'like', '%'.$request->search.'%');
                });
            })
            ->when($request->filled('meeting_date'), function ($query) use ($request) {
                $query->whereDate('meeting_date', $request->meeting_date);
            })
            ->when($request->filled('activity_id'), function ($query) use ($request) {
                $query->where('activity_id', $request->activity_id);
            })
            ->when($request->filled('follow_up_status'), function ($query) use ($request) {
                $query->where('follow_up_status', $request->follow_up_status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('meeting-notes.index', [
            'meetingNotes' => $meetingNotes,
            'activities' => $this->activityOptions(),
            'followUpStatuses' => self::FOLLOW_UP_STATUSES,
            'filters' => $request->only(['search', 'meeting_date', 'activity_id', 'follow_up_status']),
        ]);
    }

    public function create(): View
    {
        return view('meeting-notes.create', [
            'meetingNote' => new MeetingNote(['follow_up_status' => 'pending']),
            'activities' => $this->activityOptions(),
            'members' => $this->memberOptions(),
            'followUpStatuses' => self::FOLLOW_UP_STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateMeetingNote($request);

        MeetingNote::create($this->meetingNotePayload($validated, $request));

        return redirect()
            ->route('meeting-notes.index')
            ->with('success', 'Notulensi berhasil ditambahkan.');
    }

    public function show(MeetingNote $meetingNote): View
    {
        $meetingNote->load(['activity', 'leader', 'noteTaker', 'followUpPic', 'creator']);

        return view('meeting-notes.show', compact('meetingNote'));
    }

    public function edit(MeetingNote $meetingNote): View
    {
        return view('meeting-notes.edit', [
            'meetingNote' => $meetingNote,
            'activities' => $this->activityOptions(),
            'members' => $this->memberOptions(),
            'followUpStatuses' => self::FOLLOW_UP_STATUSES,
        ]);
    }

    public function update(Request $request, MeetingNote $meetingNote): RedirectResponse
    {
        $validated = $this->validateMeetingNote($request);

        $meetingNote->update($this->meetingNotePayload($validated, $request, false));

        return redirect()
            ->route('meeting-notes.index')
            ->with('success', 'Notulensi berhasil diperbarui.');
    }

    public function destroy(MeetingNote $meetingNote): RedirectResponse
    {
        $meetingNote->update(['archived_at' => now()]);

        return redirect()
            ->route('meeting-notes.index')
            ->with('success', 'Notulensi berhasil diarsipkan.');
    }

    private function validateMeetingNote(Request $request): array
    {
        return $request->validate([
            'activity_id' => ['nullable', 'exists:activities,id'],
            'title' => ['required', 'string', 'max:255'],
            'meeting_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'leader_id' => ['nullable', 'exists:members,id'],
            'note_taker_id' => ['nullable', 'exists:members,id'],
            'participants' => ['nullable', 'string'],
            'agenda' => ['nullable', 'string'],
            'discussion' => ['nullable', 'string'],
            'decisions' => ['nullable', 'string'],
            'follow_up' => ['nullable', 'string'],
            'follow_up_pic_id' => ['nullable', 'exists:members,id'],
            'follow_up_deadline' => ['nullable', 'date'],
            'follow_up_status' => ['nullable', Rule::in(self::FOLLOW_UP_STATUSES)],
        ]);
    }

    private function meetingNotePayload(array $validated, Request $request, bool $withCreator = true): array
    {
        $payload = [
            ...$validated,
            'member_id' => $validated['note_taker_id'] ?? null,
            'meeting_at' => $this->dateTimeFrom($validated['meeting_date'], $validated['start_time'] ?? null),
            'content' => $validated['discussion'] ?? null,
            'conclusion' => $validated['decisions'] ?? null,
        ];

        if ($withCreator) {
            $payload['created_by'] = $request->user()->id;
        }

        return $payload;
    }

    private function dateTimeFrom(string $date, ?string $time): Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i', $date.' '.($time ?: '00:00'));
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
            ->where('member_status', 'active')
            ->orderBy('full_name')
            ->orderBy('name')
            ->get();
    }
}
