@props([
    'active' => 'dashboard',
    'restaurant' => null,
    'title' => 'Restaurant Dashboard',
    'header' => 'Welkom terug!',
    'subheader' => 'Beheer je restaurant',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Restaurant Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f8f4ef] font-sans antialiased">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <x-restaurant-sidebar
        :restaurant="$restaurant"
        :active="$active ?? 'dashboard'"
    />

    {{-- Main Content --}}
    <div class="ml-[280px] flex-1 p-7">

        {{-- Top bar --}}
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4 rounded-[28px] border border-[#f0e2d8] bg-white px-7 py-5 shadow-sm">

            <div>
                <h2 class="text-2xl font-bold text-[#2c1a12]">
                    {{ $header ?? 'Welkom terug!' }}
                </h2>

                <p class="text-[#7e6959]">
                    {{ $subheader ?? 'Beheer je restaurant' }}
                </p>
            </div>

            {{--{{ $actions ?? '' }}--}}

        </div>

        {{-- Page Content --}}
        {{ $slot }}

    </div>

</div>

</body>
</html>
