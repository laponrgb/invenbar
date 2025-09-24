@csrf
<div class="mb-3">
    <x-form-input label="Nama Lengkap" name="name" :value="$user->name" />
</div>
<div class="mb-3">
    <x-form-input label="Email" name="email" :value="$user->email" type="email" />
</div>
<div class="mb-3">
    <x-form-input label="Password" name="password" type="password" />
</div>
<div class="mb-3">
    <x-form-input label="Konfirmasi Password" name="password_confirmation" type="password" />
</div>
<div class="mt-4">
    <x-primary-button>
        {{ isset($update) ? 'Update' : 'Simpan' }}
    </x-primary-button>
    <x-tombol-kembali :href="route('user.index')" />
</div>
