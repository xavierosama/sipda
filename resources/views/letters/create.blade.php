@extends('layouts.admin')

@section('title', 'Tambah Surat')
@section('page-title', 'Tambah Surat')
@section('page-subtitle', 'Tambahkan data surat masuk atau surat keluar')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('letters.store') }}" enctype="multipart/form-data">
            @include('letters._form', ['submitLabel' => 'Simpan'])
        </form>
    </div>
@endsection
