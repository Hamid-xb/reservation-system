<!-- resources/views/auth/forgot-password.blade.php -->
<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-stone-900">Wachtwoord vergeten</h2>
        <p class="text-sm text-stone-500 mt-3">
            Geen probleem! Laat ons je e-mailadres weten en we sturen je een link om je wachtwoord te resetten.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 font-medium">
            ✅ {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-stone-700 mb-1">
                E-mailadres
            </label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="jouw@email.nl"
                class="w-full px-4 py-2.5 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-stone-900 placeholder-stone-400 transition-colors"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-stone-500 hover:text-red-600 transition-colors" href="{{ route('login') }}">
                ← Terug naar inloggen
            </a>

            <button type="submit" class="px-6 py-2.5 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 hover:shadow-lg transition-all duration-200">
                Verstuur reset link
            </button>
        </div>
    </form>
</x-guest-layout>