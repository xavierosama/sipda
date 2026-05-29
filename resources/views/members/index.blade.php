@extends('layouts.admin')

@section('title', 'Data Anggota')
@section('page-title', 'Data Anggota')
@section('page-subtitle', 'Kelola data anggota Pemuda Persis Cirengit')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
                <form method="GET" action="{{ route('members.index') }}" class="grid flex-1 gap-3 md:grid-cols-2 xl:grid-cols-[1fr_180px_180px_160px_auto]">
                    <div>
                        <label for="search" class="block text-sm font-semibold text-slate-700">Cari Anggota</label>
                        <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama, telepon, atau email" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
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
                        <label for="position_id" class="block text-sm font-semibold text-slate-700">Jabatan</label>
                        <select id="position_id" name="position_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Semua</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}" @selected((string) ($filters['position_id'] ?? '') === (string) $position->id)>{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="member_status" class="block text-sm font-semibold text-slate-700">Status</label>
                        <select id="member_status" name="member_status" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Semua</option>
                            <option value="active" @selected(($filters['member_status'] ?? '') === 'active')>Active</option>
                            <option value="inactive" @selected(($filters['member_status'] ?? '') === 'inactive')>Inactive</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Filter</button>
                        <a href="{{ route('members.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
                    </div>
                </form>

                <a href="{{ route('members.create') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
                    Tambah Anggota
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Anggota</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Kontak</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Bidang</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Jabatan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($members as $member)
                            <tr>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-semibold text-slate-900">{{ $member->full_name ?? $member->name }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $member->member_number ?: 'Tanpa nomor anggota' }}</p>
                                </td>
                                <td class="px-5 py-4 text-sm text-slate-600">
                                    <p>{{ $member->phone ?: '-' }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $member->email ?: '-' }}</p>
                                </td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $member->department?->name ?: '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $member->position?->name ?: '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $member->member_status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($member->member_status ?? $member->status) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('members.show', $member) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Detail</a>
                                        <a href="{{ route('members.edit', $member) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                                        @if (($member->member_status ?? $member->status) === 'active')
                                            <form method="POST" action="{{ route('members.destroy', $member) }}" onsubmit="return confirm('Nonaktifkan anggota ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 font-semibold text-red-700 hover:bg-red-50">Nonaktifkan</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-500">Data anggota belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">
                {{ $members->links() }}
            </div>
        </div>
    </div>
@endsection
