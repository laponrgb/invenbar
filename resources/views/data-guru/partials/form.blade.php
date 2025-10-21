<div class="row mb-3">
    <div class="col-md-6">
        <x-form-input label="NIP" name="nip" :value="$dataGuru->nip ?? ''" />
    </div>
    <div class="col-md-6">
        <x-form-input label="Nama Guru" name="nama_guru" :value="$dataGuru->nama_guru ?? ''" />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <x-form-input label="Email" name="email" type="email" :value="$dataGuru->email ?? ''" />
    </div>
    <div class="col-md-6">
        <x-form-input label="Alamat" name="alamat" :value="$dataGuru->alamat ?? ''" />
    </div>
</div>

<div class="mt-4">
    <x-primary-button>
        {{ isset($update) ? 'Update' : 'Simpan' }}
    </x-primary-button>
    <x-tombol-kembali :href="route('data-guru.index')" />
</div>
