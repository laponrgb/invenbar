<x-main-layout :title-page="__('Tambah Data Siswa')">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-person-plus"></i> Tambah Data Siswa
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('data-siswa.store') }}" method="POST">
                @csrf
                @include('data-siswa.partials.form')
            </form>
        </div>
    </div>
</x-main-layout>
