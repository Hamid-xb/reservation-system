<!-- resources/views/user/profile/partials/update-profile-information-form.blade.php -->
<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-stone-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-stone-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('user.profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-stone-700 mb-1">
                {{ __('Name') }}
            </label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name"
                class="w-full px-4 py-2.5 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-stone-900 placeholder-stone-400 transition-colors"
            >
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-stone-700 mb-1">
                {{ __('Email') }}
            </label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                value="{{ old('email', $user->email) }}" 
                required 
                autocomplete="username"
                class="w-full px-4 py-2.5 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-stone-900 placeholder-stone-400 transition-colors"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-4 bg-amber-50 rounded-xl border border-amber-200">
                    <p class="text-sm text-stone-700">
                        {{ __('Your email address is unverified.') }}
                    </p>
                    <button 
                        form="send-verification" 
                        class="mt-2 text-sm font-medium text-red-600 hover:text-red-700 underline transition-colors"
                    >
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600">
                            ✅ {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4">
            <button 
                type="submit" 
                class="px-6 py-2.5 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 hover:shadow-lg transition-all duration-200"
            >
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
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