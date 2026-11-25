@props(['visit'])

<a href="{{ route('visits.show', $visit) }}" class="relative aspect-square overflow-hidden bg-gray-600">
    
    {{-- 訪問写真 --}}
    @if ($visit->image_path)
        <img
            src="{{ asset('storage/' . $visit->image_path) }}"
            alt="訪問写真"
            class="absolute inset-0 h-full w-full object-cover"
        >
    @else
        <p class="absolute inset-0 flex items-center justify-center text-white">
            写真なし
        </p>
    @endif

    {{-- 上下のグラデーション --}}
    <div class="absolute top-0 inset-x-0 h-[15%] bg-linear-to-b from-black/50 to-transparent"></div>
    <div class="absolute bottom-0 inset-x-0 h-[15%] bg-linear-to-t from-black/50 to-transparent"></div>
    <div class="absolute hover:bg-white/25 inset-0 "></div>

    {{-- 訪問先・日付 --}}
    <div class="absolute p-1 inset-x-0 top-0 flex items-end justify-between text-white">
        <p class="min-w-0 truncate text-xs">
            {{ $visit->city->name ?? '' }}{{ $visit->station->name ?? '' }}
        </p>

        <p class="shrink-0 text-xs">
            {{ $visit->updated_at->format('y.m.d') }}
        </p>
    </div>

    {{-- コメント --}}
    @if ($visit->context)
        <p class="absolute p-1 bottom-0 text-sm font-bold text-white ">
            {{ $visit->context }}
        </p>
    @endif



</a>