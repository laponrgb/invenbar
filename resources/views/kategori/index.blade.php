<x-main-layout title-page="Kategori">
    <div class="card">
        <div class="card-body">
            @include('kategori.partials.toolbar')
            <x-notif-alert class="mt-4" />
        </div>

        @include('kategori.partials.list-kategori')

        <div class="card-body">
            {{ $kategoris->links() }}
        </div>
    </div>
</x-main-layout>
