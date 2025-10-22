@csrf
<div class="mb-3">
    <x-form-input label="Nama lokasi" name="nama_lokasi" :value="$lokasi->nama_lokasi" />
</div>

<div class="mb-3">
    <label for="ketua_id" class="form-label">Pengelola Lokasi</label>
    <select name="ketua_id" id="ketua_id" class="form-select">
        <option value="">-- Pilih Pengelola Lokasi --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" 
                {{ old('ketua_id', $lokasi->ketua_id ?? '') == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mt-4">
    <x-primary-button>
        {{ isset($update) ? 'Update' : 'Simpan' }}
    </x-primary-button>
    <x-tombol-kembali :href="route('lokasi.index')" />
</div>