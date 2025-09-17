<x-main-layout :title-page="__('Barang')">
    <div class="card">
        <div class="card-body">
            @include('barang.partials.toolbar')
            <x-notif-alert class="mt-4" />
        </div>

        @include('barang.partials.list-barang')

        <div class="card-body">
            {{ $barangs->links() }}
        </div>
    </div>
</x-main-layout>
