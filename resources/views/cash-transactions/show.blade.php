@extends('layouts.admin')

@section('title', 'Detail Transaksi Kas')
@section('page-title', 'Detail Transaksi Kas')
@section('page-subtitle', 'Informasi lengkap transaksi kas')

@section('content')
    @php
        $typeLabels = ['income' => 'Kas Masuk', 'expense' => 'Kas Keluar'];
    @endphp

    <div class="space-y-6">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">{{ $typeLabels[$cashTransaction->type] }}</p>
                    <h2 class="mt-2 text-2xl font-bold {{ $cashTransaction->type === 'income' ? 'text-emerald-700' : 'text-red-700' }}">Rp{{ number_format((float) $cashTransaction->amount, 0, ',', '.') }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ optional($cashTransaction->transaction_date)->format('d M Y') }}</p>
                </div>
                <span class="w-fit rounded-full px-2.5 py-1 text-xs font-semibold {{ $cashTransaction->type === 'income' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">{{ $typeLabels[$cashTransaction->type] }}</span>
            </div>

            <dl class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Kategori</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $cashTransaction->cashCategory?->name ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Kegiatan Terkait</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $cashTransaction->activity?->title ?? $cashTransaction->activity?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Pencatat</dt>
                    <dd class="mt-1 text-sm text-slate-600">{{ $cashTransaction->creator?->name ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-700">Bukti Transaksi</dt>
                    <dd class="mt-1 text-sm text-slate-600">
                        @if ($cashTransaction->proof_file_path)
                            <a href="{{ asset('storage/'.$cashTransaction->proof_file_path) }}" target="_blank" class="font-semibold text-emerald-700 hover:text-emerald-800">Lihat/download bukti</a>
                        @else
                            -
                        @endif
                    </dd>
                </div>
                <div class="md:col-span-2 xl:col-span-3">
                    <dt class="text-sm font-semibold text-slate-700">Deskripsi</dt>
                    <dd class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $cashTransaction->description ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('cash-transactions.edit', $cashTransaction) }}" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Edit</a>
            <a href="{{ route('cash-transactions.index', ['type' => $cashTransaction->type]) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
        </div>
    </div>
@endsection
