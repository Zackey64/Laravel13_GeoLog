<x-layouts.app title="{{ $station->name }}">

    {{-- ページタイトル --}}
    <x-page-header
        title="道の駅 {{ $station->name }}"
        description="{{ $station->city->prefecture->name }} {{ $station->city->name }}"
    />

<div class="mb-4 grid gap-2 grid-cols-3">
    <div class="grid gap-2 grid-rows-3">
        <a href="{{ $station->official_url }}" target="_blank" class="flex h-full w-full items-center justify-center border border-blue-600 bg-white">
            <p class=" text-sm text-blue-600">
                公式サイトへ
            </p>
        </a>
        <a href="{{ $station->official_url }}" target="_blank" class="flex h-full w-full items-center justify-center border border-blue-600 bg-blue-100">
            <p class=" text-sm text-blue-600">
                公式サイトへ
            </p>
        </a>
        <div class="p-4 flex flex-col h-full w-full items-center justify-between border border-gray-300 rounded-md bg-yellow-50">
            <h2 class="text-lg font-bold">{{ $station->name }}がある市町村</h2>
            <x-city-list :city="$station->city" />
        </div>
    </div>
    <div class="col-span-2 w-full justify-end">
        <img
            src="{{ asset('storage/' . $station->image_path) }}"
            alt="{{ $station->name }}"
            class="aspect-video h-full object-cover"
        />
    </div>
</div>

    

    {{-- 戻るボタン --}}
    <x-back-button
        :url="route('stations.index')"
        :label="'一覧へ戻る'"
    />

    {{-- メインコンテンツ --}}
    <div class="p-4 gap-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 rounded-xl border border-gray-300 bg-white">
        @forelse ($visits as $visit)
            <x-visit-card :visit="$visit" />
        @empty
            <p class="col-span-full py-12 text-center text-gray-600">
                この道の駅には訪問記録がありません
            </p>
        @endforelse
    </div>

    {{-- 道の駅が属する市町村 --}}
    <div class="py-8">
        <h2 class="py-2 mb-4 text-lg font-bold border-b border-blue-600">{{ $station->name }}がある市町村</h2>

        <x-tabs.panel name="list">
            {{-- カード一覧 --}}
            <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <x-city-list :city="$station->city" />
            </div>
        </x-tabs.panel>

    </div>

    {{-- 近隣の道の駅や市町村 --}}
    <x-nearby-places
        :stations="$nearbyStations"
        :cities="$nearbyCities"
    />

</x-layouts.app>