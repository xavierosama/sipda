@csrf

@php
    $statusLabels = ['present' => 'Hadir', 'permission' => 'Izin', 'absent' => 'Tidak Hadir'];
@endphp

<div class="grid gap-5 lg:grid-cols-2">
    <div>
        <label for="activity_id" class="block text-sm font-semibold text-slate-700">Kegiatan</label>
        <select id="activity_id" name="activity_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
            <option value="">Pilih kegiatan</option>
            @foreach ($activities as $activity)
                <option value="{{ $activity->id }}" @selected((string) old('activity_id', $attendance->activity_id ?? '') === (string) $activity->id)>{{ $activity->title ?? $activity->name }}</option>
            @endforeach
        </select>
        @error('activity_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="member_id" class="block text-sm font-semibold text-slate-700">Anggota</label>
        <select id="member_id" name="member_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
            <option value="">Pilih anggota</option>
            @foreach ($members as $member)
                <option value="{{ $member->id }}" @selected((string) old('member_id', $attendance->member_id ?? '') === (string) $member->id)>{{ $member->full_name ?? $member->name }}</option>
            @endforeach
        </select>
        @error('member_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="attendance_status" class="block text-sm font-semibold text-slate-700">Status Kehadiran</label>
        <select id="attendance_status" name="attendance_status" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('attendance_status', $attendance->status ?? 'present') === $status)>{{ $statusLabels[$status] }}</option>
            @endforeach
        </select>
        @error('attendance_status')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-5">
    <label for="notes" class="block text-sm font-semibold text-slate-700">Catatan</label>
    <textarea id="notes" name="notes" rows="4" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('notes', $attendance->notes ?? '') }}</textarea>
    @error('notes')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div class="mt-6 flex flex-wrap items-center gap-3">
    <button type="submit" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">{{ $submitLabel }}</button>
    <a href="{{ route('attendances.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
</div>
