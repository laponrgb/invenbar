<!-- Section 1: Identitas Barang -->
<div class="mb-4">
    <div class="bg-light p-3 rounded-3 border-start border-5 border-primary mb-3">
        <i class="bi bi-info-circle text-primary me-2"></i>
        <strong>Identitas Barang</strong>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <x-form-input 
                label="Kode Barang" 
                name="kode_barang" 
                :value="$barang->kode_barang ?? ''" 
                placeholder="Contoh: BRG001"
                required 
            />
        </div>
        <div class="col-md-6">
            <x-form-input 
                label="Nama Barang" 
                name="nama_barang" 
                :value="$barang->nama_barang ?? ''" 
                placeholder="Contoh: Meja Kerja"
                required 
            />
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <x-form-select 
                label="Kategori" 
                name="kategori_id" 
                :value="$barang->kategori_id ?? ''"
                :option-data="$kategori" 
                option-label="nama_kategori" 
                option-value="id"
                required 
            />
        </div>
        <div class="col-md-6">
            <x-form-select 
                label="Lokasi" 
                name="lokasi_id" 
                :value="$barang->lokasi_id ?? ''"
                :option-data="$lokasi" 
                option-label="nama_lokasi" 
                option-value="id"
                required 
            />
        </div>
    </div>
</div>

<hr class="my-4" style="border-style: dashed; opacity: 0.5;">

<!-- Section 2: Jumlah & Kondisi -->
<div class="mb-4">
    <div class="bg-light p-3 rounded-3 border-start border-5 border-success mb-3">
        <i class="bi bi-boxes text-success me-2"></i>
        <strong>Jumlah & Kondisi Barang</strong>
    </div>

    <div class="alert alert-info small mb-3">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Distribusi Jumlah:</strong> Total jumlah otomatis dihitung dari jumlah baik + rusak ringan + rusak berat
    </div>

    <div class="row mb-3">
        <div class="col-md-3 col-sm-6">
            <x-form-input 
                label="Jumlah Baik" 
                name="jumlah_baik" 
                type="number" 
                :value="$barang->jumlah_baik ?? 0"
                placeholder="0"
            />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-form-input 
                label="Rusak Ringan" 
                name="jumlah_rusak_ringan" 
                type="number" 
                :value="$barang->jumlah_rusak_ringan ?? 0"
                placeholder="0"
            />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-form-input 
                label="Rusak Berat" 
                name="jumlah_rusak_berat" 
                type="number" 
                :value="$barang->jumlah_rusak_berat ?? 0"
                placeholder="0"
            />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-form-input 
                label="Satuan" 
                name="satuan" 
                :value="$barang->satuan ?? ''" 
                placeholder="Contoh: Buah, Unit"
            />
        </div>
    </div>

    <!-- Total Preview -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="bg-light p-3 rounded-2 border">
                <small class="text-muted d-block mb-2">Total Jumlah Barang</small>
                <h5 class="mb-0" id="totalJumlah">
                    <span class="badge bg-primary fs-6">
                        {{ isset($barang) ? ($barang->jumlah_baik + $barang->jumlah_rusak_ringan + $barang->jumlah_rusak_berat) : 0 }}
                    </span>
                </h5>
            </div>
        </div>
    </div>
</div>

<hr class="my-4" style="border-style: dashed; opacity: 0.5;">

<!-- Section 3: Informasi Tambahan -->
<div class="mb-4">
    <div class="bg-light p-3 rounded-3 border-start border-5 border-warning mb-3">
        <i class="bi bi-calendar-event text-warning me-2"></i>
        <strong>Informasi Tambahan</strong>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            @php
                $tanggal = isset($barang->tanggal_pengadaan) 
                    ? date('Y-m-d', strtotime($barang->tanggal_pengadaan)) 
                    : null;
            @endphp
            <x-form-input 
                label="Tanggal Pengadaan" 
                name="tanggal_pengadaan" 
                type="date" 
                :value="$tanggal" 
            />
        </div>
        <div class="col-md-6">
            <x-form-select 
                label="Sumber Dana" 
                name="sumberdana_id" 
                :value="$barang->sumberdana_id ?? ''"
                :option-data="$sumberdana" 
                option-label="nama_sumberdana" 
                option-value="id" 
            />
        </div>
    </div>
</div>

