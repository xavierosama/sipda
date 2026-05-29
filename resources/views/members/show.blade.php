@extends('layouts.admin')

@section('title', 'Detail Anggota')
@section('page-title', 'Detail Anggota')
@section('page-subtitle', 'Informasi data anggota')

@section('content')
    <div class="space-y-6">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">Nama Lengkap</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-950">{{ $member->full_name ?? $member->name }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $member->member_number ?: 'Tanpa nomor anggota' }}</p>
                </div>
                <span class="w-fit rounded-full px-2.5 py-1 text-xs font-semibold {{ ($member->member_status ?? $member->status) === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ ucfirst($member->member_status ?? $member->status) }}
                </span>
            </div>

            <dl class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Tempat, Tanggal Lahir</dt>
                    <dd class="mt-1 text-sm text-slate-600">
                        {{ $member->birth_place ?? $member->place_of_birth ?: '-' }},
                        {{ optional($member->birth_date ?? $member->date_of_birth)->format('d M Y') ?: '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Jenis Kelamin</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $member->gender === 'male' ? 'Laki-laki' : ($member->gender === 'female' ? 'Perempuan' : '-') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Tanggal Bergabung</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ optional($member->joined_at)->format('d M Y') ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Telepon</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $member->phone ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Email</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $member->email ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Bidang</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $member->department?->name ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Jabatan</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $member->position?->name ?: '-' }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-sm font-semibold text-slate-700">Alamat</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $member->address ?: '-' }}</dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Catatan</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $member->notes ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('members.edit', $member) }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Edit</a>
            <a href="{{ route('members.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
        </div>
    </div>
@endsection
