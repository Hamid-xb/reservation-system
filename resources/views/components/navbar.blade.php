<nav x-data="{ open: false, userMenuOpen: false, submenuOpen: false }" class="bg-[#f8f4ef] backdrop-blur-md border-b border-[#f5d7c4] sticky top-0 z-50">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <x-application-logo />
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex md:items-center md:space-x-6">
                <a href="{{ route('home') }}" class="text-stone-700 hover:text-red-600 font-semibold transition-colors">
                    Home
                </a>

                @auth
                    <!-- User Menu Dropdown -->
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 bg-white border border-amber-200 py-1.5 pl-1.5 pr-4 rounded-full hover:border-red-500 hover:bg-red-50 transition-all shadow-sm">
                            <span class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->firstname ?? Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->lastname ?? '', 0, 1)) }}
                            </span>
                            <span class="font-semibold text-stone-800">{{ Auth::user()->firstname ?? explode(' ', Auth::user()->name)[0] }}</span>
                            <svg class="w-3 h-3 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="userMenuOpen"
                             @click.away="userMenuOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-xl border border-amber-100 py-2 z-50">

                            <!-- User Info -->
                            <div class="px-6 py-4 border-b border-amber-50">
                                <p class="font-bold text-stone-900">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-stone-500 mt-1">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="#" class="flex items-center gap-3 px-6 py-3 text-stone-700 hover:bg-orange-50 hover:text-red-600 transition-all group">
                                <span>📋</span>
                                <span>Mijn Reserveringen</span>
                            </a>

                            <!-- My Restaurants Submenu -->
                            <div class="relative" x-data="{ submenuOpen: false }" @mouseenter="submenuOpen = true" @mouseleave="submenuOpen = false">
                                <a href="#" class="flex items-center justify-between px-6 py-3 text-stone-700 hover:bg-orange-50 hover:text-red-600 transition-all">
                                    <span class="flex items-center gap-3">
                                        <span>🏠</span>
                                        <span>Mijn Restaurants</span>
                                    </span>
                                    <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </a>

                                <!-- Submenu -->
                                <div x-show="submenuOpen"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 -translate-x-4"
                                     x-transition:enter-end="opacity-100 translate-x-0"
                                     class="absolute right-full top-0 mr-1 w-64 bg-white rounded-xl shadow-lg border border-amber-100 py-2">

                                    @php
                                        $userRestaurants = auth()->user()
                                            ->userRoles()
                                            ->with('restaurant')
                                            ->whereNotNull('restaurant_id')
                                            ->get()
                                            ->pluck('restaurant')
                                            ->filter()
                                            ->unique('id');
                                    @endphp

                                    @forelse($userRestaurants as $restaurant)
                                        <div class="flex items-center transition-colors hover:bg-orange-50 group">
                                            <a
                                                href="{{ route('restaurant.dashboard', $restaurant) }}"
                                                class="flex-grow px-6 py-2.5 text-sm text-stone-700 transition-colors hover:text-red-600"
                                            >
                                                📍 {{ $restaurant->name }}
                                            </a>

                                            <div class="h-6 w-px bg-amber-200"></div>

                                            <a
                                                href="{{ route('restaurant.settings.edit', $restaurant) }}"
                                                class="px-4 py-2.5 text-lg opacity-40 transition-all duration-300 hover:rotate-90 hover:opacity-100"
                                                title="Dashboard"
                                            >
                                                ⚙️
                                            </a>
                                        </div>
                                    @empty
                                        <div class="px-6 py-3 text-sm text-stone-500">
                                            Geen restaurants gevonden.
                                        </div>
                                    @endforelse

                                    <div class="border-t border-amber-100 mt-2 pt-2">
                                        <a href="#"
                                           class="block px-6 py-2.5 text-red-600 font-semibold hover:bg-orange-50 text-sm">
                                            + Restaurant toevoegen
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <a href="#" class="flex items-center gap-3 px-6 py-3 text-stone-700 hover:bg-orange-50 hover:text-red-600 transition-all">
                                <span>⚙️</span>
                                <span>Profielinstellingen</span>
                            </a>

                            <div class="border-t border-amber-100 my-2"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 w-full px-6 py-3 text-red-500 hover:bg-red-50 hover:text-red-700 transition-all font-medium">
                                    <span>🚪</span>
                                    <span>Uitloggen</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 border-2 border-red-600 text-red-600 rounded-full font-semibold hover:bg-red-50 transition-all">
                        Inloggen
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        Registreren
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="open = !open" class="text-stone-700 hover:text-red-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden pb-4">
            <div class="flex flex-col space-y-2">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg text-stone-700 hover:bg-orange-50 font-semibold">
                    Home
                </a>

                @auth
                    <a href="#" class="px-3 py-2 rounded-lg text-stone-700 hover:bg-orange-50">
                        📋 Mijn Reserveringen
                    </a>
                    <a href="#" class="px-3 py-2 rounded-lg text-stone-700 hover:bg-orange-50">
                        ⚙️ Profielinstellingen
                    </a>

                    <form method="POST" action="#" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full px-3 py-2 text-left rounded-lg text-red-500 hover:bg-red-50 font-medium">
                            🚪 Uitloggen
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 font-semibold">
                        Inloggen
                    </a>
                    <a href="{{ route('register') }}" class="px-3 py-2 rounded-lg bg-red-600 text-white font-semibold text-center hover:bg-red-700">
                        Registreren
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
