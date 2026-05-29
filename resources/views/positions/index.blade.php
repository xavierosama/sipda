@extends('layouts.admin')

@section('title', 'Data Jabatan')
@section('page-title', 'Data Jabatan')
@section('page-subtitle', 'Kelola data jabatan organisasi')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <form method="GET" action="{{ route('positions.index') }}" class="grid flex-1 gap-3 md:grid-cols-[1fr_180px_auto]">
                    <div>
                        <label for="search" class="block text-sm font-semibold text-slate-700">Cari Nama Jabatan</label>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ $filters['search'] ?? '' }}"
                            placeholder="Masukkan nama jabatan"
                            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                        >
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-700">Status</label>
                        <select
                            id="status"
                            name="status"
                            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
                        >
                            <option value="">Semua</option>
                            <option value="active" @selected(($filters['status'] ?? '') === 'active')>Active</option>
                            <option value="inactive" @selected(($filters['status'] ?? '') === 'inactive')>Inactive</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                            Filter
                        </button>
                        <a href="{{ route('positions.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Reset
                        </a>
                    </div>
                </form>

                <a href="{{ route('positions.create') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
                    Tambah Jabatan
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Jabatan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Deskripsi</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($positions as $position)
                            <tr>
                                <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-900">{{ $position->name }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $position->description ?: '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $position->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($position->status) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('positions.show', $position) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Detail</a>
                                        <a href="{{ route('positions.edit', $position) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                                        @if ($position->status === 'active')
                                            <form method="POST" action="{{ route('positions.destroy', $position) }}" onsubmit="return confirm('Nonaktifkan jabatan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 font-semibold text-red-700 hover:bg-red-50">
                                                    Nonaktifkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-sm text-slate-500">
                                    Data jabatan belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">
                {{ $positions->links() }}
            </div>
        </div>
    </div>
@endsection
