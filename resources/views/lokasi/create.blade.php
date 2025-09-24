<x-main-layout title-page="Tambah lokasi">
    <div class="row">
        <form class="card col-lg-6" action="{{ route('lokasi.store') }}" method="POST">
            <div class="card-body">
                @include('lokasi.partials.form')
            </div>
        </form>
    </div>
</x-main-layout>
