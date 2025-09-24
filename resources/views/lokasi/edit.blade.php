<x-main-layout title-page="Edit lokasi">
    <div class="row">
        <form class="card col-lg-6" action="{{ route('lokasi.update', $lokasi->id) }}" method="POST">
            <div class="card-body">
                @method('PUT')
                @include('lokasi.partials.form', ['update' => true])
            </div>
        </form>
    </div>
</x-main-layout>
