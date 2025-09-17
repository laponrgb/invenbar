<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Lokasi</th>
            <th>Tgl. Pengadaan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($barangTerbaru as $barang)
            <tr>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->lokasi->nama_lokasi }}</td>
                <td>{{ date('d-m-Y', strtotime($barang->tanggal_pengadaan)) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">Belum ada data barang.</td>
            </tr>
        @endforelse
    </tbody>
</table>
