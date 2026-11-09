<x-layouts.app title="{{ $station->name }}">
<div class="-mx-4 bg-blue-600">
    <div
        class="relative aspect-video max-h-100 bg-cover bg-center"
        style="background-image: url('{{ asset('storage/' . $station->image_path) }}')"
    ></div>
</div>
    {{-- ページタイトル --}}
    <x-page-header
        title="道の駅 {{ $station->name }}"
        description="{{ $station->city->prefecture->name }} {{ $station->city->name }}"
    />

    

    {{-- 戻るボタン --}}
    <x-back-button/>

    {{-- メインコンテンツ --}}
    <div class="p-4 grid sm:grid-cols-2 gap-4 rounded-xl border border-gray-300 bg-white">
            <p class="col-span-full py-12 text-center text-gray-600">
                記録はありません
            </p>
    </div>


    {{-- 近隣の道の駅や市町村 --}}
    <x-nearby-places
        :stations="$nearbyStations"
        :cities="$nearbyCities"
    />

</x-layouts.app>