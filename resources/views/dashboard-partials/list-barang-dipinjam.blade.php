<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Peminjam</th>
            <th>Tgl. Pinjam</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($barangDipinjam as $peminjaman)
            <tr>
                <td>
                    <span class="badge bg-info text-dark">{{ $peminjaman->kode_peminjaman }}</span>
                </td>
                <td>{{ $peminjaman->nama_peminjam }}</td>
                <td>{{ date('d-m-Y', strtotime($peminjaman->tanggal_pinjam)) }}</td>
                <td>
                    @if($peminjaman->status == 'Dipinjam')
                        <span class="badge bg-warning text-dark">{{ $peminjaman->status }}</span>
                    @else
                        <span class="badge bg-success">{{ $peminjaman->status }}</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Belum ada data peminjaman.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($barangDipinjam->count() > 0)
    <div class="text-end mt-2">
        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-primary">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>
@endif
