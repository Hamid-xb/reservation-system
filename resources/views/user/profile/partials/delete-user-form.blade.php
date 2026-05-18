<!-- resources/views/user/profile/partials/delete-user-form.blade.php -->
<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-stone-900">
            {{ __('Account Verwijderen') }}
        </h2>
        <p class="mt-1 text-sm text-stone-500">
            {{ __('Zodra uw account is verwijderd, worden alle bijbehorende gegevens en informatie permanent gewist. Download daarom alle gegevens en informatie die u wilt bewaren voordat u uw account verwijdert.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-2.5 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 transition-colors"
    >
        {{ __('Account Verwijderen') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('user.profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-stone-900">
                {{ __('Weet u zeker dat u uw account wilt verwijderen?') }}
            </h2>

            <p class="mt-1 text-sm text-stone-500">
                {{ __('Zodra uw account is verwijderd, worden alle bijbehorende gegevens en informatie permanent gewist. Download daarom alle gegevens en informatie die u wilt bewaren voordat u uw account verwijdert.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Wachtwoord') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="{{ __('Wachtwoord') }}"
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
                    {{ __('Annuleren') }}
                </button>

                <button
                    type="submit"
                    class="px-6 py-2.5 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 transition-colors"
                >
                    {{ __('Account Verwijderen') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>