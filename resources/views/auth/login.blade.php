<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-stone-900">Welkom terug</h2>
        <p class="text-sm text-stone-500 mt-1">Log in op je Tafello account</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
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

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-stone-700 mb-1">
                Wachtwoord
            </label>
            <input 
                id="password" 
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="Jouw wachtwoord"
                class="w-full px-4 py-2.5 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-stone-900 placeholder-stone-400 transition-colors"
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mt-4 flex items-center">
            <input 
                id="remember_me" 
                type="checkbox" 
                name="remember"
                class="rounded border-amber-300 text-red-600 focus:ring-red-500"
            >
            <label for="remember_me" class="ml-2 text-sm text-stone-600">
                Onthoud mij
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            <div class="flex flex-col gap-2">
                <a class="text-sm text-red-600 hover:text-red-700 font-medium transition-colors" href="{{ route('register') }}">
                    Nog geen account?
                </a>
                <a class="text-sm text-stone-500 hover:text-red-600 transition-colors" href="{{ route('password.request') }}">
                    Wachtwoord vergeten?
                </a>
            </div>

            <button type="submit" class="px-6 py-2.5 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 hover:shadow-lg transition-all duration-200">
                Inloggen
            </button>
        </div>
    </form>
</x-guest-layout>