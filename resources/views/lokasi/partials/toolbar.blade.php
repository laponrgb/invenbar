<div class="row">
    <div class="col">
        @can('manage lokasi')
            <x-tombol-tambah label="Tambah lokasi" href="{{ route('lokasi.create') }}" />
        @endcan
    </div>
    <div class="col">
        <x-form-search placeholder="Cari nama lokasi..." />
    </div>
</div>
