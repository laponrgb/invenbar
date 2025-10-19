<x-main-layout title-page="Tambah Sumber Dana">
    <div class="row">
        <form class="card col-lg-6" action="{{ route('sumberdana.store') }}" method="POST">
            <div class="card-body">
                @include('sumberdana.partials.form')
            </div>
        </form>
    </div>
</x-main-layout>
