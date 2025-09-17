<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" :class="$errors->get('name') ? 'is-invalid' : ''" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Email Address -->
        <div class="mt-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" :class="$errors->get('email') ? 'is-invalid' : ''" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="mt-3">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" type="password" name="password" :class="$errors->get('password') ? 'is-invalid' : ''" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-3">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" type="password" name="password_confirmation" :class="$errors->get('password_confirmation') ? 'is-invalid' : ''"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="text-end mt-3">
            <a class="text-secondary" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
