<x-layouts.app title="道の駅一覧">

    {{-- ページタイトル --}}
    <x-page-header
        title="ダッシュボード"
        description="全国の道の駅や市町村の訪問状況を確認できます。"
    />

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

    {{-- 達成率 --}}
    <section class="flex flex-col aspect-video rounded-lg overflow-hidden border border-main bg-white">
        <h2 class="px-4 py-1 text-lg font-bold text-main bg-main-soft">来訪記録進捗率</h2>
        <div class="w-full h-full flex items-center justify-center">
            {{-- 道の駅の全体進捗 --}}
            <x-progress-circle
                :name="'道の駅'"
                :current="$visitedStations"
                :total="$totalStations"
                :type="'total'"
            />
            {{-- 市町村の全体進捗 --}}
            <x-progress-circle
                :name="'市町村'"
                :current="$visitedCities"
                :total="$totalCities"
                :type="'total'"
            />
        </div>
    </section>

    {{-- 直近の記録 --}}
    <section class="flex flex-col aspect-video rounded-lg overflow-hidden border border-main bg-white">
        <h2 class="px-4 py-1 text-lg font-bold text-main bg-main-soft">直近の来訪記録</h2>
        <div class="min-h-0 flex-1 overflow-y-auto">
        <div class="grid grid-cols-2 lg:grid-cols-3">
            @forelse ($visits as $visit)
                <x-visit-card :visit="$visit" />
            @empty
                <p class="col-span-full py-12 text-center text-gray-600">
                    この道の駅には訪問記録がありません
                </p>
            @endforelse
        </div>
        </div>
    </section>

    {{-- 都道府県別市町村ランキング --}}
    <section class="flex flex-col aspect-video rounded-lg overflow-hidden border border-main bg-white">
        <h2 class="shrink-0 px-4 py-1 text-lg font-bold text-main bg-main-soft">道の駅都道府県別ランキング</h2>
        <div class="min-h-0 flex-1 overflow-y-auto">

                {{-- 都道府県別 --}}
                <div class="px-4 py-2 flex flex-col gap-2">
                    @foreach ($stationRanking as $prefecture)
                        <x-progress-bar
                            :name="$prefecture->name"
                            :current="$prefecture->visited_stations_count"
                            :total="$prefecture->stations_count"
                        />
                    @endforeach
                </div>

        </div>
    </section>

    {{-- 都道府県別市町村ランキング --}}
    <section class="flex flex-col aspect-video rounded-lg overflow-hidden border border-main bg-white">
        <h2 class="shrink-0 px-4 py-1 text-lg font-bold text-main bg-main-soft">市町村都道府県別ランキング</h2>
        <div class="min-h-0 flex-1 overflow-y-auto">

                {{-- 都道府県別 --}}
                <div class="px-4 py-2 flex flex-col gap-2">
                    @foreach ($cityRanking as $prefecture)
                        <x-progress-bar
                            :name="$prefecture->name"
                            :current="$prefecture->visited_cities_count"
                            :total="$prefecture->cities_count"
                        />
                    @endforeach
                </div>

        </div>
    </section>

    </div>

    <section class="w-full mt-4 flex gap-2">
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-form.button type="submit">ログアウト</x-form.button>
            </form>
        @endauth
        <x-location-control/>
    </section>

    






</x-layouts.app>