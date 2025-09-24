<div class="row">
    <div class="col">
        @can('manage kategori')
            <x-tombol-tambah label="Tambah Kategori" href="{{ route('kategori.create') }}" />
        @endcan
    </div>
    <div class="col">
        <x-form-search placeholder="Cari nama kategori..." />
    </div>
</div>
