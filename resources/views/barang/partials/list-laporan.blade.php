<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Jumlah</th>
            <th>Kondisi</th>
            <th>Tgl. Pengadaan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($barangs as $index => $barang)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $barang->kode_barang }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->kategori->nama_kategori }}</td>
                <td>{{ $barang->lokasi->nama_lokasi }}</td>
                <td>{{ $barang->jumlah }} {{ $barang->satuan }}</td>
                <td>{{ $barang->kondisi }}</td>
                <td>{{ \Carbon\Carbon::parse($barang->tanggal_pengadaan)->format('d-m-Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align: center;">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
</table>
