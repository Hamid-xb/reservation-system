@props([
    'title' => 'Tafello - Reservation System',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍽️</text></svg>">
        <title>{{ $title }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#f8f4ef]">

        <div>
            <x-navbar />
        </div>

        <main class="min-h-[calc(100vh-200px)] max-w-7xl mx-auto mt-6 py-4">
             @if (session('success'))
                <div class="flex justify-center w-full">
                    <div class="w-full text-center mb-5 bg-green-300 rounded p-4">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="flex justify-center w-full">
                    <div class="w-full text-center mb-5 bg-red-400 rounded p-4">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            {{ $slot }}
        </main>

        <x-footer />
    </body>
</html>
