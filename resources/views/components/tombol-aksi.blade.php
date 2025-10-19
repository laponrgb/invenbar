@props(['href', 'type'])

@switch($type)
    @case('show')
        <a href="{{ $href }}" class="btn btn-sm btn-info" title="Lihat Detail">
            <i class="bi bi-card-list"></i>
        </a>
        @break

    @case('edit')
        <a href="{{ $href }}" class="btn btn-sm btn-warning" title="Edit Peminjaman">
            <i class="bi bi-pencil-square"></i>
        </a>
        @break

    @case('delete')
        <button type="button" data-url="{{ $href }}" class="btn btn-sm btn-danger" 
            data-bs-toggle="modal" data-bs-target="#deleteModal" title="Hapus Peminjaman">
            <i class="bi bi-x-circle"></i>
        </button>
        @break

    @case('return')
        <form action="{{ $href }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-sm btn-success" title="Kembalikan Barang">
                <i class="bi bi-box-arrow-in-left"></i>
            </button>
        </form>
        @break

    @case('undo')
        <form action="{{ $href }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-sm btn-secondary" title="Batalkan Pengembalian">
                <i class="bi bi-arrow-counterclockwise"></i>
            </button>
        </form>
        @break
@endswitch
