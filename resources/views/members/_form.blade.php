@csrf

<div class="grid gap-5 lg:grid-cols-2">
    <div>
        <label for="full_name" class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
        <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $member->full_name ?? $member->name ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required autofocus>
        @error('full_name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="member_number" class="block text-sm font-semibold text-slate-700">Nomor Anggota</label>
        <input type="text" id="member_number" name="member_number" value="{{ old('member_number', $member->member_number ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('member_number')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="birth_place" class="block text-sm font-semibold text-slate-700">Tempat Lahir</label>
        <input type="text" id="birth_place" name="birth_place" value="{{ old('birth_place', $member->birth_place ?? $member->place_of_birth ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('birth_place')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="birth_date" class="block text-sm font-semibold text-slate-700">Tanggal Lahir</label>
        <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', optional($member->birth_date ?? $member->date_of_birth ?? null)->format('Y-m-d')) }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('birth_date')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="gender" class="block text-sm font-semibold text-slate-700">Jenis Kelamin</label>
        <select id="gender" name="gender" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih jenis kelamin</option>
            <option value="male" @selected(old('gender', $member->gender ?? '') === 'male')>Laki-laki</option>
            <option value="female" @selected(old('gender', $member->gender ?? '') === 'female')>Perempuan</option>
        </select>
        @error('gender')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="phone" class="block text-sm font-semibold text-slate-700">Telepon</label>
        <input type="text" id="phone" name="phone" value="{{ old('phone', $member->phone ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('phone')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $member->email ?? '') }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="joined_at" class="block text-sm font-semibold text-slate-700">Tanggal Bergabung</label>
        <input type="date" id="joined_at" name="joined_at" value="{{ old('joined_at', optional($member->joined_at ?? null)->format('Y-m-d')) }}" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('joined_at')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="department_id" class="block text-sm font-semibold text-slate-700">Bidang</label>
        <select id="department_id" name="department_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih bidang</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}" @selected((string) old('department_id', $member->department_id ?? '') === (string) $department->id)>{{ $department->name }}</option>
            @endforeach
        </select>
        @error('department_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="position_id" class="block text-sm font-semibold text-slate-700">Jabatan</label>
        <select id="position_id" name="position_id" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Pilih jabatan</option>
            @foreach ($positions as $position)
                <option value="{{ $position->id }}" @selected((string) old('position_id', $member->position_id ?? '') === (string) $position->id)>{{ $position->name }}</option>
            @endforeach
        </select>
        @error('position_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="member_status" class="block text-sm font-semibold text-slate-700">Status Anggota</label>
        <select id="member_status" name="member_status" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" required>
            <option value="active" @selected(old('member_status', $member->member_status ?? $member->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('member_status', $member->member_status ?? $member->status ?? 'active') === 'inactive')>Inactive</option>
        </select>
        @error('member_status')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-5">
    <label for="address" class="block text-sm font-semibold text-slate-700">Alamat</label>
    <textarea id="address" name="address" rows="3" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('address', $member->address ?? '') }}</textarea>
    @error('address')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-5">
    <label for="notes" class="block text-sm font-semibold text-slate-700">Catatan</label>
    <textarea id="notes" name="notes" rows="3" class="mt-2 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('notes', $member->notes ?? '') }}</textarea>
    @error('notes')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6 flex flex-wrap items-center gap-3">
    <button type="submit" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
        {{ $submitLabel }}
    </button>
    <a href="{{ route('members.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
        Batal
    </a>
</div>
