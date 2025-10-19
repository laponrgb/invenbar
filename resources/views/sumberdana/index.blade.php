<x-main-layout title-page="Sumber Dana">
    <div class="card">
        <div class="card-body">
            @include('sumberdana.partials.toolbar')
            <x-notif-alert class="mt-4" />
        </div>

        @include('sumberdana.partials.list-sumberdana')

        <div class="card-body">
            {{ $sumberdanas->links() }}
        </div>
    </div>
</x-main-layout>
