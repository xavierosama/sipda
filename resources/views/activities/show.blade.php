@extends('layouts.admin')

@section('title', 'Detail Agenda Kegiatan')
@section('page-title', 'Detail Agenda Kegiatan')
@section('page-subtitle', 'Informasi lengkap agenda kegiatan')

@section('content')
    @php
        $statusLabels = [
            'planned' => 'Planned',
            'ongoing' => 'Ongoing',
            'completed' => 'Completed',
            'postponed' => 'Postponed',
            'cancelled' => 'Cancelled',
        ];
    @endphp

    <div class="space-y-6">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">Agenda Kegiatan</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-950">{{ $activity->title ?? $activity->name }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $activity->program?->title ?? $activity->program?->name ?? 'Tanpa program terkait' }}</p>
                </div>
                <span class="w-fit rounded-full px-2.5 py-1 text-xs font-semibold {{ in_array($activity->status, ['completed', 'ongoing', 'planned'], true) ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ $statusLabels[$activity->status] ?? ucfirst($activity->status) }}
                </span>
            </div>

            <dl class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Program Terkait</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $activity->program?->title ?? $activity->program?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Bidang Penanggung Jawab</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $activity->department?->name ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">PIC</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $activity->pic?->full_name ?? $activity->pic?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Pembuat Data</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $activity->creator?->name ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Tanggal Kegiatan</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ optional($activity->activity_date ?? $activity->started_at)->format('d M Y') ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Waktu Kegiatan</dt>
                    <dd class="mt-1 text-sm text-slate-600">
                        {{ $activity->start_time ? substr($activity->start_time, 0, 5) : optional($activity->started_at)->format('H:i') ?: '-' }}
                        @if ($activity->end_time || $activity->ended_at)
                            - {{ $activity->end_time ? substr($activity->end_time, 0, 5) : optional($activity->ended_at)->format('H:i') }}
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Lokasi</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $activity->location ?: '-' }}</dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Deskripsi</dt>
                    <dd class="mt-1 text-sm leading-6 text-slate-600">{{ $activity->description ?: '-' }}</dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Catatan</dt>
                    <dd class="mt-1 text-sm leading-6 text-slate-600">{{ $activity->notes ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('activities.edit', $activity) }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Edit</a>
            <a href="{{ route('activities.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
        </div>
    </div>
@endsection
