<div class="row mb-3">
    <div class="col">
        <x-tombol-tambah label="Tambah Peminjaman" href="{{ route('peminjaman.create') }}" />
    </div>
    <div class="col text-end">
        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
            <i class="bi bi-funnel"></i> Filter
        </button>
    </div>
</div>

<!-- Filter Collapse -->
<div class="collapse mb-3 {{ request()->hasAny(['search', 'status', 'tanggal_pinjam', 'tanggal_kembali', 'lokasi_id']) ? 'show' : '' }}" id="filterCollapse">
    <div class="card card-body">
        <form method="GET" action="{{ route('peminjaman.index') }}">
            <div class="row g-3">
                <!-- Consolidated Search Input -->
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Peminjam / Kode</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nama peminjam atau kode peminjaman...">
                </div>

                <!-- Status Filter -->
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>

                <!-- Lokasi Filter -->
                <div class="col-md-4">
                    <label for="lokasi_id" class="form-label">Lokasi Barang</label>
                    <select class="form-select" id="lokasi_id" name="lokasi_id">
                        <option value="">Semua Lokasi</option>
                        @php
                            $lokasis = $barangs->pluck('lokasi')->filter()->unique('id')->sortBy('nama_lokasi');
                        @endphp
                        @foreach($lokasis as $lokasi)
                            <option value="{{ $lokasi->id }}" {{ request('lokasi_id') == $lokasi->id ? 'selected' : '' }}>
                                {{ $lokasi->nama_lokasi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Pinjam -->
                <div class="col-md-6">
                    <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                    <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ request('tanggal_pinjam') }}">
                </div>

                <!-- Tanggal Kembali -->
                <div class="col-md-6">
                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" value="{{ request('tanggal_kembali') }}">
                </div>

                <!-- Action Buttons -->
                <div class="col-12">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Reset Filter
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Active Filters Display -->
@if(request()->hasAny(['search', 'status', 'tanggal_pinjam', 'tanggal_kembali', 'lokasi_id']))
    <div class="alert alert-info mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong>Filter Aktif:</strong>
                @if(request('search'))
                    <span class="badge bg-primary me-1">Pencarian: {{ request('search') }}</span>
                @endif
                @if(request('status'))
                    <span class="badge bg-primary me-1">Status: {{ request('status') }}</span>
                @endif
                @if(request('lokasi_id'))
                    @php
                        $lokasis = $barangs->pluck('lokasi')->filter()->unique('id');
                        $selectedLokasi = $lokasis->where('id', request('lokasi_id'))->first();
                    @endphp
                    @if($selectedLokasi)
                        <span class="badge bg-primary me-1">Lokasi: {{ $selectedLokasi->nama_lokasi }}</span>
                    @endif
                @endif
                @if(request('tanggal_pinjam'))
                    <span class="badge bg-primary me-1">Tanggal Pinjam: {{ request('tanggal_pinjam') }}</span>
                @endif
                @if(request('tanggal_kembali'))
                    <span class="badge bg-primary me-1">Tanggal Kembali: {{ request('tanggal_kembali') }}</span>
                @endif
            </div>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-x"></i> Hapus Semua Filter
            </a>
        </div>
    </div>
@endif
