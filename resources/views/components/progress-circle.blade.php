@props([
    'name',
    'current' => 0,
    'total' => 0,
])

@php
    $progress = $total > 0
        ? round($current / $total * 100, 1)
        : 0;
@endphp

<div {{ $attributes->merge(['class' => 'relative w-full']) }}>
    <svg viewBox="0 0 200 180" class="w-full">

        {{-- 背景 --}}
        <path
            d="M 43.43 156.57 A 80 80 0 1 1 156.57 156.57"
            class="fill-none stroke-gray-200"
            stroke-width="12"
            stroke-linecap="round"
        />

        {{-- 進捗 --}}
        @if ($progress > 0)
            <path
                d="M 43.43 156.57 A 80 80 0 1 1 156.57 156.57"
                class="fill-none stroke-main"
                stroke-width="12"
                stroke-linecap="round"
                pathLength="100"
                stroke-dasharray="{{ $progress }} 100"
            />
        @endif

    </svg>

    {{-- 中央の文字 --}}
    <div class="absolute inset-0 flex flex-col gap-1 items-center justify-center">
        <span class="text-sm font-bold text-gray-600">
            {{ $name }}
        </span>

        <span class="text-3xl font-bold text-main">
            {{ $progress }}%
        </span>

        <span class="text-sm text-gray-600">
            {{ $current }} / {{ $total }} 件
        </span>
    </div>
</div>