<!-- resources/views/user/profile/partials/update-password-form.blade.php -->
<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-stone-900">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-stone-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="current_password" class="block text-sm font-medium text-stone-700 mb-1">
                {{ __('Current Password') }}
            </label>
            <input 
                id="current_password" 
                name="current_password" 
                type="password" 
                required 
                autocomplete="current-password"
                class="w-full px-4 py-2.5 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-stone-900 transition-colors"
            >
            @error('current_password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-stone-700 mb-1">
                {{ __('New Password') }}
            </label>
            <input 
                id="password" 
                name="password" 
                type="password" 
                required 
                autocomplete="new-password"
                class="w-full px-4 py-2.5 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-stone-900 transition-colors"
            >
            @error('password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-stone-700 mb-1">
                {{ __('Confirm Password') }}
            </label>
            <input 
                id="password_confirmation" 
                name="password_confirmation" 
                type="password" 
                required 
                autocomplete="new-password"
                class="w-full px-4 py-2.5 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-stone-900 transition-colors"
            >
            @error('password_confirmation', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-4">
            <button 
                type="submit" 
                class="px-6 py-2.5 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 hover:shadow-lg transition-all duration-200"
            >
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium"
                >
                    ✅ {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>