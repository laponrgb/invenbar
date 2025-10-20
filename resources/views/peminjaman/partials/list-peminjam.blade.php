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
            <td>
                <span class="badge bg-info text-dark">{{ $peminjaman->kode_peminjaman }}</span>
            </td>
            <td>{{ $peminjaman->nama_peminjam }}</td>
            <td>{{ $peminjaman->telepon_peminjam }}</td>
            <td>{{ $peminjaman->tanggal_pinjam }}</td>
            <td>{{ $peminjaman->tanggal_kembali ?? '-' }}</td>
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

                @if($count > 0)
                    <div class="barang-summary">
                        @if($count == 1)
                            <span class="badge bg-primary">{{ $details->first()->barang->nama_barang }} ({{ $details->first()->jumlah }})</span>
                        @else
                            <span class="badge bg-primary">{{ $details->first()->barang->nama_barang }} ({{ $details->first()->jumlah }})</span>
                            @if($count > 1)
                                <button type="button" class="btn btn-sm btn-outline-secondary ms-1" 
                                        
                                data-bs-toggle="modal" 
                                        data-bs-target="#barangModal{{ $peminjaman->id }}">
                                    +{{ $count - 1 }} lainnya
                                </button>
                            @endif
                        @endif
                    </div>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            <td class="text-end">
                {{-- Tombol Return --}}
                @if($peminjaman->status == 'Dipinjam')
                    <x-tombol-aksi href="{{ route('peminjaman.return', $peminjaman->id) }}" type="return" />
                @endif

                {{-- Perpanjang jika lewat tanggal kembali dan masih Dipinjam --}}
                @php
                    $isOverdue = $peminjaman->status == 'Dipinjam' 
                        && $peminjaman->tanggal_kembali 
                        && $peminjaman->tanggal_kembali < date('Y-m-d');
                @endphp
                @if($isOverdue)
                    <a href="{{ route('peminjaman.extend.form', $peminjaman->id) }}" class="btn btn-sm btn-outline-primary ms-1">
                        <i class="bi bi-calendar-plus"></i> Perpanjang
                    </a>
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
            <td colspan="9" class="text-center">
                <div class="alert alert-danger mb-0">Belum ada data peminjaman.</div>
            </td>
        </tr>
    @endforelse
</x-table-list>

{{-- Modal untuk menampilkan daftar barang lengkap --}}
@foreach ($peminjamans as $peminjaman)
    @if(($peminjaman->details ?? collect())->count() > 1)
        <div class="modal fade" id="barangModal{{ $peminjaman->id }}" tabindex="-1" aria-labelledby="barangModalLabel{{ $peminjaman->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="barangModalLabel{{ $peminjaman->id }}">
                            Daftar Barang Dipinjam - {{ $peminjaman->nama_peminjam }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Kode Peminjaman:</strong><br>
                                <span class="badge bg-info text-dark">{{ $peminjaman->kode_peminjaman }}</span>
                            </div>
                            <div class="col-md-4">
                                <strong>Nama Peminjam:</strong><br>
                                {{ $peminjaman->nama_peminjam }}
                            </div>
                            <div class="col-md-4">
                                <strong>Tanggal Pinjam:</strong><br>
                                {{ $peminjaman->tanggal_pinjam }}
                            </div>
                        </div>
                        <hr>
                        <h6>Daftar Barang:</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                    </tr>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
