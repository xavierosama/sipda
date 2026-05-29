@extends('layouts.admin')

@section('title', 'Tambah Kategori Transaksi')
@section('page-title', 'Tambah Kategori Transaksi')
@section('page-subtitle', 'Tambahkan kategori kas baru')

@section('content')
    <div class="max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('cash-categories.store') }}">
            @include('cash-categories._form', ['submitLabel' => 'Simpan'])
        </form>
    </div>
@endsection
