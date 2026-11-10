<x-layouts.app title="{{ $city->name }}">
    
    {{-- ページタイトル --}}
    <x-page-header
        title="{{ $city->prefecture->name }}{{ $city->name }}"
        description="{{ $city->kana }}"
    />
    
    {{-- 戻るボタン --}}
    <x-back-button
        :url="route('cities.index')"
        :label="'一覧へ戻る'"
    />

    {{-- メインコンテンツ --}}
    <div class="p-4 gap-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 rounded-xl border border-gray-300 bg-white">
        @forelse ($visits as $visit)
            <x-visit-card :visit="$visit" />
        @empty
            <p class="col-span-full py-12 text-center text-gray-600">
                この市町村には訪問記録がありません
            </p>
        @endforelse
    </div>


    {{-- 市町村内の道の駅 --}}
    <div class="py-8">
        <h2 class="py-2 mb-4 text-lg font-bold border-b border-blue-600">{{ $city->name }}内の道の駅</h2>

        <x-tabs.panel name="list">
            {{-- カード一覧 --}}
            <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @forelse ($stations as $station)
                    <x-station-card :station="$station" />
                @empty
                    <p class="col-span-full py-12 text-center text-gray-500">
                        この市町村には道の駅がありません。
                    </p>
                @endforelse
                    
            </div>
        </x-tabs.panel>

    </div>

    {{-- 近隣の道の駅や市町村 --}}
    <x-nearby-places
        :stations="$nearbyStations"
        :cities="$nearbyCities"
    />
    
</x-layouts.app>