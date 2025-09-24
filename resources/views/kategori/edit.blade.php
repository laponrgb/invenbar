<x-main-layout title-page="Edit Kategori">
    <div class="row">
        <form class="card col-lg-6" action="{{ route('kategori.update', $kategori->id) }}" method="POST">
            <div class="card-body">
                @method('PUT')
                @include('kategori.partials.form', ['update' => true])
            </div>
        </form>
    </div>
</x-main-layout>
