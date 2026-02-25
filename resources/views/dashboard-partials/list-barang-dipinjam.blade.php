<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr class="border-bottom">
                <th class="text-muted fw-600 small">Kode</th>
                <th class="text-muted fw-600 small">Peminjam</th>
                <th class="text-muted fw-600 small">Tgl. Pinjam</th>
                <th class="text-muted fw-600 small text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barangDipinjam as $peminjaman)
                <tr class="border-bottom-dotted transition" style="transition: all 0.2s ease;">
                    <td>
                        <span class="badge bg-info text-white fw-600">{{ $peminjaman->kode_peminjaman }}</span>
                    </td>
                    <td class="fw-500">
                        <i class="bi bi-person-circle text-primary me-2"></i>{{ $peminjaman->nama_peminjam }}
                    </td>
                    <td>
                        <small class="text-muted">
                            <i class="bi bi-calendar-event me-1"></i>{{ date('d-m-Y', strtotime($peminjaman->tanggal_pinjam)) }}
                        </small>
                    </td>
                    <td class="text-center">
                        @if($peminjaman->status == 'Dipinjam')
                            <span class="badge bg-warning text-dark fw-600">
                                <i class="bi bi-hourglass-split me-1"></i>{{ $peminjaman->status }}
                            </span>
                        @else
                            <span class="badge bg-success fw-600">
                                <i class="bi bi-check-circle me-1"></i>{{ $peminjaman->status }}
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                        <p class="mb-0 mt-2">Belum ada data peminjaman.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($barangDipinjam->count() > 0)
    <div class="text-end mt-3 pt-3 border-top">
        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-warning fw-600">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
@endif

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(255, 193, 7, 0.05);
    }
    
    .border-bottom-dotted {
        border-bottom: 1px dotted #dee2e6 !important;
    }
    
    .fw-500 {
        font-weight: 500;
    }
</style>
