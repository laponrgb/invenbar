<x-table-list>
    <x-slot name="header">
        <tr>
            <th>#</th>
            <th>Kode</th>
            <th>Nama Peminjam</th>
            <th>Telepon</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>Barang Dipinjam</th>
            <th>&nbsp;</th>
        </tr>
    </x-slot>

    @forelse ($peminjamans as $index => $peminjaman)
        <tr>
            <td>{{ $peminjamans->firstItem() + $index }}</td>
            <td><span class="badge bg-info text-dark">{{ $peminjaman->kode_peminjaman }}</span></td>
            <td>{{ $peminjaman->nama_peminjam }}</td>
            <td>{{ $peminjaman->telepon_peminjam }}</td>
            <td>{{ $peminjaman->tanggal_pinjam }}</td>
            <td>{{ $peminjaman->tanggal_kembali ?? '-' }}</td>
            <td>
                <span class="badge {{ $peminjaman->status == 'Dipinjam' ? 'bg-warning text-dark' : 'bg-success' }}">
                    {{ $peminjaman->status }}
                </span>
            </td>

            {{-- Barang dipinjam --}}
            <td>
                @php
                    $details = $peminjaman->details ?? collect();
                    $count = $details->count();
                @endphp
                @if($count > 0)
                    <div class="barang-summary">
                        <span class="badge bg-primary">
                            {{ $details->first()->barang->nama_barang }} ({{ $details->first()->jumlah }})
                        </span>
                        @if($count > 1)
                            <button type="button" class="btn btn-sm btn-outline-secondary ms-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#barangModal{{ $peminjaman->id }}">
                                +{{ $count - 1 }} lainnya
                            </button>
                        @endif
                    </div>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            {{-- Tombol aksi --}}
            <td class="text-end">
                {{-- Detail --}}
                <button class="btn btn-sm btn-outline-info me-1"
                        data-bs-toggle="modal"
                        data-bs-target="#detailPeminjamModal{{ $peminjaman->id }}">
                    <i class="bi bi-person-lines-fill"></i> Detail
                </button>

                {{-- Return --}}
                @if($peminjaman->status == 'Dipinjam')
                    <x-tombol-aksi href="{{ route('peminjaman.return', $peminjaman->id) }}" type="return" />
                @endif

                {{-- Perpanjang --}}
                @php
                    $isOverdue = $peminjaman->status == 'Dipinjam'
                        && $peminjaman->tanggal_kembali
                        && $peminjaman->tanggal_kembali < date('Y-m-d');
                @endphp
                @if($isOverdue)
                    <a href="{{ route('peminjaman.extend.form', $peminjaman->id) }}"
                       class="btn btn-sm btn-outline-primary ms-1">
                        <i class="bi bi-calendar-plus"></i> Perpanjang
                    </a>
                @endif

                {{-- Edit & Hapus --}}
                @if($peminjaman->status != 'Dipinjam')
                    <x-tombol-aksi href="{{ route('peminjaman.edit', $peminjaman->id) }}" type="edit" />
                    <x-tombol-aksi href="{{ route('peminjaman.destroy', $peminjaman->id) }}" type="delete" />
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">
                <div class="alert alert-danger mb-0">Belum ada data peminjaman.</div>
            </td>
        </tr>
    @endforelse
</x-table-list>

{{-- Modal Detail Peminjam --}}
@foreach ($peminjamans as $peminjaman)
<div class="modal fade" id="detailPeminjamModal{{ $peminjaman->id }}" tabindex="-1"
     aria-labelledby="detailPeminjamModalLabel{{ $peminjaman->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">
                    Detail Peminjam - {{ $peminjaman->nama_peminjam }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row align-items-start">
                    <div class="col-md-3 text-center">
                        @if($peminjaman->foto_peminjam)
                            <img src="{{ asset('storage/' . $peminjaman->foto_peminjam) }}"
                                 alt="{{ $peminjaman->nama_peminjam }}"
                                 class="img-fluid rounded shadow-sm mb-2" style="max-height: 140px;">
                        @else
                            <img src="{{ asset('images/ic-user.png') }}"
                                 class="img-fluid rounded shadow-sm mb-2" style="max-height: 140px;">
                        @endif
                        <small class="text-muted d-block">Foto Peminjam</small>
                    </div>

                    <div class="col-md-9">
                        <table class="table table-borderless mb-2">
                            <tr><th width="35%">Nama</th><td>{{ $peminjaman->nama_peminjam }}</td></tr>
                            <tr><th>Telepon</th><td>{{ $peminjaman->telepon_peminjam }}</td></tr>
                            <tr>
                                <th>Alamat Lengkap</th>
                                <td>
                                    @php
                                        $alamatParts = [
                                            $peminjaman->dusun ? "Dusun {$peminjaman->dusun}" : null,
                                            $peminjaman->desa ? "Desa {$peminjaman->desa}" : null,
                                            ($peminjaman->rt || $peminjaman->rw) ? "RT {$peminjaman->rt}/RW {$peminjaman->rw}" : null,
                                            $peminjaman->kecamatan ? "Kec. {$peminjaman->kecamatan}" : null,
                                            $peminjaman->kabupaten ? $peminjaman->kabupaten : null,
                                            $peminjaman->provinsi ? $peminjaman->provinsi : null,
                                            $peminjaman->kode_pos ? "Kode Pos {$peminjaman->kode_pos}" : null,
                                        ];
                                        $alamatFiltered = array_filter($alamatParts);
                                        $alamatLengkap = implode(', ', $alamatFiltered);
                                    @endphp

                                    @if($alamatLengkap)
                                        <div>{{ $alamatLengkap }}</div>
                                        @if($peminjaman->catatan_alamat)
                                            <small class="text-muted d-block mt-1">
                                                <i class="bi bi-geo-alt"></i> {{ $peminjaman->catatan_alamat }}
                                            </small>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr><th>Tanggal Pinjam</th><td>{{ $peminjaman->tanggal_pinjam }}</td></tr>
                            <tr><th>Tanggal Kembali</th><td>{{ $peminjaman->tanggal_kembali ?? '-' }}</td></tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge {{ $peminjaman->status == 'Dipinjam' ? 'bg-warning text-dark' : 'bg-success' }}">
                                        {{ $peminjaman->status }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>
                <h6 class="fw-bold mb-2">Barang Dipinjam:</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-striped align-middle">
                        <thead>
                            <tr><th>No</th><th>Nama Barang</th><th>Jumlah</th></tr>
                        </thead>
                        <tbody>
                            @foreach($peminjaman->details as $index => $detail)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $detail->barang->nama_barang }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
.barang-summary {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.25rem;
}
.barang-summary .badge {
    font-size: 0.85rem;
}
.barang-summary .btn {
    font-size: 0.8rem;
    padding: 0.2rem 0.5rem;
}
</style>
