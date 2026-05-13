<x-restaurant-layout
    :restaurant="$restaurant"
    active="dashboard"
    header="Dashboard"
    subheader="Overzicht van je restaurant"
>
    {{-- Stats --}}
    <div class="mb-8 grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-[24px] border border-[#f0e2d8] bg-white p-6 shadow-sm">
            <div class="text-4xl font-extrabold text-[#c53a1f]">
                {{ $totalReservations }}
            </div>
            <div class="mt-2 text-[#6f5b4b]">
                Totaal reserveringen
            </div>
        </div>

        <div class="rounded-[24px] border border-[#f0e2d8] bg-white p-6 shadow-sm">
            <div class="text-4xl font-extrabold text-[#c53a1f]">
                {{ $todayReservations }}
            </div>
            <div class="mt-2 text-[#6f5b4b]">
                Vandaag
            </div>
        </div>

        <div class="rounded-[24px] border border-[#f0e2d8] bg-white p-6 shadow-sm">
            <div class="text-4xl font-extrabold text-[#c53a1f]">
                {{ $pendingReservations }}
            </div>
            <div class="mt-2 text-[#6f5b4b]">
                In afwachting
            </div>
        </div>

        <div class="rounded-[24px] border border-[#f0e2d8] bg-white p-6 shadow-sm">
            <div class="text-4xl font-extrabold text-[#c53a1f]">
                {{ $confirmedReservations }}
            </div>
            <div class="mt-2 text-[#6f5b4b]">
                Bevestigd
            </div>
        </div>

    </div>

    {{-- Recent Reservations --}}
    <div class="rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">

        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-[#2c1a12]">
                Recente reserveringen
            </h2>

            <a
                href="#"
                class="rounded-full bg-[#c53a1f] px-5 py-2.5 font-medium text-white transition hover:bg-[#9f2f17]"
            >
                + Nieuwe reservering
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                <tr class="border-b border-[#f0e2d8] text-left">
                    <th class="pb-4 font-semibold text-[#7e6959]">Naam</th>
                    <th class="pb-4 font-semibold text-[#7e6959]">Datum</th>
                    <th class="pb-4 font-semibold text-[#7e6959]">Tijd</th>
                    <th class="pb-4 font-semibold text-[#7e6959]">Personen</th>
                    <th class="pb-4 font-semibold text-[#7e6959]">Status</th>
                </tr>
                </thead>

                <tbody>
                @forelse($recentReservations as $reservation)
                    <tr class="border-b border-[#f7eee7]">
                        <td class="py-4 font-medium text-[#2c1a12]">
                            {{ $reservation->name }}
                        </td>

                        <td class="py-4 text-[#6f5b4b]">
                            {{ $reservation->start_datetime->format('d-m-Y') }}
                        </td>

                        <td class="py-4 text-[#6f5b4b]">
                            {{ $reservation->start_datetime->format('H:i') }}
                        </td>

                        <td class="py-4 text-[#6f5b4b]">
                            {{ $reservation->number_of_people }}
                        </td>

                        <td class="py-4">
                            @if($reservation->status === 'confirmed')
                                <span class="rounded-full bg-[#e6f4ea] px-3 py-1 text-sm font-medium text-[#2e7d32]">
                                        Bevestigd
                                    </span>
                            @elseif($reservation->status === 'pending')
                                <span class="rounded-full bg-[#fff3e0] px-3 py-1 text-sm font-medium text-[#e67e22]">
                                        In afwachting
                                    </span>
                            @elseif($reservation->status === 'cancelled')
                                <span class="rounded-full bg-[#ffe8e3] px-3 py-1 text-sm font-medium text-[#c53a1f]">
                                        Geannuleerd
                                    </span>
                            @elseif($reservation->status === 'completed')
                                <span class="rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-700">
                                        Voltooid
                                    </span>
                            @elseif($reservation->status === 'no_show')
                                <span class="rounded-full bg-gray-200 px-3 py-1 text-sm font-medium text-gray-700">
                                        Niet gekomen
                                    </span>
                            @else
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-600">
                                        {{ $reservation->status }}
                                    </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-[#a48e7c]">
                            Geen reserveringen gevonden.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-restaurant-layout>
