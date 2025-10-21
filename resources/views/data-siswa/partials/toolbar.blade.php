<div class="row mb-3">
    <div class="col">
        <x-tombol-tambah label="Tambah Data Siswa" href="{{ route('data-siswa.create') }}" />
        <a href="{{ route('data-siswa.import.form') }}" class="btn btn-success">
            <i class="bi bi-upload"></i> Import CSV
        </a>
    </div>
</div>

<!-- Search and Filter Form -->
<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0">
            <i class="bi bi-funnel"></i> Pencarian & Filter
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('data-siswa.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari NIS/Nama</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Masukkan NIS atau nama...">
            </div>
            <div class="col-md-3">
                <label for="kelas" class="form-label">Kelas</label>
                <select class="form-select" id="kelas" name="kelas">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>
                            {{ $kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                    <option value="">Semua</option>
                    <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('data-siswa.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
