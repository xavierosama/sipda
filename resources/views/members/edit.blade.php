@extends('layouts.admin')

@section('title', 'Edit Anggota')
@section('page-title', 'Edit Anggota')
@section('page-subtitle', 'Perbarui data anggota')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('members.update', $member) }}">
            @method('PUT')
            @include('members._form', ['submitLabel' => 'Simpan Perubahan'])
        </form>
    </div>
@endsection
