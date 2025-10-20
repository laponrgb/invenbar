<div class="row">
    <div class="col-12">
        <div class="d-flex overflow-auto pb-3 snap-scroll" style="gap: 1rem; scroll-snap-type: x mandatory;">
            @php
                $kartus = [
                    [
                        'text' => 'TOTAL BARANG',
                        'total' => $jumlahBarang,
                        'route' => 'barang.index',
                        'icon' => 'bi-box-seam',
                        'color' => 'primary',
                    ],
                    [
                        'text' => 'PEMINJAMAN',
                        'total' => $jumlahPeminjaman,
                        'route' => 'peminjaman.index',
                        'icon' => 'bi-calendar-check',
                        'color' => 'warning',
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
                        'text' => 'SUMBER DANA',
                        'total' => $jumlahSumberDana,
                        'route' => 'sumberdana.index',
                        'icon' => 'bi-cash-stack',
                        'color' => 'dark',
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
                        <div class="flex-shrink-0 snap-item" style="min-width: calc(33.333% - 0.67rem); scroll-snap-align: start;">
                            <x-kartu-total :text="$text" :route="$route" :total="$total" :icon="$icon" :color="$color" />
                        </div>
                    @endrole
                @else
                    <div class="flex-shrink-0 snap-item" style="min-width: calc(33.333% - 0.67rem); scroll-snap-align: start;">
                        <x-kartu-total :text="$text" :route="$route" :total="$total" :icon="$icon" :color="$color" />
                    </div>
                @endisset
            @endforeach
        </div>
    </div>
</div>
