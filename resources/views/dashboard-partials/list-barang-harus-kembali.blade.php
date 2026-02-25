<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr class="border-bottom">
                <th class="text-muted fw-600 small">Kode</th>
                <th class="text-muted fw-600 small">Peminjam</th>
                <th class="text-muted fw-600 small">Tgl. Kembali</th>
                <th class="text-muted fw-600 small text-center">Sisa Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barangHarusKembali as $peminjaman)
                @php
                    $tanggalKembali = \Carbon\Carbon::parse($peminjaman->tanggal_kembali);
                    $sisaHari = now()->diffInDays($tanggalKembali, false);
                    $sisaJam = now()->diffInHours($tanggalKembali, false);
                    $sisaMenit = now()->diffInMinutes($tanggalKembali, false);
                    
                    // Tentukan badge class berdasarkan waktu
                    if ($sisaMenit < 0) {
                        $badgeClass = 'bg-danger';
                        $badgeIcon = 'bi-exclamation-triangle-fill';
                        $badgeText = abs(round($sisaMenit / 60)) . ' jam lampau';
                    } elseif ($sisaMenit < 60) {
                        $badgeClass = 'bg-danger';
                        $badgeIcon = 'bi-hourglass-end';
                        $badgeText = abs(round($sisaMenit)) . ' menit lagi';
                    } elseif ($sisaMenit < 1440) { // kurang dari 1 hari (24 jam)
                        $badgeClass = $sisaMenit < 120 ? 'bg-danger' : 'bg-warning text-dark';
                        $badgeIcon = $sisaMenit < 120 ? 'bi-exclamation-circle-fill' : 'bi-clock-history';
                        $jam = round($sisaMenit / 60);
                        $menit = round($sisaMenit % 60);
                        if ($jam > 0) {
                            $badgeText = $jam . ' jam ' . $menit . ' menit';
                        } else {
                            $badgeText = $menit . ' menit';
                        }
                    } else {
                        $badgeClass = $sisaHari <= 2 ? 'bg-warning text-dark' : 'bg-info text-dark';
                        $badgeIcon = $sisaHari <= 2 ? 'bi-exclamation-circle' : 'bi-calendar-check';
                        $badgeText = $sisaHari . ' hari';
                    }
                @endphp
                <tr class="border-bottom-dotted transition" style="transition: all 0.2s ease; @if($sisaMenit < 0) background-color: rgba(220, 53, 69, 0.05); @elseif($sisaMenit < 120) background-color: rgba(220, 53, 69, 0.03); @elseif($sisaMenit < 1440) background-color: rgba(255, 193, 7, 0.03); @endif">
                    <td>
                        <span class="badge bg-danger bg-opacity-10 text-danger fw-600">{{ $peminjaman->kode_peminjaman }}</span>
                    </td>
                    <td class="fw-500">
                        <i class="bi bi-exclamation-lg text-danger me-2" style="opacity: 0.6;"></i>{{ $peminjaman->nama_peminjam }}
                    </td>
                    <td>
                        <small class="text-muted">
                            <i class="bi bi-calendar-event me-1"></i>{{ date('d-m-Y', strtotime($peminjaman->tanggal_kembali)) }}
                        </small>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $badgeClass }} fw-600">
                            <i class="bi {{ $badgeIcon }} me-1"></i>{{ $badgeText }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="bi bi-check-circle" style="font-size: 2rem; opacity: 0.5; color: #28a745;"></i>
                        <p class="mb-0 mt-2">Tidak ada barang yang harus segera dikembalikan.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($barangHarusKembali->count() > 0)
    <div class="text-end mt-3 pt-3 border-top">
        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-danger fw-600">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
@endif

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(220, 53, 69, 0.07) !important;
    }
    
    .border-bottom-dotted {
        border-bottom: 1px dotted #dee2e6 !important;
    }
    
    .fw-500 {
        font-weight: 500;
    }
    
    .transition {
        transition: all 0.2s ease !important;
    }
</style>
