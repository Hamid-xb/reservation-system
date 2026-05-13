<!-- resources/views/reservations/create.blade.php -->
@extends('layouts.app')

@section('title', 'Reservering maken')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Back Button -->
    <a href="{{ route('restaurants.show', $restaurant) }}" class="inline-flex items-center text-stone-600 hover:text-red-600 mb-6 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Terug naar {{ $restaurant->name }}
    </a>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl shadow-lg border border-amber-100 overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 px-8 py-6 border-b border-amber-100">
            <h1 class="text-3xl font-extrabold text-stone-900">
                Reservering maken
            </h1>
            <div class="flex items-center gap-2 mt-2 text-stone-600">
                <span>🍽️</span>
                <span class="font-medium">{{ $restaurant->name }}</span>
                <span class="text-stone-400">•</span>
                <span>📍 {{ $restaurant->location }}</span>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('reservations.store', $restaurant) }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-semibold text-stone-700 mb-2">
                        📅 Datum
                    </label>
                    <input 
                        type="date" 
                        id="date" 
                        name="date" 
                        min="{{ date('Y-m-d') }}"
                        value="{{ old('date') }}"
                        class="w-full px-4 py-3 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('date') border-red-500 @enderror"
                        required
                    >
                    @error('date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time -->
                <div>
                    <label for="time" class="block text-sm font-semibold text-stone-700 mb-2">
                        ⏰ Tijd
                    </label>
                    <select 
                        id="time" 
                        name="time" 
                        class="w-full px-4 py-3 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('time') border-red-500 @enderror"
                        required
                    >
                        <option value="">Selecteer tijd</option>
                        @php
                            $times = [];
                            for ($h = 17; $h <= 22; $h++) {
                                $times[] = sprintf('%02d:00', $h);
                                $times[] = sprintf('%02d:30', $h);
                            }
                        @endphp
                        @foreach($times as $time)
                            <option value="{{ $time }}" {{ old('time') == $time ? 'selected' : '' }}>
                                {{ $time }}
                            </option>
                        @endforeach
                    </select>
                    @error('time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Number of Guests -->
                <div>
                    <label for="guests" class="block text-sm font-semibold text-stone-700 mb-2">
                        👥 Aantal personen
                    </label>
                    <select 
                        id="guests" 
                        name="guests" 
                        class="w-full px-4 py-3 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('guests') border-red-500 @enderror"
                        required
                    >
                        <option value="">Selecteer aantal</option>
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ old('guests') == $i ? 'selected' : '' }}>
                                {{ $i }} {{ $i === 1 ? 'persoon' : 'personen' }}
                            </option>
                        @endfor
                        <option value="11" {{ old('guests') == 11 ? 'selected' : '' }}>Meer dan 6 personen</option>
                    </select>
                    @error('guests')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-stone-700 mb-2">
                        � Telefoonnummer
                    </label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="Bijv. 0612345678"
                        class="w-full px-4 py-3 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('phone') border-red-500 @enderror"
                        required
                    >
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Special Requests -->
                <div class="md:col-span-2">
                    <label for="special_requests" class="block text-sm font-semibold text-stone-700 mb-2">
                        💬 Speciale verzoeken (optioneel)
                    </label>
                    <textarea 
                        id="special_requests" 
                        name="special_requests" 
                        rows="3"
                        placeholder="Bijv. allergieën, dieetwensen, speciale gelegenheid..."
                        class="w-full px-4 py-3 border border-amber-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                    >{{ old('special_requests') }}</textarea>
                    @error('special_requests')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                <button type="submit" class="flex-1 bg-red-600 text-white px-8 py-4 rounded-full font-semibold hover:bg-red-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                    ✅ Reservering bevestigen
                </button>
                <a href="{{ route('restaurants.show', $restaurant) }}" class="flex-1 text-center border-2 border-stone-300 text-stone-700 px-8 py-4 rounded-full font-semibold hover:border-red-300 hover:text-red-600 transition-all duration-200">
                    Annuleren
                </a>
            </div>
        </form>
    </div>
</div>
@endsection