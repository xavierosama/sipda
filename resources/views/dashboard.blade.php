@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan statistik SIPDA Pemuda Persis Cirengit')

@section('content')
    @php
        $programStatuses = ['draft', 'planned', 'ongoing', 'completed', 'postponed', 'cancelled'];
        $programStatusLabels = [
            'draft' => 'Draft',
            'planned' => 'Planned',
            'ongoing' => 'Ongoing',
            'completed' => 'Completed',
            'postponed' => 'Postponed',
            'cancelled' => 'Cancelled',
        ];
        $cashTypeLabels = ['income' => 'Kas Masuk', 'expense' => 'Kas Keluar'];
        $activityStatusLabels = [
            'planned' => 'Planned',
            'ongoing' => 'Ongoing',
            'completed' => 'Completed',
            'postponed' => 'Postponed',
            'cancelled' => 'Cancelled',
        ];
    @endphp

    <div class="space-y-6">
        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">SIPDA Pemuda Persis Cirengit</p>
            <div class="mt-2 flex flex-col gap-2 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-950">Selamat datang, {{ Auth::user()->name }}.</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Ringkasan administrasi internal terbaru untuk anggota, program, sekretariat, arsip, kehadiran, dan kas.</p>
                </div>
                <p class="text-sm text-slate-500">{{ now()->format('d M Y') }}</p>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['Total anggota aktif', number_format($statistics['active_members'])],
                ['Total bidang aktif', number_format($statistics['active_departments'])],
                ['Total program kerja', number_format($statistics['programs'])],
                ['Kegiatan bulan ini', number_format($statistics['activities_this_month'])],
                ['Surat masuk bulan ini', number_format($statistics['incoming_letters_this_month'])],
                ['Surat keluar bulan ini', number_format($statistics['outgoing_letters_this_month'])],
                ['Total dokumen arsip', number_format($statistics['documents'])],
                ['Total notulensi', number_format($statistics['meeting_notes'])],
            ] as [$label, $value])
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                    <p class="mt-3 text-2xl font-bold text-slate-950">{{ $value }}</p>
                </div>
            @endforeach

            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total kas masuk</p>
                <p class="mt-3 text-2xl font-bold text-emerald-700">Rp{{ number_format((float) $statistics['cash_income'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Total kas keluar</p>
                <p class="mt-3 text-2xl font-bold text-red-700">Rp{{ number_format((float) $statistics['cash_expense'], 0, ',', '.') }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm md:col-span-2">
                <p class="text-sm font-medium text-slate-500">Saldo kas akhir</p>
                <p class="mt-3 text-2xl font-bold text-slate-950">Rp{{ number_format((float) $statistics['cash_balance'], 0, ',', '.') }}</p>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm xl:col-span-2">
                <h3 class="text-base font-semibold text-slate-950">Agenda Kegiatan Terdekat</h3>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Kegiatan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tempat</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Bidang</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($upcomingActivities as $activity)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-semibold text-slate-900">{{ $activity->title ?? $activity->name }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-600">
                                        {{ optional($activity->activity_date ?? $activity->started_at)->format('d M Y') ?: '-' }}
                                        <span class="block text-xs text-slate-500">
                                            {{ $activity->start_time ? substr($activity->start_time, 0, 5) : optional($activity->started_at)->format('H:i') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $activity->location ?: '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $activity->department?->name ?: '-' }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-600">{{ $activityStatusLabels[$activity->status] ?? ucfirst($activity->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada agenda terdekat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-base font-semibold text-slate-950">Rekap Status Program</h3>
                <div class="mt-4 space-y-3">
                    @foreach ($programStatuses as $status)
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-sm text-slate-600">{{ $programStatusLabels[$status] }}</span>
                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">{{ number_format($programStatusCounts[$status] ?? 0) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-base font-semibold text-slate-950">Program Kerja Terbaru</h3>
                <div class="mt-4 space-y-4">
                    @forelse ($latestPrograms as $program)
                        <div class="border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $program->title ?? $program->name }}</p>
                                    <p class="mt-1 text-sm text-slate-500">{{ $program->department?->name ?: '-' }} · PIC: {{ $program->pic?->full_name ?? $program->pic?->name ?? '-' }}</p>
                                </div>
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">{{ $programStatusLabels[$program->status] ?? ucfirst($program->status) }}</span>
                            </div>
                            <p class="mt-2 text-sm text-slate-600">Estimasi: Rp{{ number_format((float) ($program->estimated_budget ?? 0), 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada program kerja.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-base font-semibold text-slate-950">Transaksi Kas Terbaru</h3>
                <div class="mt-4 space-y-4">
                    @forelse ($latestCashTransactions as $transaction)
                        <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                            <div>
                                <p class="font-semibold {{ $transaction->type === 'income' ? 'text-emerald-700' : 'text-red-700' }}">{{ $cashTypeLabels[$transaction->type] }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ optional($transaction->transaction_date)->format('d M Y') }} · {{ $transaction->cashCategory?->name ?: '-' }}</p>
                                <p class="mt-1 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($transaction->description ?: '-', 70) }}</p>
                            </div>
                            <p class="whitespace-nowrap text-sm font-bold text-slate-950">Rp{{ number_format((float) $transaction->amount, 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada transaksi kas.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-base font-semibold text-slate-950">Rekap Kehadiran Terbaru</h3>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Kegiatan</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Hadir</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Izin</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tidak Hadir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($attendanceRecaps as $activity)
                            <tr>
                                <td class="px-4 py-3 text-sm font-semibold text-slate-900">{{ $activity->title ?? $activity->name }}</td>
                                <td class="px-4 py-3 text-sm text-emerald-700">{{ $activity->present_count }}</td>
                                <td class="px-4 py-3 text-sm text-amber-700">{{ $activity->permission_count }}</td>
                                <td class="px-4 py-3 text-sm text-red-700">{{ $activity->absent_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada rekap kehadiran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
