@extends('layouts.admin')

@section('title', 'Program Kerja')
@section('page-title', 'Program Kerja')
@section('page-subtitle', 'Kelola program kerja bidang')

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
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
                <form method="GET" action="{{ route('programs.index') }}" class="grid flex-1 gap-3 md:grid-cols-2 xl:grid-cols-[1fr_220px_170px_auto]">
                    <div>
                        <label for="search" class="block text-sm font-semibold text-slate-700">Cari Program</label>
                        <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Masukkan nama program" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
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
                        <label for="status" class="block text-sm font-semibold text-slate-700">Status</label>
                        <select id="status" name="status" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Semua</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $statusLabels[$status] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Filter</button>
                        <a href="{{ route('programs.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
                    </div>
                </form>

                <a href="{{ route('programs.create') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
                    Tambah Program
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Program</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Bidang</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">PIC</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Anggaran</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($programs as $program)
                            <tr>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-semibold text-slate-900">{{ $program->title ?? $program->name }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ optional($program->planned_date ?? $program->start_date)->format('d M Y') ?: 'Tanggal belum ditentukan' }}</p>
                                </td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $program->department?->name ?: '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $program->pic?->full_name ?? $program->pic?->name ?? '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">Rp{{ number_format((float) ($program->estimated_budget ?? 0), 0, ',', '.') }}</td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ in_array($program->status, ['completed', 'ongoing', 'planned'], true) ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $statusLabels[$program->status] ?? ucfirst($program->status) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('programs.show', $program) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Detail</a>
                                        <a href="{{ route('programs.edit', $program) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                                        @if ($program->status !== 'cancelled')
                                            <form method="POST" action="{{ route('programs.destroy', $program) }}" onsubmit="return confirm('Batalkan program kerja ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 font-semibold text-red-700 hover:bg-red-50">Batalkan</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-500">Program kerja belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">
                {{ $programs->links() }}
            </div>
        </div>
    </div>
@endsection
