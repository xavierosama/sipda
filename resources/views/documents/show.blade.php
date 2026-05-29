@extends('layouts.admin')

@section('title', 'Detail Arsip Dokumen')
@section('page-title', 'Detail Arsip Dokumen')
@section('page-subtitle', 'Informasi lengkap dokumen')

@section('content')
    <div class="space-y-6">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">{{ $document->category ?: 'Dokumen' }}</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-950">{{ $document->title }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ optional($document->document_date)->format('d M Y') ?: 'Tanpa tanggal dokumen' }}</p>
                </div>
                <a href="{{ asset('storage/'.$document->file_path) }}" target="_blank" class="w-fit rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Lihat/Download File</a>
            </div>

            <dl class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Bidang</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $document->department?->name ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Kegiatan Terkait</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $document->activity?->title ?? $document->activity?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Pengunggah</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $document->uploader?->name ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Tipe File</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $document->mime_type ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Ukuran File</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $document->file_size ? number_format($document->file_size / 1024, 1, ',', '.') . ' KB' : '-' }}</dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Deskripsi</dt>
                    <dd class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $document->description ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('documents.edit', $document) }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Edit</a>
            <a href="{{ route('documents.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
        </div>
    </div>
@endsection
