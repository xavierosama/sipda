@extends('layouts.admin')

@section('title', 'Edit Notulensi')
@section('page-title', 'Edit Notulensi')
@section('page-subtitle', 'Perbarui catatan rapat')

@section('content')
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('meeting-notes.update', $meetingNote) }}">
            @method('PUT')
            @include('meeting-notes._form', ['submitLabel' => 'Simpan Perubahan'])
        </form>
    </div>
@endsection
