@if ($barang->gambar)
    <div class="card shadow-sm border-0">
        <div class="card-body p-3 text-center">
            <div class="position-relative d-inline-block">
                <img
                    src="{{ asset('storage/gambar-barang/' . $barang->gambar) }}"
                    alt="{{ $barang->nama_barang }}"
                    class="img-fluid rounded-3 border preview-image"
                    style="max-height: 320px; width: auto; cursor: zoom-in;"
                    data-bs-toggle="modal"
                    data-bs-target="#gambarModal-{{ $barang->id }}"
                >
                <div class="position-absolute top-0 end-0 m-2">
                    <span class="badge bg-primary small">Gambar</span>
                </div>
            </div>

            <div class="mt-3 text-start w-100">
                <small class="text-muted d-block">Nama file: <strong>{{ $barang->gambar }}</strong></small>
                <div class="mt-2 d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#gambarModal-{{ $barang->id }}">
                        <i class="bi bi-arrows-fullscreen me-1"></i> Lihat
                    </button>
                    <a href="{{ asset('storage/gambar-barang/' . $barang->gambar) }}" download class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-download me-1"></i> Unduh
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Fullscreen preview -->
    <div class="modal fade" id="gambarModal-{{ $barang->id }}" tabindex="-1" aria-labelledby="gambarModalLabel-{{ $barang->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="d-flex align-items-center justify-content-center p-4" style="min-height: 60vh;">
                        <img src="{{ asset('storage/gambar-barang/' . $barang->gambar) }}" alt="{{ $barang->nama_barang }}" class="img-fluid rounded-3 modal-preview-image" style="max-height: 85vh; cursor: zoom-in;">
                    </div>
                    <div class="position-absolute bottom-0 start-0 m-3 text-white">
                        <small class="bg-dark bg-opacity-50 px-2 py-1 rounded">{{ $barang->nama_barang }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card shadow-sm border-0">
        <div class="card-body d-flex flex-column align-items-center justify-content-center" style="min-height: 300px;">
            <div class="mb-3 text-muted">
                <i class="bi bi-image" style="font-size: 2.4rem;"></i>
            </div>
            <div class="text-muted">Tidak Ada Gambar</div>
            <div class="mt-3">
                <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-upload me-1"></i> Tambah Gambar
                </a>
            </div>
        </div>
    </div>
@endif

<style>
    .preview-image {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .preview-image:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    .modal-preview-image {
        transition: transform 0.25s ease;
    }
    .modal-preview-image.zoomed {
        transform: scale(1.08);
        cursor: zoom-out;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle zoom on modal image when clicked
        document.querySelectorAll('.modal-preview-image').forEach(function(img) {
            img.addEventListener('click', function() {
                img.classList.toggle('zoomed');
            });
        });

        // Ensure zoom removed when modal hidden
        document.querySelectorAll('[id^="gambarModal-"]').forEach(function(modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function (event) {
                const img = modalEl.querySelector('.modal-preview-image');
                if (img) img.classList.remove('zoomed');
            });
        });
    });
</script>
