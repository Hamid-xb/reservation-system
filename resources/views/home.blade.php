@extends('layouts.app')
@section('title', 'Home - Tafello')
@section('content')
    
    <section id="banner">
        <x-card class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center rounded-[50px]">
            <div class="text-6xl mb-6">🍽️</div>
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6">
                <span class="bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent">
                    Welkom bij Tafello!
                </span>
            </h1>
            <p class="text-lg md:text-xl text-stone-600 mb-8 leading-relaxed">
                Maak moeiteloos een tafelreservering bij jouw favoriete restaurant. 
                Geniet van een naadloze ervaring en reserveer vandaag nog!
            </p>
        </x-card> 
    </section>

    <section id="search" class="mt-12">
        <div class="bg-white rounded-full p-2 pl-6 flex flex-col md:flex-row items-center gap-3 shadow-lg border border-amber-200">
            
            <!-- Restaurant Name Search -->
            <div class="flex items-center w-full md:flex-1">
                <span class="text-stone-400 mr-2">🔍</span>
                <input 
                    type="text" 
                    placeholder="Restaurant naam..." 
                    class="w-full py-3 px-2 bg-transparent border-none focus:ring-0 text-stone-700 placeholder-stone-400 text-sm"
                >
            </div>

            <!-- Location Input -->
            <div class="flex items-center w-full md:flex-1 border-t md:border-t-0 md:border-l border-amber-200 md:pl-4">
                <span class="text-stone-400 mr-2">📍</span>
                <input 
                    type="text" 
                    placeholder="Locatie (stad)..." 
                    class="w-full py-3 px-2 bg-transparent border-none focus:ring-0 text-stone-700 placeholder-stone-400 text-sm"
                >
            </div>

            <!-- Cuisine Type Select -->
            <div class="flex items-center w-full md:flex-1 border-t md:border-t-0 md:border-l border-amber-200 md:pl-4">
                <span class="text-stone-400 mr-2">🍴</span>
                <select class="w-full py-3 px-2 bg-transparent border-none focus:ring-0 text-stone-700 cursor-pointer text-sm">
                    <option value="">Alle keukens</option>
                    <option value="Frans">Frans</option>
                    <option value="Aziatisch">Aziatisch</option>
                    <option value="Nederlands">Nederlands</option>
                    <option value="Italiaans">Italiaans</option>
                    <option value="Mediterraans">Mediterraans</option>
                    <option value="Fusion">Fusion</option>
                </select>
            </div>

            <!-- Search Button -->
            <button class="w-full md:w-auto bg-red-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-red-700 transition-colors text-sm">
                Zoeken
            </button>
        </div>
    </section>

    <section id="restaurants">
        <h2 class="text-3xl font-bold mt-6 mb-4 text-center">Populaire Restaurants</h2>
        <h5 class="text-lg text-stone-600 mb-8 text-center">Ontdek de beste restaurants in jouw stad</h5>

        <div>
            <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-amber-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
        
                @foreach($restaurants as $restaurant)
                    @php
                        $name = $restaurant['name'] ?? 'Onbekend Restaurant';
                        $description = $restaurant['description'] ?? null;
                        $location = $restaurant['location'] ?? null;
                        $cuisine = $restaurant['cuisine'] ?? null;
                        $image = $restaurant['image'] ?? null;
                    @endphp
                    <!-- Image -->
                    <div class="h-48 bg-gradient-to-br from-amber-200 to-orange-200 relative flex items-center justify-center">
                        @if($restaurant->image)
                            <img src="{{ $restaurant->image }}" alt="{{ $restaurant->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl opacity-30">🍽️</span>
                        @endif
                        
                        <!-- Cuisine Tag -->
                        @if($restaurant->cuisine)
                            <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-red-600 uppercase tracking-wide">
                                {{ $restaurant->cuisine }} keuken
                            </span>
                        @endif
                    </div> 

                    <!-- Content -->
                    <div class="p-6">
                        <!-- Title -->
                        <h3 class="text-xl font-bold text-stone-900 mb-2">{{ $name }}</h3>
                        
                        <!-- Location -->
                        @if($restaurant->location)
                            <p class="text-stone-500 text-sm mb-3">📍 {{ $restaurant->location }}</p>
                        @endif
                        
                        <!-- Description -->
                        @if($restaurant->description)
                            <p class="text-stone-600 text-sm mb-4 leading-relaxed">{{ $restaurant->description }}</p>
                        @endif
                        
                        <!-- Button -->
                        <button class="w-full bg-red-600 text-white py-2.5 rounded-full font-semibold hover:bg-red-700 transition-colors">
                            Reserveer nu
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </section>    
@endsection