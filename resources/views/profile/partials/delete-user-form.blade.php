<section>
    <header>
        <h2 class="h5">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button data-bs-toggle="modal"
        data-bs-target="#confirm-user-deletion">{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="h5">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-muted">
                <small>
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </small>
            </p>

            <div class="mt-3">
                <x-input-label for="password" value="{{ __('Password') }}" />

                <x-text-input id="password" name="password" type="password" :class="$errors->userDeletion->get('password') ? 'is-invalid' : ''"
                    placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-3 text-end">
                <x-secondary-button data-bs-dismiss="modal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
