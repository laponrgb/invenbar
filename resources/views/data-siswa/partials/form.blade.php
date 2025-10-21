<div class="row mb-3">
    <div class="col-md-6">
        <x-form-input label="NIS" name="nis" :value="$dataSiswa->nis ?? ''" />
    </div>
    <div class="col-md-6">
        <x-form-input label="Nama Siswa" name="nama_siswa" :value="$dataSiswa->nama_siswa ?? ''" />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <x-form-input label="Kelas" name="kelas" :value="$dataSiswa->kelas ?? ''" />
    </div>
    <div class="col-md-6">
        <x-form-select 
            label="Jenis Kelamin" 
            name="jenis_kelamin" 
            :value="$dataSiswa->jenis_kelamin ?? ''"
            :option-data="[
                ['value' => 'L', 'label' => 'Laki-laki'],
                ['value' => 'P', 'label' => 'Perempuan']
            ]" 
            option-label="label" 
            option-value="value" 
        />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <x-form-input label="Email" name="email" type="email" :value="$dataSiswa->email ?? ''" />
    </div>
    <div class="col-md-6">
        <x-form-input label="Alamat" name="alamat" :value="$dataSiswa->alamat ?? ''" />
    </div>
</div>

<div class="mt-4">
    <x-primary-button>
        {{ isset($update) ? 'Update' : 'Simpan' }}
    </x-primary-button>
    <x-tombol-kembali :href="route('data-siswa.index')" />
</div>
