<x-main-layout :title-page="'Tambah Barang'">
    <div class="container-fluid px-3 py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white border-bottom border-light py-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="bi bi-plus-circle text-primary" style="font-size: 1.8rem;"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-bold">Tambah Barang Baru</h4>
                                    <small class="text-muted">Isi form berikut untuk menambahkan barang ke inventaris</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @include('barang.partials.form')
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-main-layout>
