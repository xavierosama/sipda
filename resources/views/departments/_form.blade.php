@csrf

<div class="space-y-5">
    <div>
        <label for="name" class="block text-sm font-semibold text-slate-700">Nama Bidang</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $department->name ?? '') }}"
            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
            required
            autofocus
        >
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-semibold text-slate-700">Deskripsi</label>
        <textarea
            id="description"
            name="description"
            rows="4"
            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
        >{{ old('description', $department->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="block text-sm font-semibold text-slate-700">Status</label>
        <select
            id="status"
            name="status"
            class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600"
            required
        >
            <option value="active" @selected(old('status', $department->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $department->status ?? 'active') === 'inactive')>Inactive</option>
        </select>
        @error('status')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-6 flex flex-wrap items-center gap-3">
    <button type="submit" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
        {{ $submitLabel }}
    </button>
    <a href="{{ route('departments.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
        Batal
    </a>
</div>
