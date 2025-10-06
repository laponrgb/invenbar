<x-table-list>
    <x-slot name="header">
        <tr>
            <th>#</th>
            <th>Nama Peminjam</th>
            <th>Telepon</th>
            <th>Tanggal Pinjam</th>
            <th>Status</th>
            <th>Barang Dipinjam</th>
            <th>&nbsp;</th>
        </tr>
    </x-slot>

    @forelse ($peminjamans as $index => $peminjaman)
        <tr>
            <td>{{ $peminjamans->firstItem() + $index }}</td>
            <td>{{ $peminjaman->nama_peminjam }}</td>
            <td>{{ $peminjaman->telepon_peminjam }}</td>
            <td>{{ $peminjaman->tanggal_pinjam }}</td>
            <td>
                <span class="badge {{ $peminjaman->status == 'Dipinjam' ? 'bg-warning text-dark' : 'bg-success' }}">
                    {{ $peminjaman->status }}
                </span>
            </td>

            <td>
                @php
                    $details = $peminjaman->details ?? collect();
                    $count = $details->count();
                @endphp

                <div class="barang-grid">
                    @foreach($details as $i => $detail)
                        <span class="badge bg-primary detail-badge" style="{{ $i >= 2 ? 'display:none;' : '' }}">
                            {{ $detail->barang->nama_barang }} ({{ $detail->jumlah }})
                        </span>
                    @endforeach

                    @if($count > 2)
                        <span class="badge bg-secondary toggle-detail"
                              style="cursor:pointer; user-select:none; white-space:nowrap;">
                            +{{ $count - 2 }}
                        </span>
                    @endif
                </div>
            </td>

            <td class="text-end">
                {{-- Tombol Return / Undo tergantung status --}}
                @if($peminjaman->status == 'Dipinjam')
                    <x-tombol-aksi href="{{ route('peminjaman.return', $peminjaman->id) }}" type="return" />
                @elseif($peminjaman->status == 'Dikembalikan')
                    <x-tombol-aksi href="{{ route('peminjaman.undo', $peminjaman->id) }}" type="undo" />
                @endif

                {{-- Hanya tampilkan tombol edit & delete jika status bukan "Dipinjam" --}}
                @if($peminjaman->status != 'Dipinjam')
                    <x-tombol-aksi href="{{ route('peminjaman.edit', $peminjaman->id) }}" type="edit" />
                    <x-tombol-aksi href="{{ route('peminjaman.destroy', $peminjaman->id) }}" type="delete" />
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">
                <div class="alert alert-danger mb-0">Belum ada data peminjaman.</div>
            </td>
        </tr>
    @endforelse
</x-table-list>

<style>
    /* Grid agar 2 kolom badge per baris, tombol expand ikut grid */
    .barang-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 kolom sama lebar */
        gap: 0.25rem 0.4rem;
        align-items: center;
    }

    .detail-badge,
    .toggle-detail {
        font-size: 0.85rem;
        white-space: nowrap;
        text-align: center;
        min-width: 100px; /* sesuaikan agar semua sama */
        padding: 0.25rem 0.45rem;
        display: inline-flex;
        justify-content: center;
    }

    .toggle-detail {
        font-size: 0.8rem;
        cursor: pointer;
        user-select: none;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.toggle-detail').forEach(btn => {
        btn.addEventListener('click', () => {
            const container = btn.closest('.barang-grid');
            const badges = container.querySelectorAll('.detail-badge');
            const hidden = Array.from(badges).some(b => b.style.display === 'none');

            badges.forEach((b, i) => {
                if (hidden) {
                    b.style.display = 'inline-flex';
                } else {
                    b.style.display = i < 2 ? 'inline-flex' : 'none';
                }
            });

            btn.textContent = hidden ? '−' : `+${badges.length - 2}`;
        });
    });
});
</script>
