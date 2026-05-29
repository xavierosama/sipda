@extends('layouts.admin')

@section('title', 'Detail Daftar Hadir')
@section('page-title', 'Detail Daftar Hadir')
@section('page-subtitle', 'Informasi kehadiran anggota')

@section('content')
    @php
        $statusLabels = ['present' => 'Hadir', 'permission' => 'Izin', 'absent' => 'Tidak Hadir'];
    @endphp

    <div class="max-w-3xl space-y-6">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">Daftar Hadir</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-950">{{ $attendance->member?->full_name ?? $attendance->member?->name ?? '-' }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $attendance->activity?->title ?? $attendance->activity?->name ?? '-' }}</p>
                </div>
                <span class="w-fit rounded-full px-2.5 py-1 text-xs font-semibold {{ $attendance->status === 'present' ? 'bg-emerald-50 text-emerald-700' : ($attendance->status === 'permission' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700') }}">{{ $statusLabels[$attendance->status] ?? ucfirst($attendance->status) }}</span>
            </div>

            <dl class="mt-6 grid gap-5 md:grid-cols-2">
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Tanggal Kegiatan</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ optional($attendance->activity?->activity_date ?? $attendance->attendance_date)->format('d M Y') ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Bidang Anggota</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $attendance->member?->department?->name ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Pencatat</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $attendance->creator?->name ?: '-' }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-sm font-semibold text-slate-700">Catatan</dt>
                    <dd class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $attendance->notes ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('attendances.edit', $attendance) }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Edit</a>
            <a href="{{ route('attendances.index', ['activity_id' => $attendance->activity_id]) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
        </div>
    </div>
@endsection
