<x-main-layout :title-page="__('Data Guru')">
    <div class="card">
        <div class="card-body">
            @include('data-guru.partials.toolbar')
            <x-notif-alert class="mt-4" />
            
            @if(session('import_errors'))
                <div class="alert alert-warning">
                    <h6><i class="bi bi-exclamation-triangle"></i> Error pada import:</h6>
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
            @endif
        </div>

        @include('data-guru.partials.list-guru')

        <div class="card-body">
            {{ $dataGuru->links() }}
        </div>
    </div>
</x-main-layout>
