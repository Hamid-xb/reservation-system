<x-restaurant-layout
    :restaurant="$restaurant"
    active="reservations"
    header="Reserveringen"
    subheader="Beheer reserveringen van {{ $restaurant->name }}"
>
    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-100 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">
        <h2 class="mb-6 text-2xl font-bold text-[#2c1a12]">
            Alle reserveringen
        </h2>

        @if($reservations->isEmpty())
            <div class="py-12 text-center text-[#a48e7c]">
                📭 Geen reserveringen gevonden.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                    <tr class="border-b border-[#f0e2d8] text-left">
                        <th class="pb-4 font-semibold text-[#7e6959]">Naam</th>
                        <th class="pb-4 font-semibold text-[#7e6959]">Telefoon</th>
                        <th class="pb-4 font-semibold text-[#7e6959]">Datum</th>
                        <th class="pb-4 font-semibold text-[#7e6959]">Tijd</th>
                        <th class="pb-4 font-semibold text-[#7e6959]">Personen</th>
                        <th class="pb-4 font-semibold text-[#7e6959]">Status</th>
                        <th class="pb-4 font-semibold text-[#7e6959]">Acties</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($reservations as $reservation)
                        <tr class="border-b border-[#f7eee7]">
                            <td class="py-4 font-medium text-[#2c1a12]">
                                {{ $reservation->name }}
                            </td>

                            <td class="py-4 text-[#6f5b4b]">
                                {{ $reservation->phone_number }}
                            </td>

                            <td class="py-4 text-[#6f5b4b]">
                                {{ $reservation->start_datetime->format('d-m-Y') }}
                            </td>

                            <td class="py-4 text-[#6f5b4b]">
                                {{ $reservation->start_datetime->format('H:i') }}
                                -
                                {{ $reservation->end_datetime->format('H:i') }}
                            </td>

                            <td class="py-4 text-[#6f5b4b]">
                                {{ $reservation->number_of_people }}
                            </td>

                            <td class="py-4">
                                <form method="POST" action="{{ route('restaurant.reservations.update-status', [$restaurant, $reservation]) }}">
                                    @csrf
                                    @method('PATCH')


                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 mr-10 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                                    >
                                        <option value="pending" @selected($reservation->status === 'pending')>In afwachting</option>
                                        <option value="confirmed" @selected($reservation->status === 'confirmed')>Bevestigd</option>
                                        <option value="completed" @selected($reservation->status === 'completed')>Voltooid</option>
                                        <option value="cancelled" @selected($reservation->status === 'cancelled')>Geannuleerd</option>
                                        <option value="no_show" @selected($reservation->status === 'no_show')>Niet gekomen</option>
                                    </select>
                                </form>
                            </td>

                            <td class="py-4">
                                <div class="flex flex-wrap gap-2">

                                    {{-- Modify --}}
                                    <button
                                        type="button"
                                        class="rounded-full bg-[#e67e22] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#c96b18]"
                                    >
                                        Bewerken
                                    </button>

                                    {{-- Delete --}}
                                    <form
                                        method="POST"
                                        action="{{ route('restaurant.reservations.destroy', [$restaurant, $reservation]) }}"
                                        onsubmit="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-full bg-[#c53a1f] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#9f2f17]"
                                        >
                                            Verwijderen
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                        @if($reservation->reservation_note)
                            <tr class="border-b border-[#f7eee7] bg-[#fefaf5]">
                                <td colspan="7" class="px-4 py-3 text-sm text-[#7e6959]">
                                    <span class="font-semibold">Opmerking:</span>
                                    {{ $reservation->reservation_note }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-restaurant-layout>
