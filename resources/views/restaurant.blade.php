<x-app-layout 
    title="{{ $restaurant->name }} - Tafello">
<div>

    <!-- Hero Image -->
    <div class="h-64 md:h-96 bg-gradient-to-br from-red-600 to-orange-500 rounded-3xl flex items-center justify-center text-white text-5xl md:text-7xl mb-8">
        @if($restaurant->banner)
            <img src="{{ asset($restaurant->banner->image_url) }}" alt="{{ $restaurant->name }}" class="w-full h-full object-cover rounded-3xl">
        @else
            <img src="{{ asset("img/default-restaurant-banner.jpg") }}" alt="{{ $restaurant->name }}" class="w-full h-full object-cover rounded-3xl">
        @endif
    </div>

    <!-- Restaurant Header -->
    <div class="mb-8">
        <div class="mb-4 flex justify-between">
            <h1 class="text-4xl md:text-5xl font-extrabold text-stone-900 mb-4">{{ $restaurant->name }}</h1>
            @if($canOpenDashboard)
                <a
                    href="{{ route('restaurant.dashboard', $restaurant) }}"
                    class="inline-flex items-center gap-2 rounded-full bg-stone-900 px-8 py-4 font-semibold text-white transition-all duration-200 hover:-translate-y-0.5 hover:bg-stone-800 hover:shadow-lg"
                >
                    Restaurant dashboard
                </a>
            @endif
        </div>
        <div class="flex flex-wrap gap-4 mb-6">
            <span class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-full text-sm font-medium text-stone-600 shadow-sm">
                ⭐ {{ $restaurant->restaurant_type }} keuken
            </span>
            <span class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-full text-sm font-medium text-stone-600 shadow-sm">
                📍 {{ $restaurant->information->address }}
            </span>
        </div>

        <!-- Reserve Button -->
        {{--<a href="{{ route('reservations.create', ['restaurant' => $restaurant->id]) }}"
           class="inline-flex items-center gap-2 bg-red-600 text-white px-8 py-4 rounded-full font-semibold hover:bg-red-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
            📅 Reserveer nu
        </a>--}}
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">

        <!-- Main Content (2 columns) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-amber-100">
                <h2 class="text-2xl font-bold text-stone-900 mb-6 pb-4 border-b-2 border-amber-100">
                    Over dit restaurant
                </h2>

                <div class="prose max-w-none text-stone-700 leading-relaxed space-y-4">
                    <p>{{ $restaurant->description }}</p>
                </div>
            </div>
        </div>

        <!-- Sidebar (1 column) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-amber-100 sticky top-24">
                <h3 class="text-xl font-bold text-stone-900 mb-6">📋 Informatie</h3>

                <div class="space-y-4">
                    <!-- Address -->
                    <div class="flex justify-between items-center py-3 border-b border-amber-100">
                        <span class="font-semibold text-stone-500">📍 Adres</span>
                        <span class="text-stone-900 font-medium text-right">{{ $restaurant->information->address ?? 'Onbekend' }}</span>
                    </div>

                    <!-- Phone -->
                    <div class="flex justify-between items-center py-3 border-b border-amber-100">
                        <span class="font-semibold text-stone-500">📞 Telefoon</span>
                        <span class="text-stone-900 font-medium">{{ $restaurant->information->phone_number ?? '020 123 4567' }}</span>
                    </div>

                    <!-- Cuisine -->
                    <div class="flex justify-between items-center py-3 border-b border-amber-100">
                        <span class="font-semibold text-stone-500">🍽️ Keuken</span>
                        <span class="text-stone-900 font-medium">{{ $restaurant->restaurant_type }}</span>
                    </div>

                    <!-- Opening Hours -->
                    <div class="flex flex-col items-center py-3 w-full">
                        <span class="font-semibold text-stone-500 text-center">⏰ Openingstijden</span>
                        <div class="text-stone-900 font-medium text-right space-y-1 w-full">
                            @php
                                $days = [
                                    0 => 'Maandag',
                                    1 => 'Dinsdag',
                                    2 => 'Woensdag',
                                    3 => 'Donderdag',
                                    4 => 'Vrijdag',
                                    5 => 'Zaterdag',
                                    6 => 'Zondag',
                                ];

                                $openingHours = $restaurant->openingHours->keyBy('day_of_week');
                            @endphp

                            @foreach($days as $dayNumber => $dayName)
                                <div class="flex justify-between mt-6">
                                    <span class="text-stone-500">{{ $dayName }}</span>
                                    @if(isset($openingHours[$dayNumber]))
                                        <span class="flex items-start">
                                            {{ \Carbon\Carbon::parse($openingHours[$dayNumber]->open_time)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($openingHours[$dayNumber]->close_time)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="text-red-500">Gesloten</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</x-app-layout>
