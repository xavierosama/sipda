@extends('layouts.admin')

@section('title', 'Edit Kategori Transaksi')
@section('page-title', 'Edit Kategori Transaksi')
@section('page-subtitle', 'Perbarui kategori kas')

@section('content')
    <div class="max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('cash-categories.update', $cashCategory) }}">
            @method('PUT')
            @include('cash-categories._form', ['submitLabel' => 'Simpan Perubahan'])
        </form>
    </div>
@endsection
