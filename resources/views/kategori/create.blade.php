<x-main-layout title-page="Tambah Kategori">
    <div class="row">
        <form class="card col-lg-6" action="{{ route('kategori.store') }}" method="POST">
            <div class="card-body">
                @include('kategori.partials.form')
            </div>
        </form>
    </div>
</x-main-layout>
