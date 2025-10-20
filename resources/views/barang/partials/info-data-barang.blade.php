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
            <th>Sumber Dana</th>
            <td>{{ $barang->sumberdana->nama_sumberdana ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kondisi</th>
            <td>
                @php
                    $total = $barang->jumlah > 0 ? $barang->jumlah : 1; // hindari pembagian 0
                    $baik = ($barang->jumlah_baik / $total) * 100;
                    $ringan = ($barang->jumlah_rusak_ringan / $total) * 100;
                    $berat = ($barang->jumlah_rusak_berat / $total) * 100;
                @endphp

                <div class="mb-1">
                    @if ($barang->jumlah_baik > 0)
                        <span class="badge bg-success">
                            Baik: {{ $barang->jumlah_baik }} ({{ number_format($baik, 1) }}%)
                        </span>
                    @endif

                    @if ($barang->jumlah_rusak_ringan > 0)
                        <span class="badge bg-warning text-dark">
                            Rusak Ringan: {{ $barang->jumlah_rusak_ringan }} ({{ number_format($ringan, 1) }}%)
                        </span>
                    @endif

                    @if ($barang->jumlah_rusak_berat > 0)
                        <span class="badge bg-danger">
                            Rusak Berat: {{ $barang->jumlah_rusak_berat }} ({{ number_format($berat, 1) }}%)
                        </span>
                    @endif
                </div>

                {{-- Progress bar dihilangkan sesuai permintaan --}}
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
