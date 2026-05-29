@extends('layouts.admin')

@section('title', 'Edit Transaksi Kas')
@section('page-title', 'Edit Transaksi Kas')
@section('page-subtitle', 'Perbarui transaksi kas')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('cash-transactions.update', $cashTransaction) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('cash-transactions._form', ['submitLabel' => 'Simpan Perubahan'])
        </form>
    </div>
@endsection
