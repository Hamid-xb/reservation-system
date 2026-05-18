<x-restaurant-layout
    :restaurant="$restaurant"
    active="dashboard"
    header="Dashboard"
    subheader="Overzicht van je restaurant"
>

    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-100 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

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
                {{ $pendingReservationsCount }}
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

    <div class="rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-[#2c1a12]">
                Reserveringen in afwachting
            </h2>

            <a
                href="{{ route('restaurant.reservations.index', ['restaurant' => $restaurant, 'date' => now()->toDateString()]) }}"
                class="rounded-full bg-[#c53a1f] px-5 py-2.5 text-center font-medium text-white transition hover:bg-[#9f2f17]"
            >
                Alle reserveringen
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
                    <th class="pb-4 font-semibold text-[#7e6959]">Acties</th>
                </tr>
                </thead>

                <tbody>
                @forelse($pendingReservations as $reservation)
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
                            @elseif($reservation->status === 'pending')
                                <span class="rounded-full bg-[#fff4d6] px-3 py-1 text-sm font-medium text-[#9a6a00]">
                                    In afwachting
                                </span>
                            @else
                                <span class="rounded-full bg-[#ffe8e3] px-3 py-1 text-sm font-medium text-[#c53a1f]">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            @endif
                        </td>

                        <td class="py-4">
                            <div class="flex flex-wrap gap-2">
                                <form
                                    method="POST"
                                    action="{{ route('restaurant.reservations.confirm', [$restaurant, $reservation]) }}"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="rounded-full bg-[#2e7d32] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#256628]"
                                    >
                                        Bevestig
                                    </button>
                                </form>

                                <a
                                    href="{{ route('restaurant.reservations.index', ['restaurant' => $restaurant, 'date' => $reservation->start_datetime->toDateString()]) }}"
                                    class="rounded-full bg-[#e67e22] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#c96b18]"
                                >
                                    Details
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-[#a48e7c]">
                            Geen reserveringen in afwachting.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-restaurant-layout>
