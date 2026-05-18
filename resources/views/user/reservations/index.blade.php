<x-app-layout title="Mijn Reserveringen - Tafello">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-stone-900 mb-6">Mijn Reserveringen</h1>

            @if($reservations->isEmpty())
                <p class="text-stone-500">
                    Je hebt nog geen reserveringen gemaakt. 
                    <a href="{{ route('restaurants.index') }}" class="text-red-600 hover:underline">Bekijk restaurants</a> 
                    en reserveer jouw tafel!
                </p>
            @else
                <!-- Tabs -->
                <div x-data="{ activeTab: 'upcoming' }">
                    <div class="flex gap-2 mb-6">
                        <button 
                            @click="activeTab = 'upcoming'"
                            :class="activeTab === 'upcoming' ? 'bg-red-600 text-white' : 'bg-white text-stone-600 hover:bg-amber-50 border border-amber-200'"
                            class="px-6 py-2.5 rounded-full font-semibold transition-colors text-sm"
                        >
                            📅 Toekomstig
                        </button>
                        <button 
                            @click="activeTab = 'past'"
                            :class="activeTab === 'past' ? 'bg-red-600 text-white' : 'bg-white text-stone-600 hover:bg-amber-50 border border-amber-200'"
                            class="px-6 py-2.5 rounded-full font-semibold transition-colors text-sm"
                        >
                            🕒 Verleden
                        </button>
                    </div>

                    @php
                        $upcomingReservations = $reservations->filter(function($reservation) {
                            return $reservation->start_datetime->isFuture();
                        });
                        $pastReservations = $reservations->filter(function($reservation) {
                            return $reservation->start_datetime->isPast();
                        });
                    @endphp

                    <!-- Upcoming Tab -->
                    <div x-show="activeTab === 'upcoming'">
                        @if($upcomingReservations->isEmpty())
                            <div class="bg-white rounded-3xl shadow-sm border border-amber-100 p-8 text-center">
                                <div class="text-4xl mb-4">📅</div>
                                <p class="text-stone-500">Je hebt geen toekomstige reserveringen.</p>
                                <a href="{{ route('restaurants.index') }}" class="text-red-600 hover:underline text-sm mt-2 inline-block">
                                    Bekijk restaurants →
                                </a>
                            </div>
                        @else
                            <div class="bg-white rounded-3xl shadow-sm border border-amber-100 overflow-hidden">
                                <table class="min-w-full divide-y divide-amber-100">
                                    <thead class="bg-amber-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Restaurant</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Datum & Tijd</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-stone-500 uppercase tracking-wider">Acties</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-amber-100">
                                        @foreach($upcomingReservations as $reservation)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center gap-4">
                                                        <div class="w-12 h-12 bg-gradient-to-br from-amber-200 to-orange-200 rounded-full overflow-hidden flex-shrink-0">
                                                            @if($reservation->restaurant->banner)
                                                                <img src="{{ $reservation->restaurant->banner }}" alt="{{ $reservation->restaurant->name }}" class="w-full h-full object-cover">
                                                            @else
                                                                <img src="{{ asset('img/default-restaurant-banner.jpg') }}" alt="Default Restaurant Banner" class="w-full h-full object-cover">
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-stone-900">{{ $reservation->restaurant->name }}</p>
                                                            <p class="text-xs text-stone-500">{{ $reservation->restaurant->location }}</p>
                                                        </div>  
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <p class="text-sm text-stone-900">{{ $reservation->start_datetime->format('d M Y') }} om {{ $reservation->start_datetime->format('H:i') }}</p>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($reservation->status == 'confirmed')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Goedgekeurd</span>
                                                    @elseif($reservation->status == 'cancelled')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Geannuleerd</span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">In behandeling</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    @if($reservation->status == 'confirmed' || $reservation->status == 'pending')
                                                        <button 
                                                            x-data
                                                            @click="$dispatch('open-modal', 'confirm-reservation-deletion-{{ $reservation->id }}')"
                                                            class="px-4 py-2 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 transition-colors text-sm"
                                                        >
                                                            Annuleren
                                                        </button>

                                                        <x-modal name="confirm-reservation-deletion-{{ $reservation->id }}" focusable>
                                                            <form method="POST" action="{{ route('user.reservations.destroy', $reservation->id) }}" class="p-6">
                                                                @csrf
                                                                @method('DELETE')
                                                                
                                                                <div class="text-center">
                                                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                                                                        <span class="text-2xl">⚠️</span>
                                                                    </div>
                                                                    <h2 class="text-lg font-bold text-stone-900 mb-2">Reservering annuleren</h2>
                                                                    <p class="text-sm text-stone-500">Weet je zeker dat je deze reservering wilt annuleren?</p>
                                                                </div>

                                                                <div class="mt-6 flex justify-center gap-4">
                                                                    <button
                                                                        type="button"
                                                                        @click="$dispatch('close-modal', 'confirm-reservation-deletion-{{ $reservation->id }}')"
                                                                        class="px-6 py-2.5 border-2 border-stone-300 text-stone-700 rounded-full font-semibold hover:bg-stone-50 transition-colors"
                                                                    >
                                                                        Terug
                                                                    </button>
                                                                    <button
                                                                        type="submit"
                                                                        class="px-6 py-2.5 bg-red-600 text-white rounded-full font-semibold hover:bg-red-700 transition-colors"
                                                                    >
                                                                        Ja, annuleren
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </x-modal>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <!-- Past Tab -->
                    <div x-show="activeTab === 'past'">
                        @if($pastReservations->isEmpty())
                            <div class="bg-white rounded-3xl shadow-sm border border-amber-100 p-8 text-center">
                                <div class="text-4xl mb-4">🕒</div>
                                <p class="text-stone-500">Je hebt geen verleden reserveringen.</p>
                            </div>
                        @else
                            <div class="bg-white rounded-3xl shadow-sm border border-amber-100 overflow-hidden">
                                <table class="min-w-full divide-y divide-amber-100">
                                    <thead class="bg-amber-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Restaurant</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Datum & Tijd</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-amber-100">
                                        @foreach($pastReservations as $reservation)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center gap-4">
                                                        <div class="w-12 h-12 bg-gradient-to-br from-amber-200 to-orange-200 rounded-full overflow-hidden flex-shrink-0">
                                                            @if($reservation->restaurant->banner)
                                                                <img src="{{ $reservation->restaurant->banner }}" alt="{{ $reservation->restaurant->name }}" class="w-full h-full object-cover">
                                                            @else
                                                                <img src="{{ asset('img/default-restaurant-banner.jpg') }}" alt="Default Restaurant Banner" class="w-full h-full object-cover">
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-stone-900">{{ $reservation->restaurant->name }}</p>
                                                            <p class="text-xs text-stone-500">{{ $reservation->restaurant->location }}</p>
                                                        </div>  
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <p class="text-sm text-stone-900">{{ $reservation->start_datetime->format('d M Y') }} om {{ $reservation->start_datetime->format('H:i') }}</p>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($reservation->status == 'confirmed')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Goedgekeurd</span>
                                                    @elseif($reservation->status == 'cancelled')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Geannuleerd</span>
                                                    @elseif($reservation->status == 'no_show')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Niet aangekomen</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>