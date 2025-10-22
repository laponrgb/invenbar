@csrf
<div class="mb-3">
    <x-form-input label="Nama Sumber Dana" name="nama_sumberdana" :value="$sumberdana->nama_sumberdana" />
</div>
<div class="mt-4">
    <x-primary-button>
        {{ isset($update) ? 'Update' : 'Simpan' }}
    </x-primary-button>
    <x-tombol-kembali :href="route('sumberdana.index')" />
</div>