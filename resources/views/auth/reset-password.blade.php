<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" :class="$errors->get('email') ? 'is-invalid' : ''" required
                autofocus autocomplete="username" />
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
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
