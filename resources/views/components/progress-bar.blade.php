
@props([
    'total' => 0,
    'visited' => 0,
])

@php
    $percentage = $total > 0
        ? round($visited / $total * 100, 1)
        : 0;
@endphp

<div {{ $attributes->class(['w-full']) }}>
    <div class="mb-2 flex items-center justify-between">
        <span class="text-sm text-gray-600">
            {{ $visited }} / {{ $total }}
        </span>

        <span class="text-sm font-bold text-green-600">
            {{ $percentage }}%
        </span>
    </div>

    <div class="h-3 w-full overflow-hidden rounded-full bg-gray-200">
        <div
            class="h-full rounded-full bg-green-500 transition-all duration-300"
            style="width: {{ min(100, max(0, $percentage)) }}%"
        ></div>
    </div>
</div>
