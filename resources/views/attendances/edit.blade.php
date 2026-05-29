@extends('layouts.admin')

@section('title', 'Edit Daftar Hadir')
@section('page-title', 'Edit Daftar Hadir')
@section('page-subtitle', 'Perbarui data kehadiran')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('attendances.update', $attendance) }}">
            @method('PUT')
            @include('attendances._form', ['submitLabel' => 'Simpan Perubahan'])
        </form>
    </div>
@endsection
