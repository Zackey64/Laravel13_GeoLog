
<a href="{{ route('cities.show', $city) }}" 
    class="flex w-full bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
>




    {{-- 情報 --}}
    <div class="flex px-4 py-2 items-end ">
        <div>
            <h2 class="text- font-bold text-gray-900">
                {{ $city->prefecture->name }}
            </h2>
        </div>
        <div class="flex-1 w-full">
            <p class="text-xs text-gray-600">
                {{ $city->kana }}
            </p>
            <h2 class="text- font-bold text-gray-900">
                {{ $city->name }}
            </h2>
        </div>
        <div>
            {{ $city->code }}
        </div>
    </div>
</a>