<div class="row mb-3">
    <div class="col">
        <x-tombol-tambah label="Tambah Barang" href="{{ route('barang.create') }}" />
        <x-tombol-cetak label="Cetak Laporan Barang" href="{{ route('barang.laporan') }}" />
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0">
            <i class="bi bi-funnel"></i> Filter Barang
        </h6>
    </div>
    <div class="card-body">
        <x-filter-barang :kategoris="$kategoris" :sumberdanas="$sumberdanas" />
    </div>
</div>
