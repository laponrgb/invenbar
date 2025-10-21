@if($dataGuru->count() > 0)
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-muted">
            <i class="bi bi-list-ul"></i> 
            Menampilkan {{ $dataGuru->firstItem() }} - {{ $dataGuru->lastItem() }} dari {{ $dataGuru->total() }} data guru
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll()">
                <i class="bi bi-check-square"></i> Pilih Semua
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">
                <i class="bi bi-square"></i> Batal Pilih
            </button>
            <button type="button" class="btn btn-sm btn-danger" onclick="bulkDelete()" id="bulkDeleteBtn" disabled>
                <i class="bi bi-trash"></i> Hapus Terpilih
            </button>
        </div>
    </div>
@endif

<x-table-list>
    <x-slot name="header">
        <tr>
            <th width="5%">
                <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()">
            </th>
            <th>#</th>
            <th>NIP</th>
            <th>Nama Guru</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>&nbsp;</th>
        </tr>
    </x-slot>

    @forelse ($dataGuru as $index => $guru)
        <tr>
            <td>
                <input type="checkbox" class="guru-checkbox" value="{{ $guru->id }}" onchange="updateBulkDeleteBtn()">
            </td>
            <td>{{ $dataGuru->firstItem() + $index }}</td>
            <td>{{ $guru->nip }}</td>
            <td>{{ $guru->nama_guru }}</td>
            <td>{{ $guru->email }}</td>
            <td>{{ $guru->alamat ?? '-' }}</td>
            <td class="text-end">
                <x-tombol-aksi href="{{ route('data-guru.show', $guru->id) }}" type="show" />
                <x-tombol-aksi href="{{ route('data-guru.edit', $guru->id) }}" type="edit" />
                <x-tombol-aksi href="{{ route('data-guru.destroy', $guru->id) }}" type="delete" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">
                <div class="alert alert-danger mb-0">
                    Data guru belum tersedia.
                </div>
            </td>
        </tr>
    @endforelse
</x-table-list>

<!-- Bulk Delete Form -->
<form id="bulkDeleteForm" method="POST" action="{{ route('data-guru.bulk-delete') }}" style="display: none;">
    @csrf
    <div id="selectedIds"></div>
</form>

<script>
function selectAll() {
    const checkboxes = document.querySelectorAll('.guru-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = true);
    updateBulkDeleteBtn();
}

function deselectAll() {
    const checkboxes = document.querySelectorAll('.guru-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = false);
    document.getElementById('selectAllCheckbox').checked = false;
    updateBulkDeleteBtn();
}

function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.guru-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateBulkDeleteBtn();
}

function updateBulkDeleteBtn() {
    const checkboxes = document.querySelectorAll('.guru-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    
    if (checkboxes.length > 0) {
        bulkDeleteBtn.disabled = false;
        bulkDeleteBtn.textContent = `Hapus Terpilih (${checkboxes.length})`;
    } else {
        bulkDeleteBtn.disabled = true;
        bulkDeleteBtn.textContent = 'Hapus Terpilih';
    }
    
    // Update select all checkbox state
    const allCheckboxes = document.querySelectorAll('.guru-checkbox');
    if (checkboxes.length === allCheckboxes.length) {
        selectAllCheckbox.checked = true;
    } else if (checkboxes.length === 0) {
        selectAllCheckbox.checked = false;
    } else {
        selectAllCheckbox.indeterminate = true;
    }
}

function bulkDelete() {
    const checkboxes = document.querySelectorAll('.guru-checkbox:checked');
    if (checkboxes.length === 0) {
        alert('Pilih minimal satu data untuk dihapus');
        return;
    }
    
    if (confirm(`Apakah Anda yakin ingin menghapus ${checkboxes.length} data guru?`)) {
        const selectedIds = document.getElementById('selectedIds');
        selectedIds.innerHTML = '';
        
        checkboxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_ids[]';
            input.value = checkbox.value;
            selectedIds.appendChild(input);
        });
        
        document.getElementById('bulkDeleteForm').submit();
    }
}
</script>
