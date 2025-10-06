<x-main-layout title-page="Tambah Peminjaman">
    <form class="card" action="{{ route('peminjaman.store') }}" method="POST">
        @csrf
        <div class="card-body">
            @include('peminjaman.partials.form')
        </div>
    </form>
</x-main-layout>
