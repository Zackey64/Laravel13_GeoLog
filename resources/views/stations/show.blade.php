<x-layouts.app title="{{ $station->name }}">

    {{-- ページタイトル --}}
    <x-page-header
        title="道の駅 {{ $station->name }}"
        description="{{ $station->city->prefecture->name }} {{ $station->city->name }}"
    />

    {{-- 戻るボタン --}}
    <x-back-button
        :url="route('stations.index')"
        :label="'一覧へ戻る'"
    />

    {{-- メインコンテンツ --}}
    <div class="mb-8">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
            @forelse ($visits as $visit)
                <x-visit-card :visit="$visit" />
            @empty
                <p class="col-span-full py-12 text-center text-gray-600">
                    この道の駅には訪問記録がありません
                </p>
            @endforelse
        </div>
    </div>

    {{-- 道の駅の詳細情報 --}}
    <h2 class="pl-2 text-lg font-bold border-b-2 border-l-8 border-main text-main">情報</h2>
    <div class="mb-8 sm:pt-4 grid sm:gap-8 md:grid-cols-2">

        <div class="w-full overflow-hidden">
            <img
            src="{{ preg_match('~^https?://~i', $station->image_path)
                ? $station->image_path
                : asset('storage/' . $station->image_path) }}"
            alt="{{ $station->name }}"
            class="aspect-video w-full h-full object-cover"
            />
        </div>

        <div class="flex flex-col">
            
            <a
                href="{{ route('cities.show', $station->city) }}"
                class="grid grid-cols-2 items-center py-2 border-b border-gray-200 hover:bg-gray-50"
            >
                <span class="text-sm text-gray-400">
                    この道の駅がある市町村
                </span>
                <span class="text-right">
                    {{ $station->city->prefecture->name }}{{ $station->city->name }}
                </span>
            </a>
            <a
                href="{{ $station->official_url }}"
                class="grid grid-cols-2 items-center py-2 border-b border-gray-200 hover:bg-gray-50"
            >
                <span class="text-sm text-gray-400">
                    公式サイト
                </span>
                <span class="text-right max-w-full truncate">
                    {{ $station->official_url}}
                </span>
            </a>
            <a
                href="https://www.google.com/maps/search/?api=1&amp;query={{ "道の駅 " . rawurlencode($station->name) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="grid grid-cols-2 items-center py-2 border-b border-gray-200 hover:bg-gray-50"
            >
                <span class="text-sm text-gray-400">
                    住所 ( GoogleMap で開く )
                </span>
                <span class="text-right">
                    {{ $station->address }}
                </span>
            </a>
        </div>
    </div>




    {{-- 近隣の道の駅や市町村 --}}
    <x-nearby-places
        :stations="$nearbyStations"
        :cities="$nearbyCities"
    />

</x-layouts.app>