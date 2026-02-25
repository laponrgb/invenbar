<a href="{{ route($route) }}" class="card border-0 shadow-sm h-100 w-100 text-decoration-none card-stat transition" style="position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; right: -50px; font-size: 5rem; opacity: 0.05;">
        <i class="bi {{ $icon }}"></i>
    </div>
    <div class="card-body position-relative">
        <div class="row align-items-center">
            <div class="col">
                <div class="text-muted small fw-600 mb-2 text-uppercase" style="letter-spacing: 0.5px; font-size: 0.75rem;">
                    {{ $text }}
                </div>
                <h3 class="mb-0 text-{{ $color }} fw-700">{{ $total }}</h3>
            </div>
            <div class="col-auto">
                <div class="p-3 bg-{{ $color }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi {{ $icon }} text-{{ $color }} fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</a>

<style>
    .card-stat {
        color: #333 !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .card-stat:hover {
        transform: translateY(-8px) !important;
        box-shadow: 0 1.5rem 3rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
