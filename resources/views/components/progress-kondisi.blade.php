@props(['judul', 'jumlah', 'kondisi', 'color'])

@php
    $jumlah = (float) $jumlah;
    $kondisi = (float) $kondisi;

    $persen = $jumlah > 0 ? ($kondisi / $jumlah * 100) : 0.0;
    $persenFormatted = sprintf('%.2f', $persen);

    $textColor = match($color) {
        'warning', 'light', 'info' => 'text-dark',
        default => 'text-white'
    };

    // Warna teks luar kalau progress kecil
    $outerTextColor = '#555';
@endphp

<div class="mb-3">
    <div class="d-flex justify-content-between mb-1 fw-semibold">
        <span>{{ $judul }}</span>
        <span>{{ $kondisi }} dari {{ $jumlah }}</span>
    </div>

    <div class="position-relative" style="height: 32px;">
        {{-- Background progress --}}
        <div class="progress rounded-pill" style="height: 100%; background-color: #e9ecef;">
            <div 
                class="progress-bar bg-{{ $color }} {{ $textColor }} rounded-pill" 
                role="progressbar" 
                style="width: {{ $persen }}%; transition: width 0.6s ease;" 
                aria-valuenow="{{ $persenFormatted }}" 
                aria-valuemin="0" 
                aria-valuemax="100"
            ></div>
        </div>

        {{-- Teks persentase di tengah, selalu kelihatan --}}
        <div class="position-absolute top-50 start-50 translate-middle fw-semibold" 
             style="pointer-events:none; color: {{ $persen > 15 ? 'white' : $outerTextColor }};">
            {{ $persenFormatted }}%
        </div>
    </div>
</div>
