<div class="row mb-3">
    <div class="col">
        <x-tombol-tambah label="Tambah Data Guru" href="{{ route('data-guru.create') }}" />
        <a href="{{ route('data-guru.import.form') }}" class="btn btn-success">
            <i class="bi bi-upload"></i> Import CSV
        </a>
    </div>
</div>

<!-- Search Form -->
<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0">
            <i class="bi bi-search"></i> Pencarian
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('data-guru.index') }}" class="row g-3">
            <div class="col-md-8">
                <label for="search" class="form-label">Cari NIP/Nama Guru</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Masukkan NIP atau nama guru...">
            </div>
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('data-guru.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
