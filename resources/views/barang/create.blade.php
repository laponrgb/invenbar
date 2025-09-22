<x-main-layout :title-page="'Tambah Barang'">
    <form class="card" action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            @include('barang.partials.form')
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</x-main-layout>
