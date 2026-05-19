<!-- resources/views/components/card.blade.php -->
@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'p-4 sm:p-8 bg-white rounded-2xl shadow-md border border-amber-100 ' . $class]) }}>
    {{ $slot }}
</div>