<section>
    <header>
        <h2 class="h5">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" :class="$errors->updatePassword->get('current_password') ? 'is-invalid' : ''"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div class="mt-3">
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" :class="$errors->updatePassword->get('password') ? 'is-invalid' : ''"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" />
        </div>

        <div class="mt-3">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                :class="$errors->updatePassword->get('password_confirmation') ? 'is-invalid' : ''" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="d-flex align-items-center gap-2 mt-3">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-muted p-0 m-0">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
