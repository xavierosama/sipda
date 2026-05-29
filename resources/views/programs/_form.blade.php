@csrf

@php
    $statusLabels = [
        'draft' => 'Draft',
        'planned' => 'Planned',
        'ongoing' => 'Ongoing',
        'completed' => 'Completed',
        'postponed' => 'Postponed',
        'cancelled' => 'Cancelled',
    ];
@endphp

<div class="grid gap-5 lg:grid-cols-2">
    <div>
        <label for="department_id" class="block text-sm font-semibold text-slate-700">Bidang</label>
        <select id="department_id" name="department_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
            <option value="">Pilih bidang</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}" @selected((string) old('department_id', $program->department_id ?? '') === (string) $department->id)>{{ $department->name }}</option>
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
                <option value="{{ $member->id }}" @selected((string) old('pic_id', $program->pic_id ?? $program->member_id ?? '') === (string) $member->id)>{{ $member->full_name ?? $member->name }}</option>
            @endforeach
        </select>
        @error('pic_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="lg:col-span-2">
        <label for="title" class="block text-sm font-semibold text-slate-700">Nama Program</label>
        <input type="text" id="title" name="title" value="{{ old('title', $program->title ?? $program->name ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required autofocus>
        @error('title')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="lg:col-span-2">
        <label for="objective" class="block text-sm font-semibold text-slate-700">Tujuan</label>
        <textarea id="objective" name="objective" rows="3" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('objective', $program->objective ?? $program->description ?? '') }}</textarea>
        @error('objective')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="target" class="block text-sm font-semibold text-slate-700">Target</label>
        <textarea id="target" name="target" rows="3" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('target', $program->target ?? '') }}</textarea>
        @error('target')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="audience" class="block text-sm font-semibold text-slate-700">Sasaran Peserta</label>
        <input type="text" id="audience" name="audience" value="{{ old('audience', $program->audience ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('audience')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="planned_date" class="block text-sm font-semibold text-slate-700">Tanggal Rencana</label>
        <input type="date" id="planned_date" name="planned_date" value="{{ old('planned_date', optional($program->planned_date ?? $program->start_date ?? null)->format('Y-m-d')) }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('planned_date')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="location" class="block text-sm font-semibold text-slate-700">Lokasi</label>
        <input type="text" id="location" name="location" value="{{ old('location', $program->location ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('location')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="estimated_budget" class="block text-sm font-semibold text-slate-700">Estimasi Anggaran</label>
        <input type="number" step="0.01" min="0" id="estimated_budget" name="estimated_budget" value="{{ old('estimated_budget', isset($program->estimated_budget) ? number_format((float) $program->estimated_budget, 2, '.', '') : '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('estimated_budget')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="block text-sm font-semibold text-slate-700">Status</label>
        <select id="status" name="status" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $program->status ?? 'draft') === $status)>{{ $statusLabels[$status] }}</option>
            @endforeach
        </select>
        @error('status')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-5">
    <label for="notes" class="block text-sm font-semibold text-slate-700">Catatan</label>
    <textarea id="notes" name="notes" rows="3" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('notes', $program->notes ?? '') }}</textarea>
    @error('notes')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6 flex flex-wrap items-center gap-3">
    <button type="submit" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
        {{ $submitLabel }}
    </button>
    <a href="{{ route('programs.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
        Batal
    </a>
</div>
