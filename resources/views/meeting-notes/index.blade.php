@extends('layouts.admin')

@section('title', 'Notulensi')
@section('page-title', 'Notulensi')
@section('page-subtitle', 'Kelola catatan rapat dan tindak lanjut')

@section('content')
    @php
        $statusLabels = ['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];
    @endphp

    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
                <form method="GET" action="{{ route('meeting-notes.index') }}" class="grid flex-1 gap-3 md:grid-cols-2 xl:grid-cols-[1fr_160px_220px_170px_auto]">
                    <div>
                        <label for="search" class="block text-sm font-semibold text-slate-700">Cari Notulensi</label>
                        <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Judul, lokasi, agenda, pembahasan" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                    </div>
                    <div>
                        <label for="meeting_date" class="block text-sm font-semibold text-slate-700">Tanggal</label>
                        <input type="date" id="meeting_date" name="meeting_date" value="{{ $filters['meeting_date'] ?? '' }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
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
                        <label for="follow_up_status" class="block text-sm font-semibold text-slate-700">Tindak Lanjut</label>
                        <select id="follow_up_status" name="follow_up_status" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Semua</option>
                            @foreach ($followUpStatuses as $status)
                                <option value="{{ $status }}" @selected(($filters['follow_up_status'] ?? '') === $status)>{{ $statusLabels[$status] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Filter</button>
                        <a href="{{ route('meeting-notes.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
                    </div>
                </form>

                <a href="{{ route('meeting-notes.create') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Tambah Notulensi</a>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Judul</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Lokasi</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Pimpinan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Notulis</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tindak Lanjut</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($meetingNotes as $meetingNote)
                            <tr>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-semibold text-slate-900">{{ $meetingNote->title }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $meetingNote->activity?->title ?? $meetingNote->activity?->name ?? 'Tanpa kegiatan' }}</p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">{{ optional($meetingNote->meeting_date ?? $meetingNote->meeting_at)->format('d M Y') ?: '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $meetingNote->location ?: '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $meetingNote->leader?->full_name ?? $meetingNote->leader?->name ?? '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $meetingNote->noteTaker?->full_name ?? $meetingNote->noteTaker?->name ?? '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $meetingNote->follow_up_status === 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $statusLabels[$meetingNote->follow_up_status] ?? '-' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('meeting-notes.show', $meetingNote) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Detail</a>
                                        <a href="{{ route('meeting-notes.edit', $meetingNote) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                                        <form method="POST" action="{{ route('meeting-notes.destroy', $meetingNote) }}" onsubmit="return confirm('Arsipkan notulensi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 font-semibold text-red-700 hover:bg-red-50">Arsipkan</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-sm text-slate-500">Notulensi belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">{{ $meetingNotes->links() }}</div>
        </div>
    </div>
@endsection
