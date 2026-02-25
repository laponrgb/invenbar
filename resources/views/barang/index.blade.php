<x-main-layout :title-page="__('Barang')">
    <div class="container-fluid px-0">
        @include('barang.partials.toolbar')
        <x-notif-alert class="mt-3 mx-3" />
        @include('barang.partials.list-barang')
        <div class="card-body">
            {{ $barangs->links() }}
        </div>
    </div>
</x-main-layout>
