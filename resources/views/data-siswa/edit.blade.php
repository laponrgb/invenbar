<x-main-layout :title-page="__('Edit Data Siswa')">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-person-gear"></i> Edit Data Siswa
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('data-siswa.update', $dataSiswa->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('data-siswa.partials.form', ['update' => true])
            </form>
        </div>
    </div>
</x-main-layout>
