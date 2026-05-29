@extends('layouts.admin')

@section('title', 'Detail Kategori Transaksi')
@section('page-title', 'Detail Kategori Transaksi')
@section('page-subtitle', 'Informasi kategori kas')

@section('content')
    @php
        $typeLabels = ['income' => 'Kas Masuk', 'expense' => 'Kas Keluar', 'both' => 'Keduanya'];
    @endphp

    <div class="max-w-3xl space-y-6">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">Kategori Transaksi</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-950">{{ $cashCategory->name }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $typeLabels[$cashCategory->type] ?? 'Tanpa type' }}</p>
                </div>
                <span class="w-fit rounded-full px-2.5 py-1 text-xs font-semibold {{ $cashCategory->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ ucfirst($cashCategory->status) }}
                </span>
            </div>

            <div class="mt-6">
                <p class="text-sm font-semibold text-slate-700">Deskripsi</p>
                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $cashCategory->description ?: '-' }}</p>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('cash-categories.edit', $cashCategory) }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Edit</a>
            <a href="{{ route('cash-categories.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
        </div>
    </div>
@endsection
