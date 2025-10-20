<x-main-layout title-page="Perpanjangan Peminjaman">
    <div class="card">
        <div class="card-header">
            <strong>Perpanjang Tanggal Kembali</strong>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <div><strong>Kode</strong>: <span class="badge bg-info text-dark">{{ $peminjaman->kode_peminjaman }}</span></div>
                <div><strong>Peminjam</strong>: {{ $peminjaman->nama_peminjam }}</div>
                <div><strong>Tanggal Pinjam</strong>: {{ $peminjaman->tanggal_pinjam }}</div>
                <div><strong>Tanggal Kembali Saat Ini</strong>: {{ $peminjaman->tanggal_kembali ?? '-' }}</div>
            </div>

            <form method="POST" action="{{ route('peminjaman.extend', $peminjaman->id) }}">
                @csrf
                @method('PATCH')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kembali Baru</label>
                        <input type="date" name="tanggal_kembali" class="form-control" value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}" required>
                        @error('tanggal_kembali')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-main-layout>


