@csrf

@php
    $typeLabels = ['incoming' => 'Surat Masuk', 'outgoing' => 'Surat Keluar'];
    $statusLabels = [
        'draft' => 'Draft',
        'sent' => 'Sent',
        'received' => 'Received',
        'archived' => 'Archived',
        'cancelled' => 'Cancelled',
    ];
@endphp

<div class="grid gap-5 lg:grid-cols-2">
    <div>
        <label for="letter_type" class="block text-sm font-semibold text-slate-700">Tipe Surat</label>
        <select id="letter_type" name="letter_type" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
            @foreach ($types as $type)
                <option value="{{ $type }}" @selected(old('letter_type', $letter->type ?? 'incoming') === $type)>{{ $typeLabels[$type] }}</option>
            @endforeach
        </select>
        @error('letter_type')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="letter_number" class="block text-sm font-semibold text-slate-700">Nomor Surat</label>
        <input type="text" id="letter_number" name="letter_number" value="{{ old('letter_number', $letter->letter_number ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
        @error('letter_number')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="letter_date" class="block text-sm font-semibold text-slate-700">Tanggal Surat</label>
        <input type="date" id="letter_date" name="letter_date" value="{{ old('letter_date', optional($letter->letter_date ?? null)->format('Y-m-d')) }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
        @error('letter_date')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="received_or_sent_date" class="block text-sm font-semibold text-slate-700">Tanggal Diterima/Dikirim</label>
        <input type="date" id="received_or_sent_date" name="received_or_sent_date" value="{{ old('received_or_sent_date', optional($letter->received_or_sent_date ?? $letter->received_date ?? null)->format('Y-m-d')) }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('received_or_sent_date')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="sender" class="block text-sm font-semibold text-slate-700">Pengirim</label>
        <input type="text" id="sender" name="sender" value="{{ old('sender', $letter->sender ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('sender')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="recipient" class="block text-sm font-semibold text-slate-700">Penerima</label>
        <input type="text" id="recipient" name="recipient" value="{{ old('recipient', $letter->recipient ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('recipient')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="lg:col-span-2">
        <label for="subject" class="block text-sm font-semibold text-slate-700">Perihal</label>
        <input type="text" id="subject" name="subject" value="{{ old('subject', $letter->subject ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
        @error('subject')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="category" class="block text-sm font-semibold text-slate-700">Kategori</label>
        <select id="category" name="category" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" @selected(old('category', $letter->category ?? '') === $category)>{{ $category }}</option>
            @endforeach
        </select>
        @error('category')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="activity_id" class="block text-sm font-semibold text-slate-700">Kegiatan Terkait</label>
        <select id="activity_id" name="activity_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih kegiatan</option>
            @foreach ($activities as $activity)
                <option value="{{ $activity->id }}" @selected((string) old('activity_id', $letter->activity_id ?? '') === (string) $activity->id)>{{ $activity->title ?? $activity->name }}</option>
            @endforeach
        </select>
        @error('activity_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="block text-sm font-semibold text-slate-700">Status</label>
        <select id="status" name="status" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $letter->status ?? 'draft') === $status)>{{ $statusLabels[$status] }}</option>
            @endforeach
        </select>
        @error('status')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="file_path" class="block text-sm font-semibold text-slate-700">File Surat</label>
        <input type="file" id="file_path" name="file_path" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm file:mr-3 file:rounded-md file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800">
        @if (! empty($letter->file_path))
            <a href="{{ asset('storage/'.$letter->file_path) }}" target="_blank" class="mt-2 inline-block text-sm font-semibold text-emerald-700 hover:text-emerald-800">Lihat file saat ini</a>
        @endif
        @error('file_path')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-5">
    <label for="notes" class="block text-sm font-semibold text-slate-700">Catatan</label>
    <textarea id="notes" name="notes" rows="4" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('notes', $letter->notes ?? $letter->description ?? '') }}</textarea>
    @error('notes')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6 flex flex-wrap items-center gap-3">
    <button type="submit" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
        {{ $submitLabel }}
    </button>
    <a href="{{ route('letters.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
        Batal
    </a>
</div>
