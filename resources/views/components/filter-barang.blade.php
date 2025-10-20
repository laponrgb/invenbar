<form action="?" method="get" class="filter-form">
    <div class="row g-3">
        <!-- Search Input -->
        <div class="col-md-3">
            <label class="form-label">Cari Barang</label>
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Nama/Kode barang..." 
                value="{{ request('search') }}"
            >
        </div>

        <!-- Kategori Filter -->
        <div class="col-md-2">
            <label class="form-label">Kategori</label>
            <select name="kategori_id" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Sumber Dana Filter -->
        <div class="col-md-2">
            <label class="form-label">Sumber Dana</label>
            <select name="sumberdana_id" class="form-select">
                <option value="">Semua Sumber Dana</option>
                @foreach($sumberdanas as $sumberdana)
                    <option value="{{ $sumberdana->id }}" {{ request('sumberdana_id') == $sumberdana->id ? 'selected' : '' }}>
                        {{ $sumberdana->nama_sumberdana }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Kondisi Filter -->
        <div class="col-md-2">
            <label class="form-label">Kondisi</label>
            <select name="kondisi" class="form-select">
                <option value="">Semua Kondisi</option>
                <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="rusak_ringan" {{ request('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="rusak_berat" {{ request('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                <option value="kosong" {{ request('kondisi') == 'kosong' ? 'selected' : '' }}>Kosong</option>
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="col-md-3 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Filter
            </button>
            <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
        </div>
    </div>

    <!-- Active Filters Display -->
    @if(request('search') || request('kategori_id') || request('sumberdana_id') || request('kondisi'))
        <div class="mt-3">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <span class="text-muted small">Filter Aktif:</span>
                @if(request('search'))
                    <span class="badge bg-primary">
                        <i class="bi bi-search"></i> "{{ request('search') }}"
                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-white ms-1">×</a>
                    </span>
                @endif
                @if(request('kategori_id'))
                    @php $selectedKategori = $kategoris->firstWhere('id', request('kategori_id')); @endphp
                    <span class="badge bg-info">
                        <i class="bi bi-tag"></i> {{ $selectedKategori->nama_kategori ?? 'Kategori' }}
                        <a href="{{ request()->fullUrlWithQuery(['kategori_id' => null]) }}" class="text-white ms-1">×</a>
                    </span>
                @endif
                @if(request('sumberdana_id'))
                    @php $selectedSumberdana = $sumberdanas->firstWhere('id', request('sumberdana_id')); @endphp
                    <span class="badge bg-success">
                        <i class="bi bi-currency-dollar"></i> {{ $selectedSumberdana->nama_sumberdana ?? 'Sumber Dana' }}
                        <a href="{{ request()->fullUrlWithQuery(['sumberdana_id' => null]) }}" class="text-white ms-1">×</a>
                    </span>
                @endif
                @if(request('kondisi'))
                    @php
                        $kondisiLabels = [
                            'baik' => 'Baik',
                            'rusak_ringan' => 'Rusak Ringan',
                            'rusak_berat' => 'Rusak Berat',
                            'kosong' => 'Kosong'
                        ];
                    @endphp
                    <span class="badge bg-warning text-dark">
                        <i class="bi bi-exclamation-triangle"></i> {{ $kondisiLabels[request('kondisi')] ?? 'Kondisi' }}
                        <a href="{{ request()->fullUrlWithQuery(['kondisi' => null]) }}" class="text-dark ms-1">×</a>
                    </span>
                @endif
            </div>
        </div>
    @endif
</form>
