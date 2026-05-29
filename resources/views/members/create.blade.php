@extends('layouts.admin')

@section('title', 'Tambah Anggota')
@section('page-title', 'Tambah Anggota')
@section('page-subtitle', 'Tambahkan data anggota baru')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('members.store') }}">
            @include('members._form', ['submitLabel' => 'Simpan'])
        </form>
    </div>
@endsection
