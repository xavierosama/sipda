@csrf

@php
    $statusLabels = [
        'planned' => 'Planned',
        'ongoing' => 'Ongoing',
        'completed' => 'Completed',
        'postponed' => 'Postponed',
        'cancelled' => 'Cancelled',
    ];
@endphp

<div class="grid gap-5 lg:grid-cols-2">
    <div>
        <label for="program_id" class="block text-sm font-semibold text-slate-700">Program Terkait</label>
        <select id="program_id" name="program_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih program</option>
            @foreach ($programs as $program)
                <option value="{{ $program->id }}" @selected((string) old('program_id', $activity->program_id ?? '') === (string) $program->id)>{{ $program->title ?? $program->name }}</option>
            @endforeach
        </select>
        @error('program_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="department_id" class="block text-sm font-semibold text-slate-700">Bidang</label>
        <select id="department_id" name="department_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih bidang</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}" @selected((string) old('department_id', $activity->department_id ?? '') === (string) $department->id)>{{ $department->name }}</option>
            @endforeach
        </select>
        @error('department_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="pic_id" class="block text-sm font-semibold text-slate-700">PIC</label>
        <select id="pic_id" name="pic_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih PIC</option>
            @foreach ($members as $member)
                <option value="{{ $member->id }}" @selected((string) old('pic_id', $activity->pic_id ?? $activity->member_id ?? '') === (string) $member->id)>{{ $member->full_name ?? $member->name }}</option>
            @endforeach
        </select>
        @error('pic_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="block text-sm font-semibold text-slate-700">Status</label>
        <select id="status" name="status" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $activity->status ?? 'planned') === $status)>{{ $statusLabels[$status] }}</option>
            @endforeach
        </select>
        @error('status')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="lg:col-span-2">
        <label for="title" class="block text-sm font-semibold text-slate-700">Nama Kegiatan</label>
        <input type="text" id="title" name="title" value="{{ old('title', $activity->title ?? $activity->name ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required autofocus>
        @error('title')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="activity_date" class="block text-sm font-semibold text-slate-700">Tanggal Kegiatan</label>
        <input type="date" id="activity_date" name="activity_date" value="{{ old('activity_date', optional($activity->activity_date ?? $activity->started_at ?? null)->format('Y-m-d')) }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
        @error('activity_date')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="location" class="block text-sm font-semibold text-slate-700">Lokasi</label>
        <input type="text" id="location" name="location" value="{{ old('location', $activity->location ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('location')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="start_time" class="block text-sm font-semibold text-slate-700">Waktu Mulai</label>
        <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $activity->start_time ?? optional($activity->started_at ?? null)->format('H:i')) }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('start_time')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="end_time" class="block text-sm font-semibold text-slate-700">Waktu Selesai</label>
        <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $activity->end_time ?? optional($activity->ended_at ?? null)->format('H:i')) }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('end_time')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-5">
    <label for="description" class="block text-sm font-semibold text-slate-700">Deskripsi</label>
    <textarea id="description" name="description" rows="4" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('description', $activity->description ?? '') }}</textarea>
    @error('description')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-5">
    <label for="notes" class="block text-sm font-semibold text-slate-700">Catatan</label>
    <textarea id="notes" name="notes" rows="3" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('notes', $activity->notes ?? '') }}</textarea>
    @error('notes')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6 flex flex-wrap items-center gap-3">
    <button type="submit" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
        {{ $submitLabel }}
    </button>
    <a href="{{ route('activities.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
        Batal
    </a>
</div>
