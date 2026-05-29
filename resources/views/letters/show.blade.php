@extends('layouts.admin')

@section('title', 'Detail Surat')
@section('page-title', 'Detail Surat')
@section('page-subtitle', 'Informasi lengkap surat')

@section('content')
    @php
        $typeLabels = ['incoming' => 'Surat Masuk', 'outgoing' => 'Surat Keluar'];
        $statusLabels = ['draft' => 'Draft', 'sent' => 'Sent', 'received' => 'Received', 'archived' => 'Archived', 'cancelled' => 'Cancelled'];
    @endphp

    <div class="space-y-6">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">{{ $typeLabels[$letter->type] ?? ucfirst($letter->type) }}</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-950">{{ $letter->subject }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $letter->letter_number }}</p>
                </div>
                <span class="w-fit rounded-full px-2.5 py-1 text-xs font-semibold {{ in_array($letter->status, ['sent', 'received', 'archived'], true) ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ $statusLabels[$letter->status] ?? ucfirst($letter->status) }}
                </span>
            </div>

            <dl class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Tanggal Surat</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ optional($letter->letter_date)->format('d M Y') ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Tanggal Diterima/Dikirim</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ optional($letter->received_or_sent_date ?? $letter->received_date)->format('d M Y') ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Kategori</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $letter->category ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Pengirim</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $letter->sender ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Penerima</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $letter->recipient ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Kegiatan Terkait</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $letter->activity?->title ?? $letter->activity?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Pembuat Data</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $letter->creator?->name ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">File Surat</dt>
                    <dd class="mt-1 text-sm text-slate-600">
                        @if ($letter->file_path)
                            <a href="{{ asset('storage/'.$letter->file_path) }}" target="_blank" class="font-semibold text-emerald-700 hover:text-emerald-800">Lihat/download file</a>
                        @else
                            -
                        @endif
                    </dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Catatan</dt>
                    <dd class="mt-1 text-sm leading-6 text-slate-600">{{ $letter->notes ?? $letter->description ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('letters.edit', $letter) }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Edit</a>
            <a href="{{ route('letters.index', ['type' => $letter->type]) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
        </div>
    </div>
@endsection
