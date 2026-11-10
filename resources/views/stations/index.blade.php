
<x-layouts.app title="道の駅一覧">
    <div>

        {{-- ページタイトル --}}
        <x-page-header
            title="道の駅一覧"
            description="全国の道の駅を探すことができます。"
        />

        {{-- フィルターセクション --}}
        <div class="p-4 grid md:grid-cols-2 gap-4 rounded-xl border border-gray-300 bg-white">

            {{-- 都道府県フィルター --}}
            <form action="{{ route('stations.index') }}" method="GET">
                <input type="hidden" name="prefecture_id" value="{{ request('prefecture_id') }}">
                <input type="hidden" name="sort" value="{{ request('sort', 'code') }}">

                <div class="flex items-end gap-2">

                    <div class="flex-1">
                        <x-form.input
                            name="keyword"
                            label="キーワード検索"
                            placeholder="道の駅名で検索"
                        />
                    </div>

                    <x-form.button>
                        検索
                    </x-form.button>

                    <x-form.button
                        type="button"
                        color="secondary"
                        :onclick="'location.href=\''.route('stations.index').'\''"
                    >
                        リセット
                    </x-form.button>

                </div>
            </form>

            {{--フィルタ＋ソート --}}
            <form action="{{ route('stations.index') }}" method="GET">
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                <div class="grid gap-2 grid-cols-3">

                    <x-form.select
                    name="prefecture_id"
                    label="都道府県"
                    :options="$prefectures"
                    :value="request('prefecture_id')"
                    onchange="this.form.submit()"
                    />

                    <x-form.select
                    name="visited_status"
                    label="来訪記録"
                    :options="[
                        (object) ['id' => 'visited', 'name' => '訪問済'],
                        (object) ['id' => 'not_visited', 'name' => '未訪問'],
                    ]"
                    :value="request('visited_status')"
                    onchange="this.form.submit()"
                    />

                    <x-form.select
                    name="sort"
                    label="並び替え"
                    :options="[
                        (object) ['id' => 'code', 'name' => '道の駅コード順'],
                        (object) ['id' => 'name', 'name' => '道の駅名順'],
                        (object) ['id' => 'distance', 'name' => '距離順'],
                    ]"
                    :value="request('sort', 'code')"
                    onchange="this.form.submit()"
                    />

                </div>
            </form>
        </div>


        

        {{-- 本体 --}}
        <x-tabs.index default="list">

            {{-- タブ切り替えボタン＋ 登録件数 --}}
            <div class="my-4 flex items-center border-b border-gray-300">
                <div class="flex-1">
                    <x-tabs.button name="list" label="一覧" />
                    <x-tabs.button name="map" label="マップ" />
                </div>
                <div>
                    <p class="text-md text-gray-600">
                        全 {{ $stations->total() }} 件
                    </p>
                </div>
            </div>
        
            <x-tabs.panel name="map">
                {{-- マップ表示 --}}
                <div id="station-map" class="aspect-square sm:aspect-video rounded-xl"></div>
                <script>
                    window.stations = {{ Js::from(
                    $mapStations->map(fn ($station) => [
                    'name' => $station->name,
                    'latitude' => $station->latitude,
                    'longitude' => $station->longitude,
                    'visited' => $station->visited,
                    ])
                    ) }};
                </script>
            </x-tabs.panel>

            <x-tabs.panel name="list">
                {{-- ページネーション --}}
                <div class="my-2">
                    {{ $stations->links() }}
                </div>
                {{-- カード一覧 --}}
                <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    @forelse ($stations as $station)
                        <x-station-card :station="$station" />
                    @empty
                        <p class="col-span-full py-12 text-center text-gray-500">
                            道の駅が登録されていません。
                        </p>
                    @endforelse
                </div>
            </x-tabs.panel>

        </x-tabs.index>

</x-layouts.app>
