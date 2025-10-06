<x-main-layout title-page="Edit Peminjaman">
    <form class="card" action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            @include('peminjaman.partials.form', ['update' => true])
        </div>
    </form>
</x-main-layout>
