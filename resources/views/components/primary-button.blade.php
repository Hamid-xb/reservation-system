<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 bg-red-600 text-white py-2.5 rounded-full font-semibold hover:bg-red-700 transition-colors ']) }}>
    {{ $slot }}
</button>
