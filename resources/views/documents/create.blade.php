@extends('layouts.admin')

@section('title', 'Tambah Arsip Dokumen')
@section('page-title', 'Tambah Arsip Dokumen')
@section('page-subtitle', 'Unggah dokumen organisasi')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
            @include('documents._form', ['submitLabel' => 'Simpan'])
        </form>
    </div>
@endsection
