<div class="row">
    <div class="col">
        @can('manage sumberdana')
            <x-tombol-tambah label="Tambah Sumber Dana" href="{{ route('sumberdana.create') }}" />
        @endcan
    </div>
    <div class="col">
        <x-form-search placeholder="Cari nama sumberdana..." />
    </div>
</div>
