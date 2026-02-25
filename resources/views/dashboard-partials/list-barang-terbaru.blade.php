<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr class="border-bottom">
                <th class="text-muted fw-600 small">Nama Barang</th>
                <th class="text-muted fw-600 small">Lokasi</th>
                <th class="text-muted fw-600 small">Tgl. Pengadaan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barangTerbaru as $barang)
                <tr class="border-bottom-dotted cursor-pointer transition" style="transition: all 0.2s ease;">
                    <td class="fw-500">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill">
                                <i class="bi bi-box-seam"></i>
                            </span>
                            {{ $barang->nama_barang }}
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                            <i class="bi bi-geo-alt"></i> {{ $barang->lokasi->nama_lokasi }}
                        </span>
                    </td>
                    <td>
                        <small class="text-muted">{{ date('d-m-Y', strtotime($barang->tanggal_pengadaan)) }}</small>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                        <p class="mb-0 mt-2">Belum ada data barang.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($barangTerbaru->count() > 0)
    <div class="text-end mt-3 pt-2 border-top">
        <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-primary fw-600">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
@endif

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .cursor-pointer {
        cursor: pointer;
    }
    
    .transition {
        transition: all 0.2s ease !important;
    }
    
    .border-bottom-dotted {
        border-bottom: 1px dotted #dee2e6 !important;
    }
    
    .fw-500 {
        font-weight: 500;
    }
</style>