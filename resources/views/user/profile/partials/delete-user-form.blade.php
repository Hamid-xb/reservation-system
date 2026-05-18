<!-- resources/views/user/profile/partials/delete-user-form.blade.php -->
<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-stone-900">
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-1 text-sm text-stone-500">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-2.5 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 transition-colors"
    >
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('user.profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-stone-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="{{ __('Password') }}"
                    class="w-full px-4 py-2.5 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500"
                >
                @error('password', 'userDeletion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <button
                    x-on:click="$dispatch('close')"
                    type="button"
                    class="px-6 py-2.5 border-2 border-red-600 text-red-600 rounded-full font-semibold hover:bg-red-50 transition-colors"
                >
                    {{ __('Cancel') }}
                </button>

                <button
                    type="submit"
                    class="px-6 py-2.5 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 transition-colors"
                >
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>