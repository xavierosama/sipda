@extends('layouts.admin')

@section('title', 'Edit Arsip Dokumen')
@section('page-title', 'Edit Arsip Dokumen')
@section('page-subtitle', 'Perbarui data dokumen')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('documents.update', $document) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('documents._form', ['submitLabel' => 'Simpan Perubahan'])
        </form>
    </div>
@endsection
