<section>
    <header>
        <h2 class="h5">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" :class="$errors->get('name') ? 'is-invalid' : ''" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="mt-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" :class="$errors->get('email') ? 'is-invalid' : ''" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-muted mt-2 mb-0">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link text-secondary p-0">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success">
                            <strong>
                                {{ __('A new verification link has been sent to your email address.') }}
                            </strong>
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-2 mt-3">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-muted p-0 m-0">
                    {{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
