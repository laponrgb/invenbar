<section id="fitur" class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Fitur Unggulan</h2>
        <div class="row g-4">
            @php
                $fiturs = [
                    [
                        'judul' => 'Manajemen Barang',
                        'deskripsi' => 'Tambah, edit, dan hapus barang dengan mudah sesuai kebutuhan instansi Anda.',
                    ],
                    [
                        'judul' => 'Laporan Cepat',
                        'deskripsi' => 'Dapatkan laporan stok barang secara real-time untuk pengambilan keputusan yang lebih baik.',
                    ],
                    [
                        'judul' => 'Akses Multi-User',
                        'deskripsi' => 'Bekerja sama dengan tim Anda, dengan kontrol hak akses yang terjaga.',
                    ],
                ];
            @endphp

            @foreach ($fiturs as $fitur)
                <x-card-fitur :judul="$fitur['judul']" :deskripsi="$fitur['deskripsi']" />
            @endforeach
        </div>
    </div>
</section>
