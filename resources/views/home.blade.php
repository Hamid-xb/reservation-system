<x-app-layout
    title="Home - Tafello">
    <section id="search" class="mt-5">
        <form action="{{ route('search') }}" method="GET">
            <div class="bg-white rounded-full p-2 pl-6 flex flex-col md:flex-row items-center gap-3 shadow-lg border border-amber-200">

                <!-- Restaurant Name Search -->
                <div class="flex items-center w-full md:flex-1">
                    <span class="text-stone-400 mr-2">🔍</span>
                    <input
                        type="text"
                        name="name"
                        placeholder="Restaurant naam..."
                        value="{{ $search ?? '' }}"
                        class="w-full py-3 px-2 bg-transparent border-none focus:ring-0 text-stone-700 placeholder-stone-400 text-sm"
                    >
                </div>

                <!-- Location Input -->
                <div class="flex items-center w-full md:flex-1 border-t md:border-t-0 md:border-l border-amber-200 md:pl-4">
                    <span class="text-stone-400 mr-2">📍</span>
                    <input
                        name="location"
                        placeholder="Locatie (stad)..."
                        value="{{ $location ?? '' }}"
                        class="w-full py-3 px-2 bg-transparent border-none focus:ring-0 text-stone-700 placeholder-stone-400 text-sm"
                    >
                </div>

                <!-- Cuisine Type Select -->
                <div class="flex items-center w-full md:flex-1 border-t md:border-t-0 md:border-l border-amber-200 md:pl-4">
                    <span class="text-stone-400 mr-2">🍴</span>
                    <select name="cuisine" class="w-full py-3 px-2 bg-transparent border-none focus:ring-0 text-stone-700 cursor-pointer text-sm">
                        <option value="" {{ ($cuisine ?? '') == 'none' ? 'selected' : '' }}>
                            Alle keukens
                        </option>
                        <option value="Frans" {{ ($cuisine ?? '') == 'Frans' ? 'selected' : '' }}>
                            Frans
                        </option>

                        <option value="Aziatisch" {{ ($cuisine ?? '') == 'Aziatisch' ? 'selected' : '' }}>
                            Aziatisch
                        </option>

                        <option value="Nederlands" {{ ($cuisine ?? '') == 'Nederlands' ? 'selected' : '' }}>
                            Nederlands
                        </option>

                        <option value="Italiaans" {{ ($cuisine ?? '') == 'Italiaans' ? 'selected' : '' }}>
                            Italiaans
                        </option>

                        <option value="Mediterraans" {{ ($cuisine ?? '') == 'Mediterraans' ? 'selected' : '' }}>
                            Mediterraans
                        </option>

                        <option value="Fusion" {{ ($cuisine ?? '') == 'Fusion' ? 'selected' : '' }}>
                            Fusion
                        </option>
                    </select>
                </div>

                <!-- Search Button -->
                <button class="w-full md:w-auto bg-red-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-red-700 transition-colors text-sm">
                    Zoeken
                </button>
            </div>
        </form>
    </section>

    <section id="restaurants">
        @if(!empty($search))
            <h2 class="text-2xl font-semibold mt-6 mb-4 text-center">Zoekresultaten voor "{{ $search }}" @if(!empty($location)) in "{{ $location }}"@endif</h2>
        @else
        <h2 class="text-3xl font-bold mt-6 mb-4 text-center">Restaurants</h2>
        <h5 class="text-lg text-stone-600 mb-8 text-center">Ontdek de beste restaurants in jouw stad</h5>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($restaurants as $restaurant)
                <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-amber-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <!-- Image -->
                        <a href="{{ route('restaurants.show', $restaurant->id) }}" class="block">
                        <div class="h-48 bg-gradient-to-br from-amber-200 to-orange-200 relative flex items-center justify-center">
                            @if($restaurant->banner)
                                <img src="{{ asset($restaurant->banner->image_url) }}" alt="{{ $restaurant->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset("img/default-restaurant-banner.jpg") }}" alt="Default Restaurant Banner" class="w-full h-full object-cover">
                            @endif

                            <!-- Cuisine Tag -->
                            @if($restaurant->type)
                                <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-red-600 uppercase tracking-wide">
                                    {{ $restaurant->type }} keuken
                                </span>
                            @endif
                        </div>
                    </a>

                    <!-- Content -->
                    <div class="p-6">
                        <!-- Title -->
                        <h3 class="text-xl font-bold text-stone-900 mb-2">{{ $restaurant->name }}</h3>

                        <!-- Location -->
                        @if($restaurant->location)
                            <p class="text-stone-500 text-sm mb-3">📍 {{ $restaurant->location }}</p>
                        @endif

                        <!-- Description -->
                        @if($restaurant->description)
                            <p class="text-stone-600 text-sm mb-4 leading-relaxed">
                                {{ \Illuminate\Support\Str::limit($restaurant->description, 120) }}
                            </p>
                        @endif

                        <!-- Button -->
                        <div class="mt-4">
                        <a href="{{ route('reservations.create', [
                            $restaurant->id,
                            'date' => now()->toDateString()
                        ]) }}">
                            <x-primary-button class="w-full">
                                Reserveer nu
                            </x-primary-button>
                        </a>
                    </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-app-layout>
