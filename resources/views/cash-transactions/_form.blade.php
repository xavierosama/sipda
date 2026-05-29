@csrf

@php
    $typeLabels = ['income' => 'Kas Masuk', 'expense' => 'Kas Keluar'];
@endphp

<div class="grid gap-5 lg:grid-cols-2">
    <div>
        <label for="transaction_date" class="block text-sm font-semibold text-slate-700">Tanggal Transaksi</label>
        <input type="date" id="transaction_date" name="transaction_date" value="{{ old('transaction_date', optional($cashTransaction->transaction_date ?? null)->format('Y-m-d')) }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
        @error('transaction_date')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="transaction_type" class="block text-sm font-semibold text-slate-700">Jenis Transaksi</label>
        <select id="transaction_type" name="transaction_type" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
            @foreach ($types as $type)
                <option value="{{ $type }}" @selected(old('transaction_type', $cashTransaction->type ?? 'income') === $type)>{{ $typeLabels[$type] }}</option>
            @endforeach
        </select>
        @error('transaction_type')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="cash_category_id" class="block text-sm font-semibold text-slate-700">Kategori Kas</label>
        <select id="cash_category_id" name="cash_category_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
            <option value="">Pilih kategori</option>
            @foreach ($cashCategories as $cashCategory)
                <option value="{{ $cashCategory->id }}" @selected((string) old('cash_category_id', $cashTransaction->cash_category_id ?? '') === (string) $cashCategory->id)>{{ $cashCategory->name }}</option>
            @endforeach
        </select>
        @error('cash_category_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="amount" class="block text-sm font-semibold text-slate-700">Nominal</label>
        <input type="number" step="0.01" min="0" id="amount" name="amount" value="{{ old('amount', isset($cashTransaction->amount) ? number_format((float) $cashTransaction->amount, 2, '.', '') : '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
        @error('amount')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="activity_id" class="block text-sm font-semibold text-slate-700">Kegiatan Terkait</label>
        <select id="activity_id" name="activity_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih kegiatan</option>
            @foreach ($activities as $activity)
                <option value="{{ $activity->id }}" @selected((string) old('activity_id', $cashTransaction->activity_id ?? '') === (string) $activity->id)>{{ $activity->title ?? $activity->name }}</option>
            @endforeach
        </select>
        @error('activity_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="proof_file" class="block text-sm font-semibold text-slate-700">Bukti Transaksi</label>
        <input type="file" id="proof_file" name="proof_file" accept=".pdf,.jpg,.jpeg,.png" class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm file:mr-3 file:rounded-md file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800">
        @if (! empty($cashTransaction->proof_file_path))
            <a href="{{ asset('storage/'.$cashTransaction->proof_file_path) }}" target="_blank" class="mt-2 inline-block text-sm font-semibold text-emerald-700 hover:text-emerald-800">Lihat bukti saat ini</a>
        @endif
        @error('proof_file')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-5">
    <label for="description" class="block text-sm font-semibold text-slate-700">Deskripsi</label>
    <textarea id="description" name="description" rows="4" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('description', $cashTransaction->description ?? '') }}</textarea>
    @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div class="mt-6 flex flex-wrap items-center gap-3">
    <button type="submit" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">{{ $submitLabel }}</button>
    <a href="{{ route('cash-transactions.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
</div>
