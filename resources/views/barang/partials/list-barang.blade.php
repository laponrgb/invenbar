<div class="mx-3 mb-4">
    @if($barangs->count() > 0)
        <!-- Info Summary -->
        <div class="alert alert-light border-start border-primary border-5 mb-3" style="background-color: #f0f6ff;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>Menampilkan {{ $barangs->firstItem() }} - {{ $barangs->lastItem() }} dari {{ $barangs->total() }} barang</strong>
                </div>
                @if(request('search') || request('kategori_id') || request('sumberdana_id') || request('kondisi'))
                    <span class="badge bg-primary">
                        <i class="bi bi-funnel"></i> Filter Aktif
                    </span>
                @endif
            </div>
        </div>

        <!-- Desktop View: Table -->
        <div class="d-none d-lg-block">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 10%">Kode</th>
                                <th style="width: 20%">Nama Barang</th>
                                <th style="width: 12%">Kategori</th>
                                <th style="width: 12%">Lokasi</th>
                                <th style="width: 12%">Sumber Dana</th>
                                <th style="width: 12%">Jumlah</th>
                                <th style="width: 12%">Kondisi</th>
                                <th class="text-end" style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangs as $index => $barang)
                                <tr class="align-middle" style="border-bottom: 1px solid #e9ecef;">
                                    <td>
                                        <span class="badge bg-light text-dark fw-bold">{{ $barangs->firstItem() + $index }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-white">{{ $barang->kode_barang }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $barang->nama_barang }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $barang->kategori->nama_kategori }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $barang->lokasi->nama_lokasi }}</span>
                                    </td>
                                    <td>
                                        @if($barang->sumberdana)
                                            <small class="text-muted">{{ $barang->sumberdana->nama_sumberdana }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $barang->jumlah }} {{ $barang->satuan }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            @if ($barang->jumlah_baik > 0)
                                                <span class="badge bg-success px-2 py-1" style="font-size: 0.75rem; line-height: 1.2;">
                                                    Baik: {{ $barang->jumlah_baik }}
                                                </span>
                                            @endif

                                            @if ($barang->jumlah_rusak_ringan > 0)
                                                <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 0.75rem; line-height: 1.2;">
                                                    R.Ringan: {{ $barang->jumlah_rusak_ringan }}
                                                </span>
                                            @endif

                                            @if ($barang->jumlah_rusak_berat > 0)
                                                <span class="badge bg-danger px-2 py-1" style="font-size: 0.75rem; line-height: 1.2;">
                                                    R.Berat: {{ $barang->jumlah_rusak_berat }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group">
                                            @can('manage barang')
                                                <a href="{{ route('barang.show', $barang->id) }}" 
                                                   class="btn btn-outline-info" title="Lihat Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('barang.edit', $barang->id) }}" 
                                                   class="btn btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('delete barang')
                                                <button type="button" class="btn btn-outline-danger" 
                                                        onclick="deleteItem('{{ route('barang.destroy', $barang->id) }}')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Mobile View: Cards -->
        <div class="d-lg-none">
            <div class="row g-3">
                @foreach($barangs as $barang)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-3 h-100" style="transition: all 0.3s ease; cursor: pointer;">
                            <div class="card-body">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <span class="badge bg-info text-white mb-2 d-block">{{ $barang->kode_barang }}</span>
                                        <h6 class="card-title fw-bold mb-1">{{ $barang->nama_barang }}</h6>
                                        <small class="text-muted">{{ $barang->kategori->nama_kategori }}</small>
                                    </div>
                                    <span class="badge bg-light text-dark fw-bold">{{ $barangs->firstItem() + $loop->index }}</span>
                                </div>

                                <!-- Info Grid -->
                                <div class="row g-2 mb-3 small">
                                    <div class="col-6">
                                        <div class="bg-light p-2 rounded text-center">
                                            <small class="text-muted d-block">Lokasi</small>
                                            <strong style="font-size: 0.9rem;">{{ $barang->lokasi->nama_lokasi }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light p-2 rounded text-center">
                                            <small class="text-muted d-block">Jumlah</small>
                                            <strong style="font-size: 0.9rem;">{{ $barang->jumlah }} {{ $barang->satuan }}</strong>
                                        </div>
                                    </div>
                                    @if($barang->sumberdana)
                                        <div class="col-12">
                                            <small class="text-muted">Sumber: </small>
                                            <strong style="font-size: 0.9rem;">{{ $barang->sumberdana->nama_sumberdana }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <!-- Kondisi -->
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-2">Kondisi Barang:</small>
                                    <div class="d-flex flex-wrap gap-1">
                                        @if ($barang->jumlah_baik > 0)
                                            <span class="badge bg-success">Baik: {{ $barang->jumlah_baik }}</span>
                                        @endif
                                        @if ($barang->jumlah_rusak_ringan > 0)
                                            <span class="badge bg-warning text-dark">R.Ringan: {{ $barang->jumlah_rusak_ringan }}</span>
                                        @endif
                                        @if ($barang->jumlah_rusak_berat > 0)
                                            <span class="badge bg-danger">R.Berat: {{ $barang->jumlah_rusak_berat }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="d-flex gap-2 flex-wrap pt-2 border-top">
                                    @can('manage barang')
                                        <a href="{{ route('barang.show', $barang->id) }}" 
                                           class="btn btn-sm btn-info text-white flex-grow-1">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                        <a href="{{ route('barang.edit', $barang->id) }}" 
                                           class="btn btn-sm btn-warning text-white flex-grow-1">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                    @endcan
                                    @can('delete barang')
                                        <button type="button" class="btn btn-sm btn-danger text-white flex-grow-1"
                                                onclick="deleteItem('{{ route('barang.destroy', $barang->id) }}')"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
            </div>
            <h5 class="fw-bold text-muted mb-2">Belum ada data barang</h5>
            <p class="text-muted mb-4">Mulai tambahkan barang untuk mulai mengelola inventaris</p>
            <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Barang Pertama
            </a>
        </div>
    @endif
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa !important;
        transition: background-color 0.3s ease;
    }

    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
        padding: 0.5rem 0.65rem !important;
    }

    .card {
        border-radius: 1rem;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .btn-group-sm > .btn {
        padding: 0.35rem 0.6rem;
        font-size: 0.875rem;
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    /* Smooth icon transitions */
    #filterCollapse .btn-link i.bi-chevron-down {
        transition: transform 0.3s ease;
    }

    #filterCollapse.show .btn-link i.bi-chevron-down {
        transform: rotate(180deg);
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }

        .badge {
            font-size: 0.8rem;
        }
    }
</style>

<script>
    function deleteItem(url) {
        if (confirm('Apakah Anda yakin ingin menghapus barang ini?')) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value,
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Gagal menghapus data');
                }
            }).catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }
    }
</script>
