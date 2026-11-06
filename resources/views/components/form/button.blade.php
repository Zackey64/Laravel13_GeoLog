@props([
    'type' => 'submit',
    'color' => 'primary',
])

@php
    $colors = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700',
        'secondary' => 'border border-gray-300 text-gray-600 hover:bg-gray-100',
    ];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'rounded-lg px-4 py-2 text-sm font-semibold transition ' . $colors[$color]
    ]) }}
>
    {{ $slot }}
</button>