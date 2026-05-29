@extends('layouts.admin')

@section('title', 'Tambah Transaksi Kas')
@section('page-title', 'Tambah Transaksi Kas')
@section('page-subtitle', 'Catat kas masuk atau kas keluar')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('cash-transactions.store') }}" enctype="multipart/form-data">
            @include('cash-transactions._form', ['submitLabel' => 'Simpan'])
        </form>
    </div>
@endsection
