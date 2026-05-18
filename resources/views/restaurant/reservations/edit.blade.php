<x-restaurant-layout
    :restaurant="$restaurant"
    active="reservations"
    header="Reservering details"
    subheader="Bekijk en wijzig deze reservering"
>
    @if($errors->any())
        <div class="mb-6 rounded-2xl bg-red-100 px-5 py-4 text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">
        <h2 class="mb-6 text-2xl font-bold text-[#2c1a12]">
            {{ $reservation->name }}
        </h2>

        <form
            method="POST"
            action="{{ route('restaurant.reservations.update', [$restaurant, $reservation]) }}"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            <div class="grid gap-5 md:grid-cols-3">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        Datum
                    </label>

                    <input
                        type="date"
                        name="date"
                        value="{{ old('date', $reservation->start_datetime->format('Y-m-d')) }}"
                        class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                        required
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        Tijd
                    </label>

                    <select
                        name="time"
                        class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                        required
                    >
                        <option value="">Selecteer tijd</option>

                        @php
                            $selectedTime = old('time', $reservation->start_datetime->format('H:i'));
                            $times = [];

                            for ($h = 17; $h <= 22; $h++) {
                                foreach ([0, 15, 30, 45] as $minute) {
                                    $times[] = sprintf('%02d:%02d', $h, $minute);
                                }
                            }
                        @endphp

                        @foreach($times as $time)
                            <option value="{{ $time }}" @selected($selectedTime === $time)>
                                {{ $time }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        Aantal personen
                    </label>

                    <input
                        type="number"
                        name="number_of_people"
                        min="1"
                        value="{{ old('number_of_people', $reservation->number_of_people) }}"
                        class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                        required
                    >
                </div>
            </div>

            <div class="rounded-2xl bg-[#fefaf5] p-5 text-[#6f5b4b]">
                <p><span class="font-semibold text-[#2c1a12]">Telefoon:</span> {{ $reservation->phone_number }}</p>
                <p><span class="font-semibold text-[#2c1a12]">Status:</span> {{ ucfirst($reservation->status) }}</p>

                @if($reservation->reservation_note)
                    <p class="mt-3">
                        <span class="font-semibold text-[#2c1a12]">Opmerking:</span>
                        {{ $reservation->reservation_note }}
                    </p>
                @endif
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <a
                    href="{{ route('restaurant.reservations.index', ['restaurant' => $restaurant, 'date' => $reservation->start_datetime->toDateString()]) }}"
                    class="rounded-full bg-[#3e2c23] px-5 py-3 text-center font-semibold text-white transition hover:bg-[#2c1a12]"
                >
                    Terug
                </a>

                <button
                    type="submit"
                    class="rounded-full bg-[#c53a1f] px-5 py-3 font-semibold text-white transition hover:bg-[#9f2f17]"
                >
                    Wijzigingen opslaan
                </button>
            </div>
        </form>
    </div>
</x-restaurant-layout>
