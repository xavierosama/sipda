@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan awal sistem administrasi SIPDA')

@section('content')
    <div class="space-y-6">
        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">SIPDA Pemuda Persis Cirengit</p>
                <h2 class="mt-2 text-2xl font-bold text-slate-950">Selamat datang, {{ Auth::user()->name }}.</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Dashboard ini disiapkan sebagai pusat navigasi administrasi internal: anggota, sekretariat,
                    bendahara, program kerja, kegiatan, laporan, dan pengaturan sistem.
                </p>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Data Anggota</p>
                <p class="mt-3 text-2xl font-bold text-slate-950">0</p>
                <p class="mt-1 text-xs text-slate-500">Menunggu input data anggota.</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Program Kerja</p>
                <p class="mt-3 text-2xl font-bold text-slate-950">0</p>
                <p class="mt-1 text-xs text-slate-500">Belum ada program kerja aktif.</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Agenda Kegiatan</p>
                <p class="mt-3 text-2xl font-bold text-slate-950">0</p>
                <p class="mt-1 text-xs text-slate-500">Belum ada agenda terjadwal.</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Saldo Kas</p>
                <p class="mt-3 text-2xl font-bold text-slate-950">Rp0</p>
                <p class="mt-1 text-xs text-slate-500">Transaksi kas belum dicatat.</p>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm xl:col-span-2">
                <h3 class="text-base font-semibold text-slate-950">Modul Administrasi</h3>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-lg border border-slate-200 p-4">
                        <p class="font-semibold text-slate-900">Data Master</p>
                        <p class="mt-1 text-sm text-slate-500">Anggota, pengurus, bidang, dan jabatan.</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 p-4">
                        <p class="font-semibold text-slate-900">Sekretariat</p>
                        <p class="mt-1 text-sm text-slate-500">Surat, notulensi, daftar hadir, dan arsip.</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 p-4">
                        <p class="font-semibold text-slate-900">Bendahara</p>
                        <p class="mt-1 text-sm text-slate-500">Kas masuk, kas keluar, saldo, dan kategori.</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 p-4">
                        <p class="font-semibold text-slate-900">Program & Kegiatan</p>
                        <p class="mt-1 text-sm text-slate-500">Program kerja, agenda, dan laporan kegiatan.</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-base font-semibold text-slate-950">Status Sistem</h3>
                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-sm text-slate-600">Layout admin</span>
                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Aktif</span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-sm text-slate-600">Navigasi modul</span>
                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Siap</span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-sm text-slate-600">CRUD modul</span>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">Belum dibuat</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
