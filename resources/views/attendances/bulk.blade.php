@extends('layouts.admin')

@section('title', 'Input Massal Daftar Hadir')
@section('page-title', 'Input Massal Daftar Hadir')
@section('page-subtitle', 'Catat banyak anggota dalam satu kegiatan')

@section('content')
    @php
        $statusLabels = ['present' => 'Hadir', 'permission' => 'Izin', 'absent' => 'Tidak Hadir'];
    @endphp

    <div class="space-y-6">
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route('attendances.bulk.create') }}" class="grid gap-3 md:grid-cols-[1fr_auto]">
                <div>
                    <label for="activity_id" class="block text-sm font-semibold text-slate-700">Kegiatan</label>
                    <select id="activity_id" name="activity_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                        <option value="">Pilih kegiatan</option>
                        @foreach ($activities as $activity)
                            <option value="{{ $activity->id }}" @selected((string) request('activity_id') === (string) $activity->id)>{{ $activity->title ?? $activity->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Tampilkan Anggota</button>
                </div>
            </form>
        </div>

        @if ($selectedActivity)
            <form method="POST" action="{{ route('attendances.bulk.store') }}" class="rounded-lg border border-slate-200 bg-white shadow-sm">
                @csrf
                <input type="hidden" name="activity_id" value="{{ $selectedActivity->id }}">

                <div class="border-b border-slate-200 p-5">
                    <h2 class="text-base font-semibold text-slate-950">{{ $selectedActivity->title ?? $selectedActivity->name }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ optional($selectedActivity->activity_date ?? $selectedActivity->started_at)->format('d M Y') ?: 'Tanggal belum tersedia' }}</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Anggota</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Bidang</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach ($members as $member)
                                @php($existing = $existingAttendances->get($member->id))
                                <tr>
                                    <td class="px-5 py-4 text-sm font-semibold text-slate-900">
                                        {{ $member->full_name ?? $member->name }}
                                        <input type="hidden" name="attendances[{{ $loop->index }}][member_id]" value="{{ $member->id }}">
                                    </td>
                                    <td class="px-5 py-4 text-sm text-slate-600">{{ $member->department?->name ?: '-' }}</td>
                                    <td class="px-5 py-4">
                                        <select name="attendances[{{ $loop->index }}][attendance_status]" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}" @selected(($existing->status ?? 'present') === $status)>{{ $statusLabels[$status] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-5 py-4">
                                        <input type="text" name="attendances[{{ $loop->index }}][notes]" value="{{ $existing->notes ?? '' }}" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-wrap gap-3 border-t border-slate-200 p-5">
                    <button type="submit" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Simpan Daftar Hadir</button>
                    <a href="{{ route('attendances.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                </div>
            </form>
        @endif
    </div>
@endsection
