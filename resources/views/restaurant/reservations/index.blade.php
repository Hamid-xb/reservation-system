<x-restaurant-layout
    :restaurant="$restaurant"
    active="reservations"
    header="Reserveringen voor {{ $restaurant->name }}"
    subheader="Beheer reserveringen van {{ $restaurant->name }}"
>
    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-100 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @php
        $selectedDate = $selectedDate ?? request('date', now()->toDateString());
    @endphp

    <div class="rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">
        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <h2 class="text-2xl font-bold text-[#2c1a12]">
                Reserveringen voor {{ \Carbon\Carbon::parse($selectedDate)->format('d-m-Y') }}
            </h2>

            <form
                method="GET"
                action="{{ route('restaurant.reservations.index', $restaurant) }}"
                class="flex flex-col gap-3 sm:flex-row sm:items-end"
            >
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        Datum
                    </label>

                    <input
                        type="date"
                        name="date"
                        value="{{ $selectedDate }}"
                        onclick="this.showPicker && this.showPicker()"
                        onchange="this.form.submit()"
                        class="w-full cursor-pointer rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 text-[#3e2c23] focus:border-[#c53a1f] focus:ring-[#c53a1f] sm:w-56"
                    >
                </div>

                <a
                    href="{{ route('restaurant.reservations.index', ['restaurant' => $restaurant, 'date' => now()->toDateString()]) }}"
                    class="rounded-full bg-[#3e2c23] px-5 py-3 text-center font-semibold text-white transition hover:bg-[#2c1a12]"
                >
                    Vandaag
                </a>

                <a
                    href="{{ route('reservations.create', ['restaurant' => $restaurant, 'date' => $selectedDate, 'reservation_type' => 'staff_created']) }}"
                    class="rounded-full bg-[#c53a1f] px-5 py-3 text-center font-semibold text-white transition hover:bg-[#9f2f17]"
                >
                    + Nieuwe reservering
                </a>
            </form>
        </div>

        @if($reservations->isEmpty())
            <div class="py-12 text-center text-[#a48e7c]">
                Geen reserveringen gevonden.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                    <tr class="border-b border-[#f0e2d8] text-left">
                        <th class="pb-4 font-semibold text-[#7e6959]">Naam</th>
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
                                @if($reservation->status === 'confirmed')
                                    <span class="rounded-full bg-[#e6f4ea] px-3 py-1 text-sm font-medium text-[#2e7d32]">
                                        Bevestigd
                                    </span>
                                @elseif($reservation->status === 'cancelled')
                                    <span class="rounded-full bg-[#ffe8e3] px-3 py-1 text-sm font-medium text-[#c53a1f]">
                                        Geannuleerd
                                    </span>
                                @elseif($reservation->status === 'pending')
                                    <span class="rounded-full bg-[#fff4d6] px-3 py-1 text-sm font-medium text-[#9a6a00]">
                                        In afwachting
                                    </span>
                                @else
                                    <span class="rounded-full bg-[#f0e2d4] px-3 py-1 text-sm font-medium text-[#7e6959]">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-4">
                                <div class="flex flex-wrap gap-2">
                                    <button
                                        type="button"
                                        class="rounded-full bg-[#e67e22] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#c96b18]"
                                    >
                                        Details
                                    </button>

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
                                <td colspan="6" class="px-4 py-3 text-sm text-[#7e6959]">
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
