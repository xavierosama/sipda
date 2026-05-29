@extends('layouts.admin')

@section('title', 'Tambah Agenda Kegiatan')
@section('page-title', 'Tambah Agenda Kegiatan')
@section('page-subtitle', 'Tambahkan agenda kegiatan baru')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('activities.store') }}">
            @include('activities._form', ['submitLabel' => 'Simpan'])
        </form>
    </div>
@endsection
