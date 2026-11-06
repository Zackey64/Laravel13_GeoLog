
<a href="{{ route('stations.show', $station) }}" 
    class="group relative block aspect-video overflow-hidden rounded-xl bg-gray-900"
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

    {{-- ホバー時のオーバーレイ --}}
    <div class="absolute inset-0 hover:bg-white/20"></div>

    {{-- 駅コードのラベル --}}
    <div class="absolute top-2 right-2 rounded-lg bg-blue-600">
        <p class="px-2 text-sm font-bold text-white">
            {{ $station->station_code }}
        </p>
    </div>

    {{-- 情報 --}}
    <div class="absolute inset-x-0 bottom-0 px-4 py-2 bg-black/70">
        <div>
            <h2 class="text-lg font-bold text-blue-300">
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
</a>