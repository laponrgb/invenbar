<x-main-layout title-page="lokasi">
    <div class="card">
        <div class="card-body">
            @include('lokasi.partials.toolbar')
            <x-notif-alert class="mt-4" />
        </div>

        @include('lokasi.partials.list-lokasi')

        <div class="card-body">
            {{ $lokasis->links() }}
        </div>
    </div>
</x-main-layout>
