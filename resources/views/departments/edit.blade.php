@extends('layouts.admin')

@section('title', 'Edit Bidang')
@section('page-title', 'Edit Bidang')
@section('page-subtitle', 'Perbarui data bidang')

@section('content')
    <div class="max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('departments.update', $department) }}">
            @method('PUT')
            @include('departments._form', ['submitLabel' => 'Simpan Perubahan'])
        </form>
    </div>
@endsection
