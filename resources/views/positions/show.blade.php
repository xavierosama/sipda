@extends('layouts.admin')

@section('title', 'Detail Jabatan')
@section('page-title', 'Detail Jabatan')
@section('page-subtitle', 'Informasi data jabatan')

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">Nama Jabatan</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-950">{{ $position->name }}</h2>
                </div>
                <span class="w-fit rounded-full px-2.5 py-1 text-xs font-semibold {{ $position->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ ucfirst($position->status) }}
                </span>
            </div>

            <div class="mt-6">
                <p class="text-sm font-semibold text-slate-700">Deskripsi</p>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $position->description ?: '-' }}</p>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('positions.edit', $position) }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
                Edit
            </a>
            <a href="{{ route('positions.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Kembali
            </a>
        </div>
    </div>
@endsection
