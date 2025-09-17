@props(['judul', 'deskripsi'])

<div class="col-md-4">
    <div class="card shadow-sm h-100">
        <div class="card-body">
            <h5 class="card-title">{{ $judul }}</h5>
            <p class="card-text">{{ $deskripsi }}</p>
        </div>
    </div>
</div>
