@props(['station'])

<a href="{{ route('stations.show', $station) }}" 
    class="group relative block aspect-video overflow-hidden rounded-xl border border-blue-600 bg-gray-900"
>
    
    {{-- 写真 --}}
    @if ($station->image_path)
        <img
            src="{{ asset('storage/' . $station->image_path) }}"
            alt="{{ $station->name }}"
            class="absolute inset-0 h-full w-full object-cover"
        >
    @else
        <span class="text-sm text-gray-400">画像なし</span>
    @endif

    

    {{-- 駅コードのラベル --}}
    <div class="absolute top-0 left-0  rounded-br-md bg-blue-600">
        <p class="px-2 text-sm font-bold text-white">
            {{ $station->station_code }}
        </p>
    </div>

    {{-- 訪問済みラベル --}}
    @if ($station->visited)
                <div class="absolute top-2 right-2  flex items-center border border-green-600 rounded-md overflow-hidden bg-green-50"> 
                    <p class="text-xs font-bold text-green-600 px-1">
                        記録
                    </p>
                    <p class="text-xs font-bold aspect-square text-center text-white bg-green-600 px-1">
                        {{ $station->visits->count() }}
                    </p>
                </div>
            @endif
    
    {{-- 情報 --}}
    <div @class([
        'absolute inset-x-0 bottom-0 px-4 py-2',
        'bg-green-950/70' => $station->visited,
        'bg-black/70' => !$station->visited,
    ])>
        <div>
            <h2 class="text-lg font-extrabold text-blue-300">
                {{ $station->name }}
            </h2>
        </div>
        <div>
            <p class="text-sm text-white">
                {{ $station->city->prefecture->name }}
                {{ $station->city->name }}
            </p>
        </div>
    </div>

    {{-- ホバー時のオーバーレイ --}}
    <div class="absolute inset-0 hover:bg-white/10"></div>
    
</a>