@props(['city'])

<a href="{{ route('cities.show', $city) }}" @class([
    'flex w-full border rounded-lg overflow-hidden',
    'border-blue-600' => $city->stations->count() > 0,
    'border-gray-300' => $city->stations->count() === 0,
])>

    <div @class([
        'flex w-full items-center',
        'bg-blue-600' => $city->stations->count() > 0,
        'bg-gray-300' => $city->stations->count() === 0,
    ])>
        {{-- 道の駅の有無 --}}
        <div class='h-full flex flex-col items-center justify-center'>
            <p class="px-1 text-sm font-bold text-white">
                {{ $city->stations->count() }}
            </p>
            <p class="px-1 text-xs text-white">
                駅
            </p>
        </div>

        {{-- 情報 --}}
        <div @class([
            'flex w-full px-2 py-2 gap-2 items-center justify-between rounded-lg',
            'bg-green-50 hover:bg-green-100 ' => $city->visited,
            'bg-white hover:bg-gray-50' => !$city->visited,
        ])>
        <div class="flex gap-1 items-end">
            <p class="text-sm  text-gray-900">
                {{ $city->prefecture->name }}
            </p>
            <p class="text-md font-bold text-gray-900">
                {{ $city->name }}
            </p>
        </div>

            @if ($city->visited)
                <div class=" flex items-center border border-green-600 rounded-md overflow-hidden"> 
                    <p class="text-xs font-bold text-green-600 px-1">
                        記録
                    </p>
                    <p class="text-xs font-bold aspect-square text-center text-white bg-green-600 px-1">
                        {{ $city->visitCount }}
                    </p>
                </div>
            @endif
        </div>
        
    </div>

</a>