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
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-stone-900 antialiased min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-amber-50 to-orange-50 px-4">
        
        <!-- Logo -->
        <div class="mb-8">
            <a href="{{ route('home') }}" class="text-3xl font-extrabold bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent">
                🍽️ Tafello
            </a>
        </div>

        <!-- Card -->
        <div class="w-full sm:max-w-md px-8 py-8 bg-white rounded-2xl shadow-lg border border-amber-100">
            {{ $slot }}
        </div>
    </body>
</html>