@extends('layouts.admin')

@section('title', 'Transaksi Kas')
@section('page-title', 'Transaksi Kas')
@section('page-subtitle', 'Kelola kas masuk dan kas keluar')

@section('content')
    @php
        $typeLabels = ['income' => 'Kas Masuk', 'expense' => 'Kas Keluar'];
    @endphp

    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        @endif

        <section class="grid gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Kas Masuk</p>
                <p class="mt-3 text-2xl font-bold text-emerald-700">Rp{{ number_format((float) $totalIncome, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total Kas Keluar</p>
                <p class="mt-3 text-2xl font-bold text-red-700">Rp{{ number_format((float) $totalExpense, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Saldo Akhir</p>
                <p class="mt-3 text-2xl font-bold text-slate-950">Rp{{ number_format((float) $balance, 0, ',', '.') }}</p>
            </div>
        </section>

        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
                <form method="GET" action="{{ route('cash-transactions.index') }}" class="grid flex-1 gap-3 md:grid-cols-2 xl:grid-cols-[1fr_150px_190px_190px_150px_150px_auto]">
                    <div>
                        <label for="search" class="block text-sm font-semibold text-slate-700">Cari Deskripsi</label>
                        <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Masukkan deskripsi" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-semibold text-slate-700">Jenis</label>
                        <select id="type" name="type" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Semua</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}" @selected(($filters['type'] ?? '') === $type)>{{ $typeLabels[$type] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="cash_category_id" class="block text-sm font-semibold text-slate-700">Kategori</label>
                        <select id="cash_category_id" name="cash_category_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                            <option value="">Semua</option>
                            @foreach ($cashCategories as $cashCategory)
                                <option value="{{ $cashCategory->id }}" @selected((string) ($filters['cash_category_id'] ?? '') === (string) $cashCategory->id)>{{ $cashCategory->name }}</option>
                            @endforeach
                        </select>
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
                        <label for="date_from" class="block text-sm font-semibold text-slate-700">Dari</label>
                        <input type="date" id="date_from" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                    </div>
                    <div>
                        <label for="date_to" class="block text-sm font-semibold text-slate-700">Sampai</label>
                        <input type="date" id="date_to" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Filter</button>
                        <a href="{{ route('cash-transactions.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
                    </div>
                </form>

                <a href="{{ route('cash-transactions.create', request()->filled('type') ? ['type' => request('type')] : []) }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Tambah Transaksi</a>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Jenis</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Kategori</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nominal</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Kegiatan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Pencatat</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($cashTransactions as $cashTransaction)
                            <tr>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">{{ optional($cashTransaction->transaction_date)->format('d M Y') }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold {{ $cashTransaction->type === 'income' ? 'text-emerald-700' : 'text-red-700' }}">{{ $typeLabels[$cashTransaction->type] }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $cashTransaction->cashCategory?->name ?: '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-900">Rp{{ number_format((float) $cashTransaction->amount, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $cashTransaction->activity?->title ?? $cashTransaction->activity?->name ?? '-' }}</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $cashTransaction->creator?->name ?: '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('cash-transactions.show', $cashTransaction) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Detail</a>
                                        <a href="{{ route('cash-transactions.edit', $cashTransaction) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                                        <form method="POST" action="{{ route('cash-transactions.destroy', $cashTransaction) }}" onsubmit="return confirm('Arsipkan transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 font-semibold text-red-700 hover:bg-red-50">Arsipkan</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-sm text-slate-500">Transaksi kas belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">{{ $cashTransactions->links() }}</div>
        </div>
    </div>
@endsection
