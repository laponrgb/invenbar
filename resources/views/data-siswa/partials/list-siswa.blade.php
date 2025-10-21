@if($dataSiswa->count() > 0)
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-muted">
            <i class="bi bi-list-ul"></i> 
            Menampilkan {{ $dataSiswa->firstItem() }} - {{ $dataSiswa->lastItem() }} dari {{ $dataSiswa->total() }} data siswa
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
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Jenis Kelamin</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>&nbsp;</th>
        </tr>
    </x-slot>

    @forelse ($dataSiswa as $index => $siswa)
        <tr>
            <td>
                <input type="checkbox" class="student-checkbox" value="{{ $siswa->id }}" onchange="updateBulkDeleteBtn()">
            </td>
            <td>{{ $dataSiswa->firstItem() + $index }}</td>
            <td>{{ $siswa->nis }}</td>
            <td>{{ $siswa->nama_siswa }}</td>
            <td>{{ $siswa->kelas }}</td>
            <td>
                <span class="badge {{ $siswa->jenis_kelamin == 'L' ? 'bg-primary' : 'bg-pink' }}">
                    {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </span>
            </td>
            <td>{{ $siswa->email }}</td>
            <td>{{ $siswa->alamat ?? '-' }}</td>
            <td class="text-end">
                <x-tombol-aksi href="{{ route('data-siswa.show', $siswa->id) }}" type="show" />
                <x-tombol-aksi href="{{ route('data-siswa.edit', $siswa->id) }}" type="edit" />
                <x-tombol-aksi href="{{ route('data-siswa.destroy', $siswa->id) }}" type="delete" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">
                <div class="alert alert-danger mb-0">
                    Data siswa belum tersedia.
                </div>
            </td>
        </tr>
    @endforelse
</x-table-list>


<!-- Bulk Delete Form -->
<form id="bulkDeleteForm" method="POST" action="{{ route('data-siswa.bulk-delete') }}" style="display: none;">
    @csrf
    <div id="selectedIds"></div>
</form>

<script>
function selectAll() {
    const checkboxes = document.querySelectorAll('.student-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = true);
    updateBulkDeleteBtn();
}

function deselectAll() {
    const checkboxes = document.querySelectorAll('.student-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = false);
    document.getElementById('selectAllCheckbox').checked = false;
    updateBulkDeleteBtn();
}

function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.student-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateBulkDeleteBtn();
}

function updateBulkDeleteBtn() {
    const checkboxes = document.querySelectorAll('.student-checkbox:checked');
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
    const allCheckboxes = document.querySelectorAll('.student-checkbox');
    if (checkboxes.length === allCheckboxes.length) {
        selectAllCheckbox.checked = true;
    } else if (checkboxes.length === 0) {
        selectAllCheckbox.checked = false;
    } else {
        selectAllCheckbox.indeterminate = true;
    }
}

function bulkDelete() {
    const checkboxes = document.querySelectorAll('.student-checkbox:checked');
    if (checkboxes.length === 0) {
        alert('Pilih minimal satu data untuk dihapus');
        return;
    }
    
    if (confirm(`Apakah Anda yakin ingin menghapus ${checkboxes.length} data siswa?`)) {
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

<style>
.bg-pink {
    background-color: #e91e63 !important;
    color: white !important;
}
</style>
