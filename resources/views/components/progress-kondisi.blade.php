@props(['judul', 'jumlah', 'kondisi', 'color'])

@php
    $jumlah = (float) $jumlah;
    $kondisi = (float) $kondisi;

    $persen = $jumlah > 0 ? ($kondisi / $jumlah * 100) : 0.0;
    $persenFormatted = sprintf('%.1f', $persen);

    $textColor = match($color) {
        'warning', 'light', 'info' => 'text-dark',
        default => 'text-white'
    };

    $outerTextColor = '#555';
@endphp

<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} rounded-circle" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                {{ $kondisi }}
            </span>
            <div>
                <div class="fw-600 mb-0">{{ $judul }}</div>
                <small class="text-muted">{{ $kondisi }} dari {{ $jumlah }} barang</small>
            </div>
        </div>
        <span class="fw-700 text-{{ $color }}" style="font-size: 1.2rem;">{{ $persenFormatted }}%</span>
    </div>

    <div class="progress rounded-pill" style="height: 12px; background-color: #e9ecef;">
        <div 
            class="progress-bar bg-{{ $color }} rounded-pill" 
            role="progressbar" 
            style="width: {{ $persen }}%; transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);" 
            aria-valuenow="{{ $persenFormatted }}" 
            aria-valuemin="0" 
            aria-valuemax="100"
        ></div>
    </div>
</div>
