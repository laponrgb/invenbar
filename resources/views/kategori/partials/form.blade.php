@csrf
<div class="mb-3">
    <x-form-input label="Nama Kategori" name="nama_kategori" :value="$kategori->nama_kategori" />
</div>
<div class="mt-4">
    <x-primary-button>
        {{ isset($update) ? 'Update' : 'Simpan' }}
    </x-primary-button>
    <x-tombol-kembali :href="route('kategori.index')" />
</div>
