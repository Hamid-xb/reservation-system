<!-- resources/views/auth/register.blade.php -->
<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-stone-900">Account aanmaken</h2>
        <p class="text-sm text-stone-500 mt-1">Word lid van Tafello en reserveer jouw tafel</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-stone-700 mb-1">
                Naam
            </label>
            <input 
                id="name" 
                type="text" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Jouw naam"
                class="w-full px-4 py-2.5 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-stone-900 placeholder-stone-400 transition-colors"
            >
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block text-sm font-medium text-stone-700 mb-1">
                E-mailadres
            </label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
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
                autocomplete="new-password"
                placeholder="Minimaal 8 tekens"
                class="w-full px-4 py-2.5 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-stone-900 placeholder-stone-400 transition-colors"
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block text-sm font-medium text-stone-700 mb-1">
                Bevestig wachtwoord
            </label>
            <input 
                id="password_confirmation" 
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="Herhaal wachtwoord"
                class="w-full px-4 py-2.5 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-stone-900 placeholder-stone-400 transition-colors"
            >
            @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-red-600 hover:text-red-700 font-medium transition-colors" href="{{ route('login') }}">
                Al een account?
            </a>

            <button type="submit" class="px-6 py-2.5 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 hover:shadow-lg transition-all duration-200">
                Registreren
            </button>
        </div>
    </form>
</x-guest-layout>