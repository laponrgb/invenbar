<x-main-layout :titlePage="__('Dashboard')">
    <h3 class="mb-4 fw-light">
        Selamat Datang, <strong>{{ auth()->user()->name }}</strong>!
    </h3>

    @include('dashboard-partials.list-kartu-total')

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6>Ringkasan Kondisi Barang</h6>
                </div>
                @include('dashboard-partials.list-kondisi-barang')
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6>5 Barang Terakhir Ditambahkan</h6>
                </div>
                <div class="card-body table-responsive">
                    @include('dashboard-partials.list-barang-terbaru')
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
