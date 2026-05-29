@extends('layouts.admin')

@section('title', 'Agenda Kegiatan')
@section('page-title', 'Agenda Kegiatan')
@section('page-subtitle', 'Kelola agenda kegiatan organisasi')

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
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
                <form method="GET" action="{{ route('activities.index') }}" class="grid flex-1 gap-3 md:grid-cols-2 xl:grid-cols-[1fr_190px_190px_150px_160px_auto]">
                    <div>
                        <label for="search" class="block text-sm font-semibold text-slate-700">Cari Kegiatan</label>
                        <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Masukkan nama kegiatan" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
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
                        <label for="program_id" class="block text-sm font-semibold text-slate-700">Program</label>
                        <select id="program_id" name="program_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Semua</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}" @selected((string) ($filters['program_id'] ?? '') === (string) $program->id)>{{ $program->title ?? $program->name }}</option>
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
                    <div>
                        <label for="activity_date" class="block text-sm font-semibold text-slate-700">Tanggal</label>
                        <input type="date" id="activity_date" name="activity_date" value="{{ $filters['activity_date'] ?? '' }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Filter</button>
                        <a href="{{ route('activities.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
                    </div>
                </form>

                <a href="{{ route('activities.create') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
                    Tambah Kegiatan
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Kegiatan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Program</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Bidang</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">PIC</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Waktu & Tempat</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($activities as $activity)
                            <tr>
                                <td class="px-5 py-4 text-sm font-semibold text-slate-900">{{ $activity->title ?? $activity->name }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $activity->program?->title ?? $activity->program?->name ?? '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $activity->department?->name ?: '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $activity->pic?->full_name ?? $activity->pic?->name ?? '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">
                                    <p>{{ optional($activity->activity_date ?? $activity->started_at)->format('d M Y') ?: '-' }}</p>
                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $activity->start_time ? substr($activity->start_time, 0, 5) : optional($activity->started_at)->format('H:i') }}
                                        @if ($activity->end_time || $activity->ended_at)
                                            - {{ $activity->end_time ? substr($activity->end_time, 0, 5) : optional($activity->ended_at)->format('H:i') }}
                                        @endif
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $activity->location ?: '-' }}</p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ in_array($activity->status, ['completed', 'ongoing', 'planned'], true) ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $statusLabels[$activity->status] ?? ucfirst($activity->status) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('activities.show', $activity) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Detail</a>
                                        <a href="{{ route('activities.edit', $activity) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                                        @if ($activity->status !== 'cancelled')
                                            <form method="POST" action="{{ route('activities.destroy', $activity) }}" onsubmit="return confirm('Batalkan kegiatan ini?')">
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
                                <td colspan="7" class="px-5 py-10 text-center text-sm text-slate-500">Agenda kegiatan belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
@endsection
