@props(['alt' => 'Aretes Mich'])

<img
    src="{{ asset('images/logo_aretes_mich_1.svg') }}"
    alt="{{ $alt }}"
    {{ $attributes->merge(['class' => 'h-20 w-auto object-contain rounded-full']) }}
/>
