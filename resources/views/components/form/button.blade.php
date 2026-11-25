@props([
    'type' => 'submit',
    'color' => 'primary',
])

@php
    $colors = [
        'primary' => 'bg-main text-white',
        'secondary' => 'border border-gray-300 text-gray-600',
        'danger' => 'bg-red-600 text-white',
    ];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'rounded-lg px-3 py-1 text-sm font-semibold transition ' . $colors[$color]
    ]) }}
>
    {{ $slot }}
</button>