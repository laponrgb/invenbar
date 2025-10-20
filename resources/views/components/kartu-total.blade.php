<div class="card shadow py-2 border-{{ $color }} h-100 w-100">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="fw-bold text-{{ $color }} mb-1">
                    {{ $text }}
                </div>
                <h5>{{ $total }}</h5>
            </div>
            <div class="col-auto">
                <i class="bi {{ $icon }} text-{{ $color }} fs-1"></i>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route($route) }}" class="text-secondary text-decoration-none">
            Lihat Selengkapnya
            <i class="bi bi-box-arrow-up-right"></i>
        </a>
    </div>
</div>
