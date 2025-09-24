<x-table-list>
    <x-slot name="header">
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>&nbsp;</th>
        </tr>
    </x-slot>

    @forelse ($users as $index => $user)
        @php
            [$role] = $user->getRoleNames();
        @endphp
        <tr>
            <td>{{ $users->firstItem() + $index }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <span class="badge bg-primary">
                    {{ ucwords($role) }}
                </span>
            </td>
            <td>
                <x-tombol-aksi :href="route('user.edit', $user->id)" type="edit" />
                <x-tombol-aksi :href="route('user.destroy', $user->id)" type="delete" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">
                <div class="alert alert-danger">
                    Data user belum tersedia.
                </div>
            </td>
        </tr>
    @endforelse
</x-table-list>
