@props(['visit'])

<div class="border border-gray-300 bg-amber-50 p-2 shadow-sm">
    
    <div class="relative w-full aspect-square bg-gray-100">
        @if ($visit->image_path)
        <img
                src="{{ asset('storage/' . $visit->image_path) }}"
                alt="訪問写真"
                class="absolute inset-0 h-full w-full rounded-lg object-cover"
            >
        @else
            <p class="absolute inset-0 flex items-center justify-center text-gray-400">
                写真なし
            </p>
        @endif
    </div>
    

    @if ($visit->context)
        <p class="text-sm py-2 font-bold text-gray-600">
            {{ $visit->context }}
        </p>
    @endif

    <div class="flex justify-between"> 
        <p class="text-xs text-gray-600">
            {{ $visit->city->name ?? '' }}{{ $visit->station->name ?? '' }}
        </p>
        <p class="text-xs text-gray-600">
            {{ $visit->updated_at->format('Y.m.d') }}
        </p>
    </div>

</div>