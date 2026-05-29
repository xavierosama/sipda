@extends('layouts.admin')

@section('title', 'Tambah Jabatan')
@section('page-title', 'Tambah Jabatan')
@section('page-subtitle', 'Tambahkan data jabatan baru')

@section('content')
    <div class="max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('positions.store') }}">
            @include('positions._form', ['submitLabel' => 'Simpan'])
        </form>
    </div>
@endsection
