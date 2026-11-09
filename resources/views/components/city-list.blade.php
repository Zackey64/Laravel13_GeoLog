
<a href="{{ route('cities.show', $city) }}" 
    class="flex w-full bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
>

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