<hr class="my-4" style="border-style: dashed; opacity: 0.5;">

<!-- Section 4: Gambar Barang -->
<div class="mb-4">
    <div class="bg-light p-3 rounded-3 border-start border-5 border-danger mb-3">
        <i class="bi bi-image text-danger me-2"></i>
        <strong>Gambar Barang</strong>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label class="form-label fw-bold mb-2">
                <i class="bi bi-upload me-2"></i>Upload Gambar
                <small class="fw-normal text-muted">(JPG, PNG, max 2MB)</small>
            </label>
            <input type="file" name="gambar" class="form-control" id="gambarInput" accept="image/jpeg,image/png">
            <small class="text-muted d-block mt-2">Format: JPG, PNG. Ukuran maksimal: 2MB</small>
        </div>
        <div class="col-md-6">
            @if(isset($barang) && $barang->gambar)
                <label class="form-label fw-bold mb-2">Gambar Saat Ini</label>
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $barang->gambar) }}" 
                         alt="{{ $barang->nama_barang }}"
                         class="img-fluid rounded-3 shadow-sm border border-2"
                         style="max-height: 200px; width: 100%; object-fit: cover;">
                </div>
            @else
                <div id="previewContainer" style="display:none;" class="col-md-6">
                    <label class="form-label fw-bold mb-2">Preview Gambar</label>
                    <img id="gambarPreview" class="img-fluid rounded-3 shadow-sm border border-2" 
                         style="max-height: 200px; width: 100%; object-fit: cover;">
                </div>
            @endif
        </div>
    </div>
</div>

<hr class="my-4" style="border-style: dashed; opacity: 0.5;">

<!-- Action Buttons -->
<div class="mt-5 d-flex gap-2 flex-wrap">
    <button type="submit" class="btn btn-primary btn-lg rounded-3">
        <i class="bi {{ isset($update) ? 'bi-pencil-square' : 'bi-plus-circle' }} me-2"></i>
        {{ isset($update) ? 'Update Barang' : 'Tambah Barang' }}
    </button>
    <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary btn-lg rounded-3">
        <i class="bi bi-arrow-left me-2"></i> Kembali
    </a>
</div>

<style>
    .form-label {
        color: #333;
        font-size: 0.95rem;
    }

    .form-control, .form-select {
        border-radius: 0.5rem;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        padding: 0.6rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .alert {
        border-radius: 0.75rem;
        border: 1px solid;
    }

    .badge {
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .btn {
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    hr {
        margin: 2rem 0;
        border: none;
        height: 1px;
        background: linear-gradient(to right, transparent, #ddd, transparent);
    }

    @media (max-width: 768px) {
        .col-md-3, .col-md-6 {
            margin-bottom: 0.5rem;
        }

        .btn-lg {
            padding: 0.6rem 1.2rem;
            font-size: 1rem;
        }
    }
</style>

<script>
    // Real-time total calculation
    document.addEventListener('DOMContentLoaded', function() {
        const jumlahBaikInput = document.querySelector('input[name="jumlah_baik"]');
        const jumlahRusakRinganInput = document.querySelector('input[name="jumlah_rusak_ringan"]');
        const jumlahRusakBeratInput = document.querySelector('input[name="jumlah_rusak_berat"]');
        const totalJumlahSpan = document.getElementById('totalJumlah');

        function updateTotal() {
            const baik = parseInt(jumlahBaikInput?.value || 0);
            const ringan = parseInt(jumlahRusakRinganInput?.value || 0);
            const berat = parseInt(jumlahRusakBeratInput?.value || 0);
            const total = baik + ringan + berat;
            
            if (totalJumlahSpan) {
                totalJumlahSpan.innerHTML = `<span class="badge bg-primary fs-6">${total}</span>`;
            }
        }

        // Update on input
        jumlahBaikInput?.addEventListener('input', updateTotal);
        jumlahRusakRinganInput?.addEventListener('input', updateTotal);
        jumlahRusakBeratInput?.addEventListener('input', updateTotal);

        // Image preview
        const gambarInput = document.getElementById('gambarInput');
        const previewContainer = document.getElementById('previewContainer');
        const gambarPreview = document.getElementById('gambarPreview');

        if (gambarInput) {
            gambarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        gambarPreview.src = event.target.result;
                        if (previewContainer) previewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
