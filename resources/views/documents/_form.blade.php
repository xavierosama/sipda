@csrf

<div class="grid gap-5 lg:grid-cols-2">
    <div class="lg:col-span-2">
        <label for="title" class="block text-sm font-semibold text-slate-700">Judul Dokumen</label>
        <input type="text" id="title" name="title" value="{{ old('title', $document->title ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required autofocus>
        @error('title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="category" class="block text-sm font-semibold text-slate-700">Kategori</label>
        <select id="category" name="category" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" @selected(old('category', $document->category ?? '') === $category)>{{ $category }}</option>
            @endforeach
        </select>
        @error('category')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="document_date" class="block text-sm font-semibold text-slate-700">Tanggal Dokumen</label>
        <input type="date" id="document_date" name="document_date" value="{{ old('document_date', optional($document->document_date ?? null)->format('Y-m-d')) }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('document_date')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="department_id" class="block text-sm font-semibold text-slate-700">Bidang</label>
        <select id="department_id" name="department_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih bidang</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}" @selected((string) old('department_id', $document->department_id ?? '') === (string) $department->id)>{{ $department->name }}</option>
            @endforeach
        </select>
        @error('department_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="activity_id" class="block text-sm font-semibold text-slate-700">Kegiatan Terkait</label>
        <select id="activity_id" name="activity_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih kegiatan</option>
            @foreach ($activities as $activity)
                <option value="{{ $activity->id }}" @selected((string) old('activity_id', $document->activity_id ?? '') === (string) $activity->id)>{{ $activity->title ?? $activity->name }}</option>
            @endforeach
        </select>
        @error('activity_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="lg:col-span-2">
        <label for="file_path" class="block text-sm font-semibold text-slate-700">File Dokumen</label>
        <input type="file" id="file_path" name="file_path" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm file:mr-3 file:rounded-md file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800" @required(empty($document->id))>
        @if (! empty($document->file_path))
            <a href="{{ asset('storage/'.$document->file_path) }}" target="_blank" class="mt-2 inline-block text-sm font-semibold text-emerald-700 hover:text-emerald-800">Lihat file saat ini</a>
        @endif
        @error('file_path')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-5">
    <label for="description" class="block text-sm font-semibold text-slate-700">Deskripsi</label>
    <textarea id="description" name="description" rows="4" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('description', $document->description ?? '') }}</textarea>
    @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div class="mt-6 flex flex-wrap items-center gap-3">
    <button type="submit" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">{{ $submitLabel }}</button>
    <a href="{{ route('documents.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
</div>
