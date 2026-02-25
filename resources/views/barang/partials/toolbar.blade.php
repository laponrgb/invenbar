<div class="mx-3 mt-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-0">
                <i class="bi bi-box2-heart text-primary"></i> Daftar Barang
            </h5>
            <small class="text-muted">Kelola inventaris barang dengan mudah</small>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <x-tombol-tambah label="Tambah Barang" href="{{ route('barang.create') }}" />
            <x-tombol-cetak label="Cetak Laporan" href="{{ route('barang.laporan') }}" />
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card border-0 shadow-sm rounded-3" style="background: linear-gradient(135deg, #f5f7fa 0%, #f9fbfc 100%);">
        <div class="card-header bg-white border-bottom border-light rounded-3 rounded-bottom-0">
            <button class="btn btn-link text-decoration-none text-dark fw-bold p-0 w-100 text-start" 
                    type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" 
                    aria-expanded="{{ request()->hasAny(['search', 'kategori_id', 'sumberdana_id', 'kondisi']) ? 'true' : 'false' }}">
                <i class="bi bi-funnel"></i> <strong>Filter Barang</strong>
                <i class="bi bi-chevron-down float-end" style="transition: transform 0.3s;"></i>
            </button>
        </div>
        <div class="collapse {{ request()->hasAny(['search', 'kategori_id', 'sumberdana_id', 'kondisi']) ? 'show' : '' }}" id="filterCollapse">
            <div class="card-body">
                <x-filter-barang :kategoris="$kategoris" :sumberdanas="$sumberdanas" :lokasis="$lokasis" />
            </div>
        </div>
    </div>
</div>
