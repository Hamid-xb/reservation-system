<x-app-layout
    title="Restaurant toevoegen"
    :header="__('Restaurant toevoegen')">

    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-3xl border border-amber-100 bg-white shadow-lg">
            <div class="border-b border-amber-100 bg-gradient-to-br from-amber-50 to-orange-50 px-8 py-6">
                <h1 class="text-3xl font-extrabold text-stone-900">
                    Restaurant toevoegen
                </h1>

                <p class="mt-2 text-stone-600">
                    Maak je restaurant aan en beheer daarna je dashboard.
                </p>
            </div>

            @if($errors->any())
                <div class="mx-8 mt-6 rounded-2xl bg-red-100 px-5 py-4 text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('restaurants.store') }}" class="space-y-6 p-8">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-semibold text-stone-700">
                        Naam
                    </label>

                    <input
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full rounded-xl border border-amber-200 px-4 py-3 focus:border-red-500 focus:ring-2 focus:ring-red-500"
                        required
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-stone-700">
                        Keuken
                    </label>

                    <select
                        name="restaurant_type_id"
                        class="w-full rounded-xl border border-amber-200 px-4 py-3 focus:border-red-500 focus:ring-2 focus:ring-red-500"
                    >
                        <option value="">Selecteer keuken</option>

                        @foreach($restaurantTypes as $type)
                            <option value="{{ $type->id }}" @selected(old('restaurant_type_id') == $type->id)>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-stone-700">
                        Beschrijving
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        class="w-full rounded-xl border border-amber-200 px-4 py-3 focus:border-red-500 focus:ring-2 focus:ring-red-500"
                    >{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-stone-700">
                        Volledig adres
                    </label>

                    <input
                        name="address"
                        value="{{ old('address') }}"
                        class="w-full rounded-xl border border-amber-200 px-4 py-3 focus:border-red-500 focus:ring-2 focus:ring-red-500"
                        required
                    >
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-stone-700">
                            E-mail
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full rounded-xl border border-amber-200 px-4 py-3 focus:border-red-500 focus:ring-2 focus:ring-red-500"
                            required
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-stone-700">
                            Telefoonnummer
                        </label>

                        <input
                            name="phone_number"
                            value="{{ old('phone_number') }}"
                            class="w-full rounded-xl border border-amber-200 px-4 py-3 focus:border-red-500 focus:ring-2 focus:ring-red-500"
                            required
                        >
                    </div>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row">
                    <button
                        type="submit"
                        class="flex-1 rounded-full bg-red-600 px-8 py-4 font-semibold text-white transition hover:bg-red-700"
                    >
                        Restaurant aanmaken
                    </button>

                    <a
                        href="{{ route('home') }}"
                        class="flex-1 rounded-full border-2 border-stone-300 px-8 py-4 text-center font-semibold text-stone-700 transition hover:border-red-300 hover:text-red-600"
                    >
                        Annuleren
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
