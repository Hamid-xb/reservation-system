@props([
    'active' => 'dashboard',
    'restaurant' => null,
])

@php
    $user = auth()->user();
@endphp

<aside class="fixed left-0 top-0 flex h-screen w-[280px] flex-col overflow-y-auto bg-gradient-to-b from-[#1a1410] to-[#2c2418] text-[#ddd2c9] shadow-xl">
    <div class="border-b border-[#3a2f28] px-6 py-8">
        <div class="bg-gradient-to-r from-[#f7bc7a] to-[#e67e22] bg-clip-text text-2xl font-extrabold text-transparent">
            🍽️ EetGemak
        </div>

        <small class="mt-1 block text-sm text-[#9c8674]">
            Restaurant Dashboard
        </small>
    </div>

    <nav class="flex-1 py-6">

        <a
            href="{{ $restaurant ? route('restaurant.dashboard', $restaurant) : '#' }}"
            class="mx-3 mb-2 flex items-center gap-3 rounded-2xl px-6 py-3 font-medium transition
            {{ $active === 'dashboard'
                ? 'bg-[#c53a1f] text-white shadow-md'
                : 'text-[#cfc2b8] hover:bg-[#c53a1f] hover:text-white'
            }}"
        >
            <span class="text-lg">📊</span>
            <span>Dashboard</span>
        </a>
        @php
            $user = auth()->user();
        @endphp

        @if($restaurant && $user->hasRestaurantRole($restaurant->id, [
            'restaurant_owner',
            'restaurant_manager',
            'restaurant_staff'
        ]))
            <a
                href="{{ $restaurant ? route('restaurant.reservations.index', $restaurant) : '#' }}"
                class="mx-3 mb-2 flex items-center gap-3 rounded-2xl px-6 py-3 font-medium transition
                {{ $active === 'reservations'
                    ? 'bg-[#c53a1f] text-white shadow-md'
                    : 'text-[#cfc2b8] hover:bg-[#c53a1f] hover:text-white'
                }}"
            >
                <span class="text-lg">📅</span>
                <span>Reserveringen</span>
            </a>
        @endif

        @if($restaurant && $user->hasRestaurantRole($restaurant->id, [
        'restaurant_owner',
        'restaurant_manager',
        ]))
            <a
                href="#"
                class="mx-3 mb-2 flex items-center gap-3 rounded-2xl px-6 py-3 font-medium transition
                {{ $active === 'photos'
                    ? 'bg-[#c53a1f] text-white shadow-md'
                    : 'text-[#cfc2b8] hover:bg-[#c53a1f] hover:text-white'
                }}"
            >
                <span class="text-lg">📸</span>
                <span>Foto's</span>
            </a>
        @endif

        @if($restaurant && $user->hasRestaurantRole($restaurant->id, [
        'restaurant_owner',
        'restaurant_manager',
        'restaurant_staff'
        ]))
            <a
                href="{{ $restaurant ? route('restaurant.tables.index', $restaurant) : '#' }}"
                class="mx-3 mb-2 flex items-center gap-3 rounded-2xl px-6 py-3 font-medium transition
                {{ $active === 'tables'
                    ? 'bg-[#c53a1f] text-white shadow-md'
                    : 'text-[#cfc2b8] hover:bg-[#c53a1f] hover:text-white'
                }}"
            >
                <span class="text-lg">🪑</span>
                <span>Tafels</span>
            </a>
        @endif

        @if($restaurant && auth()->user()->hasRestaurantRole($restaurant->id, [
        'restaurant_owner',
        'restaurant_manager',
         ]))
            <a
                href="{{ route('restaurant.members.index', $restaurant) }}"
                class="mx-3 mb-2 flex items-center gap-3 rounded-2xl px-6 py-3 font-medium transition
                {{ $active === 'members'
                ? 'bg-[#c53a1f] text-white shadow-md'
                : 'text-[#cfc2b8] hover:bg-[#c53a1f] hover:text-white'
        }}"
            >
                <span class="text-lg">👥</span>
                <span>Leden</span>
            </a>
        @endif
    </nav>



    <div class="border-t border-[#3a2f28] p-6">
        <a
            href="/"
            class="mb-3 flex items-center gap-3 rounded-2xl bg-[#c53a1f] px-4 py-3 font-medium text-white transition hover:opacity-90"
        >
            <span>🏠</span>
            <span>Mijn Restaurant</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-3 rounded-2xl bg-[#3a2f28] px-4 py-3 font-medium text-[#cfc2b8] transition hover:opacity-90"
            >
                <span>🚪</span>
                <span>Uitloggen</span>
            </button>
        </form>
    </div>
</aside>
