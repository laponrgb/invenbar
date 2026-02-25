<x-main-layout :titlePage="__('Dashboard')">
    <!-- Welcome Card Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body py-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1 text-primary">Selamat Datang, {{ auth()->user()->name }}! 👋</h4>
                            <p class="card-text mb-0 opacity-90">Kelola inventaris Anda dengan mudah dan efisien</p>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="bi bi-boxes" style="font-size: 3rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    @include('dashboard-partials.list-kartu-total')

    <!-- Main Content Grid -->
    <div class="row g-4 mt-1">
        <!-- Kondisi Barang Card -->
        <div class="col-lg-6 col-xl-6">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                <div class="card-header border-0 bg-white py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-3">
                            <i class="bi bi-check-circle text-primary"></i>
                        </div>
                        <h6 class="mb-0 fw-600">Ringkasan Kondisi Barang</h6>
                    </div>
                </div>
                <div class="card-body px-4">
                    @include('dashboard-partials.list-kondisi-barang')
                </div>
            </div>
        </div>

        <!-- Barang Terbaru Card -->
        <div class="col-lg-6 col-xl-6">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                <div class="card-header border-0 bg-white py-3 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-info bg-opacity-10 p-2 rounded-3">
                                <i class="bi bi-plus-circle text-info"></i>
                            </div>
                            <h6 class="mb-0 fw-600">5 Barang Terbaru Ditambahkan</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    @include('dashboard-partials.list-barang-terbaru')
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="row g-4 mt-1 mb-4">
        <!-- Peminjaman Terakhir Card -->
        <div class="col-lg-6 col-xl-6">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                <div class="card-header border-0 bg-white py-3 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-warning bg-opacity-10 p-2 rounded-3">
                                <i class="bi bi-calendar-check text-warning"></i>
                            </div>
                            <h6 class="mb-0 fw-600">Peminjaman Terakhir Dilakukan</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    @include('dashboard-partials.list-barang-dipinjam')
                </div>
            </div>
        </div>

        <!-- Barang Harus Kembali Card -->
        <div class="col-lg-6 col-xl-6">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                <div class="card-header border-0 bg-white py-3 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-danger bg-opacity-10 p-2 rounded-3">
                                <i class="bi bi-exclamation-circle text-danger"></i>
                            </div>
                            <h6 class="mb-0 fw-600">Barang Harus Segera Dikembalikan</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    @include('dashboard-partials.list-barang-harus-kembali')
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient {
            background-attachment: fixed;
        }
        
        .hover-shadow {
            transition: all 0.3s ease;
        }
        
        .hover-shadow:hover {
            transform: translateY(-4px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.15) !important;
        }
        
        .fw-600 {
            font-weight: 600;
        }
        
        .transition {
            transition: all 0.2s ease-in-out;
        }
    </style>
</x-main-layout>
