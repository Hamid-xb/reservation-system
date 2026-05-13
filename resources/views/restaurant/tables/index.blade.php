<x-restaurant-layout
    :restaurant="$restaurant"
    active="tables"
    header="Tafels"
    subheader="Beheer de tafels van {{ $restaurant->name }}"
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

    <div class="mb-8 rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">
        <h2 class="mb-6 text-2xl font-bold text-[#2c1a12]">
            Nieuwe tafel toevoegen
        </h2>

        <form
            method="POST"
            action="{{ route('restaurant.tables.store', $restaurant) }}"
            class="grid gap-5 md:grid-cols-3"
        >
            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                    Tafelnummer
                </label>

                <input
                    type="number"
                    name="table_number"
                    value="{{ old('table_number') }}"
                    min="1"
                    class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                    required
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                    Zitplaatsen
                </label>

                <input
                    type="number"
                    name="seats"
                    value="{{ old('seats') }}"
                    min="1"
                    class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                    required
                >
            </div>

            <div class="flex items-end">
                <button
                    type="submit"
                    class="w-full rounded-full bg-[#c53a1f] px-5 py-3 font-semibold text-white transition hover:bg-[#9f2f17]"
                >
                    + Tafel toevoegen
                </button>
            </div>
        </form>
    </div>

    <div class="rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">
        <h2 class="mb-6 text-2xl font-bold text-[#2c1a12]">
            Alle tafels
        </h2>

        @if($tables->isEmpty())
            <div class="py-12 text-center text-[#a48e7c]">
                Nog geen tafels toegevoegd.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                    <tr class="border-b border-[#f0e2d8] text-left">
                        <th class="pb-4 font-semibold text-[#7e6959]">
                            Tafelnummer
                        </th>
                        <th class="pb-4 font-semibold text-[#7e6959]">
                            Zitplaatsen aanpassen
                        </th>
                        <th class="pb-4 font-semibold text-[#7e6959]">
                            Acties
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($tables as $table)
                        <tr class="border-b border-[#f7eee7]">
                            <td class="py-4 font-medium text-[#2c1a12]">
                                Tafel {{ $table->table_number }}
                            </td>

                            <td class="py-4">
                                <form
                                    id="update-table-{{ $table->id }}"
                                    method="POST"
                                    action="{{ route('restaurant.tables.update', [$restaurant, $table]) }}"
                                >
                                    @csrf
                                    @method('PUT')

                                    <input
                                        type="hidden"
                                        name="table_number"
                                        value="{{ $table->table_number }}"
                                    >

                                    <input
                                        type="number"
                                        name="seats"
                                        value="{{ $table->seats }}"
                                        min="1"
                                        class="w-24 rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-4 py-2 text-sm focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                                        required
                                    >
                                </form>
                            </td>

                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <button
                                        type="submit"
                                        form="update-table-{{ $table->id }}"
                                        class="rounded-full bg-[#e67e22] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#c96b18]"
                                    >
                                        Opslaan
                                    </button>

                                    <form
                                        method="POST"
                                        action="{{ route('restaurant.tables.destroy', [$restaurant, $table]) }}"
                                        onsubmit="return confirm('Weet je zeker dat je deze tafel wilt verwijderen?')"
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
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-restaurant-layout>
