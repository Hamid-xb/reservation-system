<x-restaurant-layout
    :restaurant="$restaurant"
    active="settings"
    header="Restaurant instellingen"
    subheader="Beheer de gegevens van {{ $restaurant->name }}"
>
    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-100 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-2xl bg-red-100 px-5 py-4 text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

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
    @endphp

    <form
        method="POST"
        action="{{ route('restaurant.settings.update', $restaurant) }}"
        enctype="multipart/form-data"
        class="space-y-8"
    >
        @csrf
        @method('PUT')

        <div class="rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">
            <h2 class="mb-6 text-2xl font-bold text-[#2c1a12]">
                Algemene informatie
            </h2>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        Naam
                    </label>

                    <input
                        name="name"
                        value="{{ old('name', $restaurant->name) }}"
                        class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                        required
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        Keuken
                    </label>

                    <select
                        name="restaurant_type_id"
                        class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                    >
                        <option value="">Selecteer keuken</option>

                        @foreach($restaurantTypes as $type)
                            <option
                                value="{{ $type->id }}"
                                @selected(old('restaurant_type_id', $restaurant->restaurant_type_id) == $type->id)
                            >
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        Beschrijving
                    </label>

                    <textarea
                        name="description"
                        rows="5"
                        class="w-full rounded-[24px] border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                    >{{ old('description', $restaurant->description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">
            <h2 class="mb-6 text-2xl font-bold text-[#2c1a12]">
                Contactgegevens
            </h2>

            <div class="grid gap-5 md:grid-cols-3">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        Volledig adres
                    </label>

                    <input
                        name="address"
                        value="{{ old('address', $restaurant->information?->address) }}"
                        placeholder="Straat 1, 1234 AB Stad"
                        class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                        required
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        E-mail
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $restaurant->information?->email) }}"
                        class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                        required
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        Telefoonnummer
                    </label>

                    <input
                        name="phone_number"
                        value="{{ old('phone_number', $restaurant->information?->phone_number) }}"
                        class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">
            <h2 class="mb-6 text-2xl font-bold text-[#2c1a12]">
                Afbeeldingen
            </h2>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        Logo
                    </label>

                    @if($restaurant->logo)
                        <img
                            src="{{ asset($restaurant->logo->image_url) }}"
                            alt="Logo van {{ $restaurant->name }}"
                            class="mb-4 h-28 w-28 rounded-2xl object-cover"
                        >
                    @else
                        <div class="mb-4 flex h-28 w-28 items-center justify-center rounded-2xl bg-[#fefaf5] text-sm font-semibold text-[#a48e7c]">
                            Geen logo
                        </div>
                    @endif

                    <input
                        type="file"
                        name="logo"
                        accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        Banner
                    </label>

                    @if($restaurant->banner)
                        <img
                            src="{{ asset($restaurant->banner->image_url) }}"
                            alt="Banner van {{ $restaurant->name }}"
                            class="mb-4 h-28 w-full rounded-2xl object-cover"
                        >
                    @else
                        <div class="mb-4 flex h-28 w-full items-center justify-center rounded-2xl bg-[#fefaf5] text-sm font-semibold text-[#a48e7c]">
                            Geen banner
                        </div>
                    @endif

                    <input
                        type="file"
                        name="banner"
                        accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                    >
                </div>
            </div>
        </div>

        <div class="rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">
            <h2 class="mb-6 text-2xl font-bold text-[#2c1a12]">
                Openingstijden
            </h2>

            <div class="space-y-4">
                @foreach($days as $dayNumber => $dayName)
                    @php
                        $hours = $openingHours->get($dayNumber);
                    @endphp

                    <div class="grid items-center gap-4 rounded-2xl bg-[#fefaf5] p-4 md:grid-cols-[1fr_160px_160px_120px]">
                        <div class="font-semibold text-[#2c1a12]">
                            {{ $dayName }}
                        </div>

                        <input
                            type="time"
                            name="opening_hours[{{ $dayNumber }}][open_time]"
                            value="{{ old("opening_hours.$dayNumber.open_time", $hours?->open_time ? substr($hours->open_time, 0, 5) : '') }}"
                            class="rounded-full border border-[#f0e2d4] bg-white px-4 py-2 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                        >

                        <input
                            type="time"
                            name="opening_hours[{{ $dayNumber }}][close_time]"
                            value="{{ old("opening_hours.$dayNumber.close_time", $hours?->close_time ? substr($hours->close_time, 0, 5) : '') }}"
                            class="rounded-full border border-[#f0e2d4] bg-white px-4 py-2 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                        >

                        <label class="flex items-center gap-2 text-sm font-semibold text-[#7e6959]">
                            <input
                                type="checkbox"
                                name="opening_hours[{{ $dayNumber }}][closed]"
                                value="1"
                                @checked(! $hours)
                                class="rounded border-[#f0e2d4] text-[#c53a1f] focus:ring-[#c53a1f]"
                            >
                            Gesloten
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                class="rounded-full bg-[#c53a1f] px-7 py-3 font-semibold text-white transition hover:bg-[#9f2f17]"
            >
                Instellingen opslaan
            </button>
        </div>
    </form>
</x-restaurant-layout>
