@extends('layouts.admin')

@section('title', 'Edit Surat')
@section('page-title', 'Edit Surat')
@section('page-subtitle', 'Perbarui data surat')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('letters.update', $letter) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('letters._form', ['submitLabel' => 'Simpan Perubahan'])
        </form>
    </div>
@endsection
