<x-restaurant-layout
    :restaurant="$restaurant"
    active="members"
    header="Leden"
    subheader="Beheer de gebruikers van {{ $restaurant->name }}"
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
        $currentUserRole = auth()->user()
            ->userRoles()
            ->with('role')
            ->where('restaurant_id', $restaurant->id)
            ->first();

        $roleLevel = function (?string $roleName): int {
            return match (strtolower($roleName ?? '')) {
                'restaurant_owner' => 3,
                'restaurant_manager' => 2,
                'restaurant_staff' => 1,
                default => 0,
            };
        };

        $currentLevel = $roleLevel($currentUserRole?->role?->name);

        $availableRoles = $editableRoles->filter(function ($role) use ($currentLevel, $roleLevel) {
            return $currentLevel > $roleLevel($role->name);
        });
    @endphp

    <div class="rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">
        <div class="mb-8">
            <h2 class="mb-6 text-2xl font-bold text-[#2c1a12]">
                Lid toevoegen
            </h2>

            <form
                method="POST"
                action="{{ route('restaurant.members.store', $restaurant) }}"
                class="grid gap-5 md:grid-cols-3"
            >
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        Email adres
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                        required
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                        Rol
                    </label>

                    <select
                        name="role_id"
                        class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                        required
                    >
                        @foreach($availableRoles as $role)
                            <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>
                                {{ ucfirst(str_replace('_', ' ', strtolower($role->name))) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button
                        type="submit"
                        class="w-full rounded-full bg-[#c53a1f] px-5 py-3 font-semibold text-white transition hover:bg-[#9f2f17]"
                    >
                        + Lid toevoegen
                    </button>
                </div>
            </form>
        </div>

        <h2 class="mb-6 text-2xl font-bold text-[#2c1a12]">
            Restaurantleden
        </h2>

        @if($members->isEmpty())
            <div class="py-12 text-center text-[#a48e7c]">
                Geen leden gevonden.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                    <tr class="border-b border-[#f0e2d8] text-left">
                        <th class="pb-4 font-semibold text-[#7e6959]">Naam</th>
                        <th class="pb-4 font-semibold text-[#7e6959]">E-mail</th>
                        <th class="pb-4 font-semibold text-[#7e6959]">Rol</th>
                        <th class="pb-4 font-semibold text-[#7e6959]">Acties</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($members as $member)
                        @php
                            $memberRoleName = $member->role?->name;
                            $memberLevel = $roleLevel($memberRoleName);

                            $canManage = $member->user_id !== auth()->id()
                                && $currentLevel > $memberLevel;
                        @endphp

                        <tr class="border-b border-[#f7eee7]">
                            <td class="py-4 font-medium text-[#2c1a12]">
                                {{ $member->user->name }}
                            </td>

                            <td class="py-4 text-[#6f5b4b]">
                                {{ $member->user->email }}
                            </td>

                            <td class="py-4">
                                @if($canManage)
                                    <form
                                        method="POST"
                                        action="{{ route('restaurant.members.update', [$restaurant, $member]) }}"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <select
                                            name="role_id"
                                            onchange="this.form.submit()"
                                            class="min-w-[190px] cursor-pointer rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-4 py-2 text-sm font-semibold text-[#3e2c23] shadow-sm transition focus:border-[#c53a1f] focus:outline-none focus:ring-4 focus:ring-[#c53a1f]/10"
                                        >
                                            @foreach($availableRoles as $role)
                                                <option
                                                    value="{{ $role->id }}"
                                                    @selected($member->role_id === $role->id)
                                                >
                                                    {{ ucfirst(str_replace('_', ' ', strtolower($role->name))) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                @else
                                    <span class="rounded-full bg-[#f0e2d4] px-4 py-2 text-sm font-medium text-[#7e6959]">
                                        {{ $memberRoleName ? ucfirst(str_replace('_', ' ', strtolower($memberRoleName))) : 'Geen rol' }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-4">
                                @if($canManage)
                                    <form
                                        method="POST"
                                        action="{{ route('restaurant.members.destroy', [$restaurant, $member]) }}"
                                        onsubmit="return confirm('Weet je zeker dat je dit lid wilt verwijderen?')"
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
                                @else
                                    <span class="text-sm text-[#a48e7c]">
                                        Niet aanpasbaar
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-restaurant-layout>
