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

    $isZero = $persen <= 0.0;
@endphp

<div class="mb-3">
    <div class="d-flex justify-content-between mb-1">
        <span>{{ $judul }}</span>
        <span>{{ $kondisi }} dari {{ $jumlah }}</span>
    </div>

    <div class="progress" style="height: 30px; position: relative; overflow: visible;">
        @if ($isZero)
            <div style="position: absolute; left: 8px; top: 50%; transform: translateY(-50%); font-weight: bold; color: #555;">
                {{ $persenFormatted }}%
            </div>
        @endif

        <div 
            class="progress-bar bg-{{ $color }} d-flex align-items-center justify-content-center {{ $textColor }}" 
            role="progressbar" 
            style="width: {{ $persen }}%;" 
            aria-valuenow="{{ $persenFormatted }}" 
            aria-valuemin="0" 
            aria-valuemax="100"
        >
            @unless ($isZero)
                <strong>{{ $persenFormatted }}%</strong>
            @endunless
        </div>
    </div>
</div>
