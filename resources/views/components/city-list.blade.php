
<a href="{{ route('cities.show', $city) }}" @class([
    'flex w-full border border-gray-300 rounded-lg',
    'bg-green-200 hover:bg-green-100' => $city->visits->count() > 0,
    'bg-white hover:bg-gray-100' => $city->visits->count() === 0,
])>

    {{-- 情報 --}}
    <div class="flex w-full px-4 py-2 justify-between items-center">
        <div>
            <p class="text-md font-bold text-gray-900">
                {{ $city->prefecture->name }} {{ $city->name }}
            </p>
        </div>

        <div @class([
            'flex px-2 rounded-lg',
            'bg-blue-600' => $city->stations->count() > 0,
            'bg-gray-300' => $city->stations->count() === 0,
        ])>
            <p class="text-sm font-bold text-white">
                {{ $city->stations->count() }} 駅
            </p>
        </div>
    </div>

</a>