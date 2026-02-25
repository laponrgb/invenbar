<x-main-layout :title-page="'Edit Barang'">
    <div class="container-fluid px-3 py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white border-bottom border-light py-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="bi bi-pencil-square text-warning" style="font-size: 1.8rem;"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-bold">Edit Barang</h4>
                                    <small class="text-muted">Perbarui informasi barang sesuai kebutuhan</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @include('barang.partials.form', ['update' => true])
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-main-layout>
