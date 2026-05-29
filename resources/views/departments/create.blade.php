@extends('layouts.admin')

@section('title', 'Tambah Bidang')
@section('page-title', 'Tambah Bidang')
@section('page-subtitle', 'Tambahkan data bidang baru')

@section('content')
    <div class="max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('departments.store') }}">
            @include('departments._form', ['submitLabel' => 'Simpan'])
        </form>
    </div>
@endsection
