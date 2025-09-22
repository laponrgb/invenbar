<x-main-layout :title-page="'Detail Barang'">
    <div class="card my-5">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @include('barang.partials.info-gambar-barang')
                </div>
                <div class="col-md">
                    @include('barang.partials.info-data-barang')
                </div>
            </div>

            <div class="mt-5">
                <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning">
                    Edit
                </a>
                <x-tombol-kembali :href="route('barang.index')" />
            </div>
        </div>
    </div>
</x-main-layout>
