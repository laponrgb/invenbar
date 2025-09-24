<x-main-layout title-page="Tambah User">
    <div class="row">
        <form class="card col-lg-6" action="{{ route('user.store') }}" method="POST">
            <div class="card-body">
                @include('user.partials.form')
            </div>
        </form>
    </div>
</x-main-layout>
