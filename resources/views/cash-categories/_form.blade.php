@csrf

@php
    $typeLabels = ['income' => 'Kas Masuk', 'expense' => 'Kas Keluar', 'both' => 'Keduanya'];
    $statusLabels = ['active' => 'Active', 'inactive' => 'Inactive'];
@endphp

<div class="space-y-5">
    <div>
        <label for="name" class="block text-sm font-semibold text-slate-700">Nama Kategori</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $cashCategory->name ?? '') }}"
            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
            required
            autofocus
        >
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="type" class="block text-sm font-semibold text-slate-700">Type</label>
            <select id="type" name="type" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                <option value="">Pilih type</option>
                @foreach ($types as $type)
                    <option value="{{ $type }}" @selected(old('type', $cashCategory->type ?? '') === $type)>{{ $typeLabels[$type] }}</option>
                @endforeach
            </select>
            @error('type')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-semibold text-slate-700">Status</label>
            <select id="status" name="status" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(old('status', $cashCategory->status ?? 'active') === $status)>{{ $statusLabels[$status] }}</option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-semibold text-slate-700">Deskripsi</label>
        <textarea id="description" name="description" rows="4" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('description', $cashCategory->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-6 flex flex-wrap items-center gap-3">
    <button type="submit" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
        {{ $submitLabel }}
    </button>
    <a href="{{ route('cash-categories.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
        Batal
    </a>
</div>
