<x-main-layout :title-page="__('Import Data Guru')">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-upload"></i> Import Data Guru dari CSV
            </h5>
        </div>
        <div class="card-body">
            <x-notif-alert class="mb-4" />

            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('data-guru.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Pilih File CSV</label>
                            <input type="file" class="form-control @error('csv_file') is-invalid @enderror" 
                                   id="csv_file" name="csv_file" accept=".csv,.txt" required>
                            @error('csv_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-primary-button>
                                <i class="bi bi-upload"></i> Import Data
                            </x-primary-button>
                            <x-tombol-kembali :href="route('data-guru.index')" />
                        </div>
                    </form>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="bi bi-info-circle"></i> Format CSV
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>Urutan kolom:</strong></p>
                            <ol class="mb-3">
                                <li>NIP</li>
                                <li>Nama Guru</li>
                                <li>Email</li>
                                <li>Alamat (opsional)</li>
                            </ol>
                            
                            <p class="mb-2"><strong>Contoh data:</strong></p>
                            <code class="small">
                                196512011990031001,Dr. Ahmad Wijaya,ahmad@email.com,Jl. Guru No. 1<br>
                                197003151995122001,Dra. Siti Nurhaliza,siti@email.com,Jl. Guru No. 2
                            </code>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('import_errors'))
                <div class="mt-4">
                    <div class="alert alert-warning">
                        <h6><i class="bi bi-exclamation-triangle"></i> Error pada baris berikut:</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th width="10%">Baris</th>
                                        <th>Keterangan Error</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('import_errors') as $error)
                                        <tr>
                                            <td class="text-center">
                                                <span class="badge bg-danger">{{ explode(':', $error)[0] }}</span>
                                            </td>
                                            <td class="text-danger">{{ substr($error, strpos($error, ':') + 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-main-layout>
