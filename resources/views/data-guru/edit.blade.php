<x-main-layout :title-page="__('Edit Data Guru')">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-person-gear"></i> Edit Data Guru
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('data-guru.update', $dataGuru->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('data-guru.partials.form', ['update' => true])
            </form>
        </div>
    </div>
</x-main-layout>
