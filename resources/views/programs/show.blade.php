@extends('layouts.admin')

@section('title', 'Detail Program Kerja')
@section('page-title', 'Detail Program Kerja')
@section('page-subtitle', 'Informasi program kerja bidang')

@section('content')
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

    <div class="space-y-6">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">Program Kerja</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-950">{{ $program->title ?? $program->name }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $program->department?->name ?: 'Bidang belum dipilih' }}</p>
                </div>
                <span class="w-fit rounded-full px-2.5 py-1 text-xs font-semibold {{ in_array($program->status, ['completed', 'ongoing', 'planned'], true) ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ $statusLabels[$program->status] ?? ucfirst($program->status) }}
                </span>
            </div>

            <dl class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <div>
                    <dt class="text-sm font-semibold text-slate-700">PIC</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $program->pic?->full_name ?? $program->pic?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Tanggal Rencana</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ optional($program->planned_date ?? $program->start_date)->format('d M Y') ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Estimasi Anggaran</dt>
                    <dd class="mt-1 text-sm text-slate-600">Rp{{ number_format((float) ($program->estimated_budget ?? 0), 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Sasaran Peserta</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $program->audience ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Lokasi</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $program->location ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Dibuat Oleh</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $program->creator?->name ?: '-' }}</dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Tujuan</dt>
                    <dd class="mt-1 text-sm leading-6 text-slate-600">{{ $program->objective ?? $program->description ?: '-' }}</dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Target</dt>
                    <dd class="mt-1 text-sm leading-6 text-slate-600">{{ $program->target ?: '-' }}</dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Catatan</dt>
                    <dd class="mt-1 text-sm leading-6 text-slate-600">{{ $program->notes ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('programs.edit', $program) }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Edit</a>
            <a href="{{ route('programs.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
        </div>
    </div>
@endsection
