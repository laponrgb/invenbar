<x-table-list>
    <x-slot name="header">
        <tr>
            <th>#</th>
            <th>Nama lokasi</th>
            @can('manage lokasi')
                <th>&nbsp;</th>
            @endcan
        </tr>
    </x-slot>

    @forelse ($lokasis as $index => $lokasi)
        <tr>
            <td>{{ $lokasis->firstItem() + $index }}</td>
            <td>{{ $lokasi->nama_lokasi }}</td>
            @can('manage lokasi')
                <td>
                    <x-tombol-aksi :href="route('lokasi.edit', $lokasi->id)" type="edit" />
                    <x-tombol-aksi :href="route('lokasi.destroy', $lokasi->id)" type="delete" />
                </td>
            @endcan
        </tr>
    @empty
        <tr>
            <td colspan="3" class="text-center">
                <div class="alert alert-danger">
                    Data lokasi belum tersedia.
                </div>
            </td>
        </tr>
    @endforelse
</x-table-list>
