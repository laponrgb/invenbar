<div class="card-body">
    @php
        // Hitung total kondisi sebenarnya
        $totalKondisi = $kondisiBaik + $kondisiRusakRingan + $kondisiRusakBerat;
        $totalKondisi = $totalKondisi > 0 ? $totalKondisi : 1;

        $kondisis = [
            [
                'judul'   => 'Baik',
                'jumlah'  => $totalKondisi,
                'kondisi' => $kondisiBaik,
                'color'   => 'success',
            ],
            [
                'judul'   => 'Rusak Ringan',
                'jumlah'  => $totalKondisi,
                'kondisi' => $kondisiRusakRingan,
                'color'   => 'warning',
            ],
            [
                'judul'   => 'Rusak Berat',
                'jumlah'  => $totalKondisi,
                'kondisi' => $kondisiRusakBerat,
                'color'   => 'danger',
            ],
        ];
    @endphp

    @foreach ($kondisis as $kondisi)
        @php extract($kondisi); @endphp
        <x-progress-kondisi 
            :judul="$judul" 
            :jumlah="$jumlah" 
            :kondisi="$kondisi" 
            :color="$color" 
        />
    @endforeach
</div>
