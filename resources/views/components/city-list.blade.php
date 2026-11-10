
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
            'flex w-full px-4 py-2 gap-2 items-center justify-between rounded-lg',
            'bg-green-200 hover:bg-green-100 ' => $city->visits->count() > 0,
            'bg-white hover:bg-gray-100' => $city->visits->count() === 0,
        ])>
            <p class="text-md font-bold text-gray-900">
                {{ $city->prefecture->name }} {{ $city->name }}
            </p>

            @if ($city->visits->count() > 0)
                <p class="text-sm text-green-600">
                    訪問済
                </p>
            @endif
        </div>
        
    </div>

</a>