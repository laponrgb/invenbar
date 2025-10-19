<x-main-layout title-page="Edit Sumber Dana">
    <div class="row">
        <form class="card col-lg-6" action="{{ route('sumberdana.update', $sumberdana->id) }}" method="POST">
            <div class="card-body">
                @method('PUT')
                @include('sumberdana.partials.form', ['update' => true])
            </div>
        </form>
    </div>
</x-main-layout>
