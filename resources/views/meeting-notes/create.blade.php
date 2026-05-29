@extends('layouts.admin')

@section('title', 'Tambah Notulensi')
@section('page-title', 'Tambah Notulensi')
@section('page-subtitle', 'Tambahkan catatan rapat baru')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('meeting-notes.store') }}">
            @include('meeting-notes._form', ['submitLabel' => 'Simpan'])
        </form>
    </div>
@endsection
