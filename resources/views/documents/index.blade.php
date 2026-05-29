@extends('layouts.admin')

@section('title', 'Arsip Dokumen')
@section('page-title', 'Arsip Dokumen')
@section('page-subtitle', 'Kelola dokumen organisasi')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
                <form method="GET" action="{{ route('documents.index') }}" class="grid flex-1 gap-3 md:grid-cols-2 xl:grid-cols-[1fr_160px_190px_190px_160px_auto]">
                    <div>
                        <label for="search" class="block text-sm font-semibold text-slate-700">Cari Dokumen</label>
                        <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Judul atau deskripsi" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-semibold text-slate-700">Kategori</label>
                        <select id="category" name="category" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Semua</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" @selected(($filters['category'] ?? '') === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="department_id" class="block text-sm font-semibold text-slate-700">Bidang</label>
                        <select id="department_id" name="department_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Semua</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected((string) ($filters['department_id'] ?? '') === (string) $department->id)>{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="activity_id" class="block text-sm font-semibold text-slate-700">Kegiatan</label>
                        <select id="activity_id" name="activity_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Semua</option>
                            @foreach ($activities as $activity)
                                <option value="{{ $activity->id }}" @selected((string) ($filters['activity_id'] ?? '') === (string) $activity->id)>{{ $activity->title ?? $activity->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="document_date" class="block text-sm font-semibold text-slate-700">Tanggal</label>
                        <input type="date" id="document_date" name="document_date" value="{{ $filters['document_date'] ?? '' }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Filter</button>
                        <a href="{{ route('documents.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
                    </div>
                </form>

                <a href="{{ route('documents.create') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Tambah Dokumen</a>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Judul</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Kategori</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Bidang</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Kegiatan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Pengunggah</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($documents as $document)
                            <tr>
                                <td class="px-5 py-4 text-sm font-semibold text-slate-900">{{ $document->title }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $document->category ?: '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $document->department?->name ?: '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $document->activity?->title ?? $document->activity?->name ?? '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">{{ optional($document->document_date)->format('d M Y') ?: '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $document->uploader?->name ?: '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('documents.show', $document) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Detail</a>
                                        <a href="{{ route('documents.edit', $document) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                                        <form method="POST" action="{{ route('documents.destroy', $document) }}" onsubmit="return confirm('Arsipkan dokumen ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 font-semibold text-red-700 hover:bg-red-50">Arsipkan</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-sm text-slate-500">Arsip dokumen belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">{{ $documents->links() }}</div>
        </div>
    </div>
@endsection
