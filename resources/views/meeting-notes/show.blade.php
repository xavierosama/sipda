@extends('layouts.admin')

@section('title', 'Detail Notulensi')
@section('page-title', 'Detail Notulensi')
@section('page-subtitle', 'Informasi lengkap catatan rapat')

@section('content')
    @php
        $statusLabels = ['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];
    @endphp

    <div class="space-y-6">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">Judul Rapat</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-950">{{ $meetingNote->title }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $meetingNote->activity?->title ?? $meetingNote->activity?->name ?? 'Tanpa kegiatan terkait' }}</p>
                </div>
                <span class="w-fit rounded-full px-2.5 py-1 text-xs font-semibold {{ $meetingNote->follow_up_status === 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ $statusLabels[$meetingNote->follow_up_status] ?? 'Tanpa status' }}
                </span>
            </div>

            <dl class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Kegiatan Terkait</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $meetingNote->activity?->title ?? $meetingNote->activity?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Tanggal dan Waktu</dt>
                    <dd class="mt-1 text-sm text-slate-600">
                        {{ optional($meetingNote->meeting_date ?? $meetingNote->meeting_at)->format('d M Y') ?: '-' }}
                        {{ $meetingNote->start_time ? substr($meetingNote->start_time, 0, 5) : optional($meetingNote->meeting_at)->format('H:i') }}
                        @if ($meetingNote->end_time)
                            - {{ substr($meetingNote->end_time, 0, 5) }}
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Tempat</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $meetingNote->location ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Pimpinan Rapat</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $meetingNote->leader?->full_name ?? $meetingNote->leader?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Notulis</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $meetingNote->noteTaker?->full_name ?? $meetingNote->noteTaker?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Pembuat Data</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $meetingNote->creator?->name ?: '-' }}</dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Peserta</dt>
                    <dd class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $meetingNote->participants ?: '-' }}</dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Agenda</dt>
                    <dd class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $meetingNote->agenda ?: '-' }}</dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Pembahasan</dt>
                    <dd class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $meetingNote->discussion ?? $meetingNote->content ?: '-' }}</dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Keputusan</dt>
                    <dd class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $meetingNote->decisions ?? $meetingNote->conclusion ?: '-' }}</dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Tindak Lanjut</dt>
                    <dd class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $meetingNote->follow_up ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">PIC Tindak Lanjut</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $meetingNote->followUpPic?->full_name ?? $meetingNote->followUpPic?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Deadline</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ optional($meetingNote->follow_up_deadline)->format('d M Y') ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Status Tindak Lanjut</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $statusLabels[$meetingNote->follow_up_status] ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('meeting-notes.edit', $meetingNote) }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Edit</a>
            <a href="{{ route('meeting-notes.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
        </div>
    </div>
@endsection
