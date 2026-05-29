@extends('layouts.admin')

@section('title', 'Tambah Daftar Hadir')
@section('page-title', 'Tambah Daftar Hadir')
@section('page-subtitle', 'Catat kehadiran anggota')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('attendances.store') }}">
            @include('attendances._form', ['submitLabel' => 'Simpan'])
        </form>
    </div>
@endsection
