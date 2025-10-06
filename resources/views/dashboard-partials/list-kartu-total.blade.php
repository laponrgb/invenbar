<div class="row">
    @php
        $kartus = [
            [
                'text' => 'TOTAL BARANG',
                'total' => $jumlahBarang, // ✅ pakai jumlahBarang dari semua kondisi
                'route' => 'barang.index',
                'icon' => 'bi-box-seam',
                'color' => 'primary',
            ],
            [
                'text' => 'TOTAL KATEGORI',
                'total' => $jumlahKategori,
                'route' => 'kategori.index',
                'icon' => 'bi-tag',
                'color' => 'secondary',
            ],
            [
                'text' => 'TOTAL LOKASI',
                'total' => $jumlahLokasi,
                'route' => 'lokasi.index',
                'icon' => 'bi-geo-alt',
                'color' => 'success',
            ],
            [
                'text' => 'TOTAL USER',
                'total' => $jumlahUser,
                'route' => 'user.index',
                'icon' => 'bi-people',
                'color' => 'danger',
                'role' => 'admin',
            ],
        ];
    @endphp

    @foreach ($kartus as $kartu)
        @php extract($kartu); @endphp

        @isset($role)
            @role($role)
                <x-kartu-total :text="$text" :route="$route" :total="$total" :icon="$icon" :color="$color" />
            @endrole
        @else
            <x-kartu-total :text="$text" :route="$route" :total="$total" :icon="$icon" :color="$color" />
        @endisset
    @endforeach
</div>
