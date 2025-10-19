<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Peminjam</th>
            <th>Tgl. Kembali</th>
            <th>Sisa Hari</th>
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
                    $badgeText = 'Terlambat ' . abs(round($sisaMenit / 60)) . ' jam';
                } elseif ($sisaMenit < 60) {
                    $badgeClass = 'bg-danger';
                    $badgeText = 'Terlambat ' . abs(round($sisaMenit)) . ' menit';
                } elseif ($sisaMenit < 1440) { // kurang dari 1 hari (24 jam)
                    $badgeClass = $sisaMenit < 120 ? 'bg-danger' : 'bg-warning text-dark';
                    $jam = round($sisaMenit / 60);
                    $menit = round($sisaMenit % 60);
                    if ($jam > 0) {
                        $badgeText = $jam . ' jam ' . $menit . ' menit lagi';
                    } else {
                        $badgeText = $menit . ' menit lagi';
                    }
                } else {
                    $badgeClass = $sisaHari <= 2 ? 'bg-warning text-dark' : 'bg-info text-dark';
                    $badgeText = $sisaHari . ' hari lagi';
                }
            @endphp
            <tr>
                <td>
                    <span class="badge bg-info text-dark">{{ $peminjaman->kode_peminjaman }}</span>
                </td>
                <td>{{ $peminjaman->nama_peminjam }}</td>
                <td>{{ date('d-m-Y', strtotime($peminjaman->tanggal_kembali)) }}</td>
                <td>
                    <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Tidak ada barang yang harus segera dikembalikan.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($barangHarusKembali->count() > 0)
    <div class="text-end mt-2">
        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-warning">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>
@endif
