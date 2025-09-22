<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <th style="width: 30%;">Nama Barang</th>
            <td>{{ $barang->nama_barang }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td>{{ $barang->lokasi->nama_lokasi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ $barang->jumlah }} {{ $barang->satuan }}</td>
        </tr>
        <tr>
            <th>Kondisi</th>
            <td>
                @php
                    $badgeClass = 'bg-success';
                    if ($barang->kondisi === 'Rusak Ringan') {
                        $badgeClass = 'bg-warning text-dark';
                    } elseif ($barang->kondisi === 'Rusak Berat') {
                        $badgeClass = 'bg-danger';
                    }
                @endphp
                <span class="badge {{ $badgeClass }}">{{ $barang->kondisi }}</span>
            </td>
        </tr>
        <tr>
            <th>Tanggal Pengadaan</th>
            <td>{{ \Carbon\Carbon::parse($barang->tanggal_pengadaan)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <th>Terakhir Diperbarui</th>
            <td>{{ $barang->updated_at->translatedFormat('d F Y, H:i') }}</td>
        </tr>
    </tbody>
</table>
