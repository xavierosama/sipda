@extends('layouts.admin')

@section('title', 'Daftar Hadir')
@section('page-title', 'Daftar Hadir')
@section('page-subtitle', 'Kelola kehadiran kegiatan')

@section('content')
    @php
        $statusLabels = ['present' => 'Hadir', 'permission' => 'Izin', 'absent' => 'Tidak Hadir'];
    @endphp

    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        @endif

        <section class="grid gap-4 md:grid-cols-4">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Hadir</p>
                <p class="mt-3 text-2xl font-bold text-emerald-700">{{ $summary['present'] }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Izin</p>
                <p class="mt-3 text-2xl font-bold text-amber-700">{{ $summary['permission'] }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Tidak Hadir</p>
                <p class="mt-3 text-2xl font-bold text-red-700">{{ $summary['absent'] }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Peserta Tercatat</p>
                <p class="mt-3 text-2xl font-bold text-slate-950">{{ $summary['total'] }}</p>
            </div>
        </section>

        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
                <form method="GET" action="{{ route('attendances.index') }}" class="grid flex-1 gap-3 md:grid-cols-2 xl:grid-cols-[220px_220px_160px_160px_auto]">
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
                        <label for="member_id" class="block text-sm font-semibold text-slate-700">Anggota</label>
                        <select id="member_id" name="member_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Semua</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}" @selected((string) ($filters['member_id'] ?? '') === (string) $member->id)>{{ $member->full_name ?? $member->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="attendance_status" class="block text-sm font-semibold text-slate-700">Status</label>
                        <select id="attendance_status" name="attendance_status" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Semua</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(($filters['attendance_status'] ?? '') === $status)>{{ $statusLabels[$status] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="activity_date" class="block text-sm font-semibold text-slate-700">Tanggal Kegiatan</label>
                        <input type="date" id="activity_date" name="activity_date" value="{{ $filters['activity_date'] ?? '' }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Filter</button>
                        <a href="{{ route('attendances.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
                    </div>
                </form>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('attendances.bulk.create') }}" class="inline-flex items-center justify-center rounded-lg border border-emerald-200 px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-50">Input Massal</a>
                    <a href="{{ route('attendances.create') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Tambah Hadir</a>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Kegiatan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Anggota</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Bidang</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Catatan</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($attendances as $attendance)
                            <tr>
                                <td class="px-5 py-4 text-sm font-semibold text-slate-900">{{ $attendance->activity?->title ?? $attendance->activity?->name ?? '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">{{ optional($attendance->activity?->activity_date ?? $attendance->attendance_date)->format('d M Y') ?: '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $attendance->member?->full_name ?? $attendance->member?->name ?? '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $attendance->member?->department?->name ?: '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $attendance->status === 'present' ? 'bg-emerald-50 text-emerald-700' : ($attendance->status === 'permission' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700') }}">{{ $statusLabels[$attendance->status] ?? ucfirst($attendance->status) }}</span>
                                </td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($attendance->notes ?: '-', 70) }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('attendances.show', $attendance) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Detail</a>
                                        <a href="{{ route('attendances.edit', $attendance) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                                        <form method="POST" action="{{ route('attendances.destroy', $attendance) }}" onsubmit="return confirm('Hapus data kehadiran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 font-semibold text-red-700 hover:bg-red-50">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-sm text-slate-500">Data kehadiran belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">{{ $attendances->links() }}</div>
        </div>
    </div>
@endsection
