@props(['judul', 'jumlah', 'kondisi', 'color'])

<h4 class="small font-weight-bold">
    {{ $judul }}
    <span class="float-end">{{ $kondisi }}</span>
</h4>

<div class="progress mb-4">
    <div 
        class="progress-bar bg-{{ $color }}" 
        role="progressbar"
        style="width: {{ $jumlah > 0 ? ($kondisi / $jumlah) * 100 : 0 }}%;"
        aria-valuenow="{{ $jumlah > 0 ? ($kondisi / $jumlah) * 100 : 0 }}"
        aria-valuemin="0" 
        aria-valuemax="100"
    >
        {{ $jumlah > 0 ? round(($kondisi / $jumlah) * 100) : 0 }}%
    </div>
</div>
