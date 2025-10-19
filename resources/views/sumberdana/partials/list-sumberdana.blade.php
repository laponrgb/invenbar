<x-table-list>
    <x-slot name="header">
        <tr>
            <th>#</th>
            <th>Nama Sumber Dana</th>
            @can('manage sumberdana')
                <th>&nbsp;</th>
            @endcan
        </tr>
    </x-slot>

    @forelse ($sumberdanas as $index => $sumberdana)
        <tr>
            <td>{{ $sumberdanas->firstItem() + $index }}</td>
            <td>{{ $sumberdana->nama_sumberdana }}</td>
            @can('manage sumberdana')
                <td>
                    <x-tombol-aksi :href="route('sumberdana.edit', $sumberdana->id)" type="edit" />
                    <x-tombol-aksi :href="route('sumberdana.destroy', $sumberdana->id)" type="delete" />
                </td>
            @endcan
        </tr>
    @empty
        <tr>
            <td colspan="3" class="text-center">
                <div class="alert alert-danger">
                    Data sumberdana belum tersedia.
                </div>
            </td>
        </tr>
    @endforelse
</x-table-list>
