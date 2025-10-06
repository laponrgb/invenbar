        <x-table-list>
            <x-slot name="header">
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Jumlah</th>
                    <th>Kondisi</th>
                    <th>&nbsp;</th>
                </tr>
            </x-slot>

            @forelse ($barangs as $index => $barang)
                <tr>
                    <td>{{ $barangs->firstItem() + $index }}</td>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->kategori->nama_kategori }}</td>
                    <td>{{ $barang->lokasi->nama_lokasi }}</td>
                    <td>{{ $barang->jumlah }} {{ $barang->satuan }}</td>
                    <td>
                        <div class="d-flex flex-column gap-1">
                            @if ($barang->jumlah_baik > 0)
                                <span class="badge bg-info">
                                    Baik: {{ $barang->jumlah_baik }}
                                </span>
                            @endif

                            @if ($barang->jumlah_rusak_ringan > 0)
                                <span class="badge bg-warning text-dark">
                                    Rusak Ringan: {{ $barang->jumlah_rusak_ringan }}
                                </span>
                            @endif

                            @if ($barang->jumlah_rusak_berat > 0)
                                <span class="badge bg-danger">
                                    Rusak Berat: {{ $barang->jumlah_rusak_berat }}
                                </span>
                            @endif
                        </div>
                    </td>


                    <td class="text-end">
                        @can('manage barang')
                            <x-tombol-aksi href="{{ route('barang.show', $barang->id) }}" type="show" />
                            <x-tombol-aksi href="{{ route('barang.edit', $barang->id) }}" type="edit" />
                        @endcan
                        @can('delete barang')
                            <x-tombol-aksi href="{{ route('barang.destroy', $barang->id) }}" type="delete" />
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        <div class="alert alert-danger">
                            Data barang belum tersedia.
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-table-list>
