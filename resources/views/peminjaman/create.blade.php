<x-main-layout title-page="Tambah Peminjaman">
    <form class="card"
          action="{{ route('peminjaman.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            @include('peminjaman.partials.form')
        </div>
    </form>
</x-main-layout>