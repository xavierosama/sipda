@csrf

@php
    $statusLabels = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];
@endphp

<div class="grid gap-5 lg:grid-cols-2">
    <div>
        <label for="activity_id" class="block text-sm font-semibold text-slate-700">Kegiatan Terkait</label>
        <select id="activity_id" name="activity_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih kegiatan</option>
            @foreach ($activities as $activity)
                <option value="{{ $activity->id }}" @selected((string) old('activity_id', $meetingNote->activity_id ?? '') === (string) $activity->id)>{{ $activity->title ?? $activity->name }}</option>
            @endforeach
        </select>
        @error('activity_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="title" class="block text-sm font-semibold text-slate-700">Judul Rapat</label>
        <input type="text" id="title" name="title" value="{{ old('title', $meetingNote->title ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required autofocus>
        @error('title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="meeting_date" class="block text-sm font-semibold text-slate-700">Tanggal Rapat</label>
        <input type="date" id="meeting_date" name="meeting_date" value="{{ old('meeting_date', optional($meetingNote->meeting_date ?? $meetingNote->meeting_at ?? null)->format('Y-m-d')) }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
        @error('meeting_date')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="location" class="block text-sm font-semibold text-slate-700">Tempat</label>
        <input type="text" id="location" name="location" value="{{ old('location', $meetingNote->location ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('location')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="start_time" class="block text-sm font-semibold text-slate-700">Waktu Mulai</label>
        <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $meetingNote->start_time ?? optional($meetingNote->meeting_at ?? null)->format('H:i')) }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('start_time')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="end_time" class="block text-sm font-semibold text-slate-700">Waktu Selesai</label>
        <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $meetingNote->end_time ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('end_time')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="leader_id" class="block text-sm font-semibold text-slate-700">Pimpinan Rapat</label>
        <select id="leader_id" name="leader_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih pimpinan rapat</option>
            @foreach ($members as $member)
                <option value="{{ $member->id }}" @selected((string) old('leader_id', $meetingNote->leader_id ?? '') === (string) $member->id)>{{ $member->full_name ?? $member->name }}</option>
            @endforeach
        </select>
        @error('leader_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="note_taker_id" class="block text-sm font-semibold text-slate-700">Notulis</label>
        <select id="note_taker_id" name="note_taker_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih notulis</option>
            @foreach ($members as $member)
                <option value="{{ $member->id }}" @selected((string) old('note_taker_id', $meetingNote->note_taker_id ?? $meetingNote->member_id ?? '') === (string) $member->id)>{{ $member->full_name ?? $member->name }}</option>
            @endforeach
        </select>
        @error('note_taker_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-5">
    <label for="participants" class="block text-sm font-semibold text-slate-700">Peserta</label>
    <textarea id="participants" name="participants" rows="3" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('participants', $meetingNote->participants ?? '') }}</textarea>
    @error('participants')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div class="mt-5 grid gap-5 lg:grid-cols-2">
    <div>
        <label for="agenda" class="block text-sm font-semibold text-slate-700">Agenda</label>
        <textarea id="agenda" name="agenda" rows="5" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('agenda', $meetingNote->agenda ?? '') }}</textarea>
        @error('agenda')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="discussion" class="block text-sm font-semibold text-slate-700">Pembahasan</label>
        <textarea id="discussion" name="discussion" rows="5" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('discussion', $meetingNote->discussion ?? $meetingNote->content ?? '') }}</textarea>
        @error('discussion')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="decisions" class="block text-sm font-semibold text-slate-700">Keputusan</label>
        <textarea id="decisions" name="decisions" rows="4" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('decisions', $meetingNote->decisions ?? $meetingNote->conclusion ?? '') }}</textarea>
        @error('decisions')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="follow_up" class="block text-sm font-semibold text-slate-700">Tindak Lanjut</label>
        <textarea id="follow_up" name="follow_up" rows="4" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('follow_up', $meetingNote->follow_up ?? '') }}</textarea>
        @error('follow_up')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-5 grid gap-5 lg:grid-cols-3">
    <div>
        <label for="follow_up_pic_id" class="block text-sm font-semibold text-slate-700">PIC Tindak Lanjut</label>
        <select id="follow_up_pic_id" name="follow_up_pic_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih PIC</option>
            @foreach ($members as $member)
                <option value="{{ $member->id }}" @selected((string) old('follow_up_pic_id', $meetingNote->follow_up_pic_id ?? '') === (string) $member->id)>{{ $member->full_name ?? $member->name }}</option>
            @endforeach
        </select>
        @error('follow_up_pic_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="follow_up_deadline" class="block text-sm font-semibold text-slate-700">Deadline</label>
        <input type="date" id="follow_up_deadline" name="follow_up_deadline" value="{{ old('follow_up_deadline', optional($meetingNote->follow_up_deadline ?? null)->format('Y-m-d')) }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('follow_up_deadline')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="follow_up_status" class="block text-sm font-semibold text-slate-700">Status Tindak Lanjut</label>
        <select id="follow_up_status" name="follow_up_status" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih status</option>
            @foreach ($followUpStatuses as $status)
                <option value="{{ $status }}" @selected(old('follow_up_status', $meetingNote->follow_up_status ?? 'pending') === $status)>{{ $statusLabels[$status] }}</option>
            @endforeach
        </select>
        @error('follow_up_status')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-6 flex flex-wrap items-center gap-3">
    <button type="submit" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">{{ $submitLabel }}</button>
    <a href="{{ route('meeting-notes.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
</div>
