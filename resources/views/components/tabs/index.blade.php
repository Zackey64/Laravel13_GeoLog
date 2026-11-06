@props(['default' => 'map'])

<div x-data="{ tab: '{{ $default }}' }">
    {{ $slot }}
</div>