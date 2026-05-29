@extends('layouts.admin')

@section('title', 'Tambah Program Kerja')
@section('page-title', 'Tambah Program Kerja')
@section('page-subtitle', 'Tambahkan program kerja bidang')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('programs.store') }}">
            @include('programs._form', ['submitLabel' => 'Simpan'])
        </form>
    </div>
@endsection
