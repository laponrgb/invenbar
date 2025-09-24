<x-main-layout title-page="Edit User">
    <div class="row">
        <form class="card col-lg-6" action="{{ route('user.update', $user->id) }}" method="POST">
            <div class="card-body">
                @method('PUT')
                @include('user.partials.form', ['update' => true])
            </div>
        </form>
    </div>
</x-main-layout>
