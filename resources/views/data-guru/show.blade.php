<x-main-layout :title-page="__('Detail Data Guru')">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-person-lines-fill"></i> Detail Data Guru
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>NIP:</strong></td>
                            <td>{{ $dataGuru->nip }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Guru:</strong></td>
                            <td>{{ $dataGuru->nama_guru }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $dataGuru->email }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Alamat:</strong></td>
                            <td>{{ $dataGuru->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ $dataGuru->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diperbarui:</strong></td>
                            <td>{{ $dataGuru->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                <x-tombol-aksi href="{{ route('data-guru.edit', $dataGuru->id) }}" type="edit" />
                <x-tombol-kembali :href="route('data-guru.index')" />
            </div>
        </div>
    </div>
</x-main-layout>
