<x-main-layout title-page="Peminjaman Barang">
    <div class="card">
        <div class="card-body">
            @include('peminjaman.partials.toolbar')
            <x-notif-alert class="mt-3" />
            
            <!-- Results Summary -->
            @if(request()->hasAny(['search', 'status', 'tanggal_pinjam', 'tanggal_kembali', 'lokasi_id']))
                <div class="alert alert-light border mb-3">
                    <i class="bi bi-info-circle"></i>
                    Menampilkan {{ $peminjamans->count() }} dari {{ $peminjamans->total() }} data peminjaman
                </div>
            @endif
        </div>

        @include('peminjaman.partials.list-peminjam')

        <div class="card-body">
            {{ $peminjamans->links() }}
        </div>
    </div>
</x-main-layout>
