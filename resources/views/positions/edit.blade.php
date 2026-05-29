@extends('layouts.admin')

@section('title', 'Edit Jabatan')
@section('page-title', 'Edit Jabatan')
@section('page-subtitle', 'Perbarui data jabatan')

@section('content')
    <div class="max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('positions.update', $position) }}">
            @method('PUT')
            @include('positions._form', ['submitLabel' => 'Simpan Perubahan'])
        </form>
    </div>
@endsection
