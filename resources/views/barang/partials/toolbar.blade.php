<div class="row">
    <div class="col">
        <x-tombol-tambah label="Tambah Barang" href="{{ route('barang.create') }}" />
        <x-tombol-cetak label="Cetak Laporan Barang" href="{{ route('barang.laporan') }}" />
    </div>
    <div class="col">
        <x-form-search placeholder="Cari nama/kode barang ..." />
    </div>
</div>
