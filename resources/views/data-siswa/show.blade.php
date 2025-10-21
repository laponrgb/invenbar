<x-main-layout :title-page="__('Detail Data Siswa')">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-person-lines-fill"></i> Detail Data Siswa
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>NIS:</strong></td>
                            <td>{{ $dataSiswa->nis }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Siswa:</strong></td>
                            <td>{{ $dataSiswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kelas:</strong></td>
                            <td>{{ $dataSiswa->kelas }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin:</strong></td>
                            <td>{{ $dataSiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $dataSiswa->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat:</strong></td>
                            <td>{{ $dataSiswa->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ $dataSiswa->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diperbarui:</strong></td>
                            <td>{{ $dataSiswa->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                <x-tombol-aksi href="{{ route('data-siswa.edit', $dataSiswa->id) }}" type="edit" />
                <x-tombol-kembali :href="route('data-siswa.index')" />
            </div>
        </div>
    </div>
</x-main-layout>
