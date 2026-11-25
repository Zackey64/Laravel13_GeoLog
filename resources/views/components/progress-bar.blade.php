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

<div {{ $attributes }}>
    {{-- 名称・進捗率 --}}
    <div class="flex items-center justify-between">
        <div>
            <span class='font-bold text-gray-600'>
                {{ $name }}
            </span>
            <span class='px-2 text-gray-600 text-xs'>
                ( {{ $current }} / {{ $total }} )
            </span>
        </div>

        <span class='font-bold text-main'>
            {{ $progress }}%
        </span>
    </div>

    {{-- プログレスバー --}}
    <div class='h-1 overflow-hidden rounded-full bg-gray-300'>
        <div
            class="h-full rounded-full bg-main"
            style="width: {{ $progress }}%"
        ></div>
    </div>
</div>