<a 
    {{ $attributes->merge([
        'class' => 'bg-[#f5d7c4] block p-6 border border-default shadow-xs hover:bg-neutral-secondary-medium'
    ]) }}
>
    {{ $slot }}    
</a>
