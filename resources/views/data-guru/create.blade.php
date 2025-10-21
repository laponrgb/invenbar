<x-main-layout :title-page="__('Tambah Data Guru')">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-person-plus"></i> Tambah Data Guru
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('data-guru.store') }}" method="POST">
                @csrf
                @include('data-guru.partials.form')
            </form>
        </div>
    </div>
</x-main-layout>
