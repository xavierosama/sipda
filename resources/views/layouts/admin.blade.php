<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dashboard Admin') - {{ config('app.name', 'SIPDA') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-100 text-slate-900">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen lg:flex">
            <div
                x-cloak
                x-show="sidebarOpen"
                x-transition.opacity
                class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"
                @click="sidebarOpen = false"
            ></div>

            <aside
                class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-200 lg:static lg:translate-x-0"
                :class="{ 'translate-x-0': sidebarOpen }"
            >
                <div class="flex h-16 items-center gap-3 border-b border-slate-200 px-5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-700 text-sm font-bold text-white">
                        SP
                    </div>
                    <div>
                        <div class="text-sm font-bold leading-5 text-slate-900">SIPDA</div>
                        <div class="text-xs font-medium text-slate-500">Pemuda Persis Cirengit</div>
                    </div>
                </div>

                <nav class="flex-1 space-y-6 overflow-y-auto px-4 py-5">
                    <a href="{{ route('dashboard') }}" class="flex items-center rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">
                        Dashboard
                    </a>

                    <div>
                        <p class="px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Data Master</p>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('members.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('members.*') ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Data Anggota</a>
                            <a href="#" class="block rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-slate-950">Data Pengurus</a>
                            <a href="{{ route('departments.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('departments.*') ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Data Bidang</a>
                            <a href="{{ route('positions.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('positions.*') ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Data Jabatan</a>
                        </div>
                    </div>

                    <div>
                        <p class="px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Sekretariat</p>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('letters.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('letters.*') && ! request('type') ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Semua Surat</a>
                            <a href="{{ route('letters.index', ['type' => 'incoming']) }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('letters.*') && request('type') === 'incoming' ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Surat Masuk</a>
                            <a href="{{ route('letters.index', ['type' => 'outgoing']) }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('letters.*') && request('type') === 'outgoing' ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Surat Keluar</a>
                            <a href="{{ route('meeting-notes.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('meeting-notes.*') ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Notulensi</a>
                            <a href="{{ route('attendances.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('attendances.*') ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Daftar Hadir</a>
                            <a href="{{ route('documents.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('documents.*') ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Arsip Dokumen</a>
                        </div>
                    </div>

                    <div>
                        <p class="px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Bendahara</p>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('cash-transactions.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('cash-transactions.*') && ! request('type') ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Semua Transaksi</a>
                            <a href="{{ route('cash-transactions.index', ['type' => 'income']) }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('cash-transactions.*') && request('type') === 'income' ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Kas Masuk</a>
                            <a href="{{ route('cash-transactions.index', ['type' => 'expense']) }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('cash-transactions.*') && request('type') === 'expense' ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Kas Keluar</a>
                            <a href="{{ route('cash-categories.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('cash-categories.*') ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Kategori Transaksi</a>
                        </div>
                    </div>

                    <div>
                        <p class="px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Program & Kegiatan</p>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('programs.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('programs.*') ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Program Kerja</a>
                            <a href="{{ route('activities.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('activities.*') ? 'bg-emerald-50 font-semibold text-emerald-800' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-950' }}">Agenda Kegiatan</a>
                            <a href="#" class="block rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-slate-950">Laporan Kegiatan</a>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <a href="#" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-950">Laporan</a>
                        <a href="#" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-950">Pengaturan</a>
                    </div>
                </nav>
            </aside>

            <div class="min-w-0 flex-1 lg:pl-0">
                <header class="sticky top-0 z-20 border-b border-slate-200 bg-white">
                    <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 lg:hidden"
                                @click="sidebarOpen = true"
                                aria-label="Buka menu"
                            >
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <div>
                                <h1 class="text-base font-semibold text-slate-900">@yield('page-title', 'Dashboard')</h1>
                                <p class="hidden text-sm text-slate-500 sm:block">@yield('page-subtitle', 'Administrasi internal PJ Pemuda Persis Cirengit')</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="max-w-32 text-right sm:max-w-none">
                                <div class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                                <div class="hidden text-xs text-slate-500 sm:block">{{ Auth::user()->email }}</div>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                                Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="rounded-lg bg-slate-900 px-3 py-2 text-sm font-medium text-white hover:bg-slate-800">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                <main class="px-4 py-6 sm:px-6 lg:px-8">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
