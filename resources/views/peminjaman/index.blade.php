<x-main-layout title-page="Peminjaman Barang">
    <div class="card">
        <div class="card-body">
            @include('peminjaman.partials.toolbar')
            <x-notif-alert class="mt-3" />
        </div>

        @include('peminjaman.partials.list-peminjam')

        <div class="card-body">
            {{ $peminjamans->links() }}
        </div>
    </div>
</x-main-layout>
