
<x-layouts.app>
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- ページタイトル --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                道の駅一覧
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                全国の道の駅を確認できます。
            </p>
        </div>


        {{-- 地図 --}}
        <div id="station-map" class="mb-8 h-[500px] rounded-xl"></div>
        <script>
            window.stations = {{ Js::from(
                $stations->getCollection()->map(fn ($station) => [
                    'id' => $station->id,
                    'name' => $station->name,
                    'latitude' => $station->latitude,
                    'longitude' => $station->longitude,
                ])
            ) }};
        </script>

        {{-- 都道府県フィルター --}}
        <form method="GET" action="{{ route('stations.index') }}" class="mb-6">
            <select
                name="prefecture"
                onchange="this.form.submit()"
                class="rounded-lg border-gray-300"
            >
                <option value="">すべての都道府県</option>
                @foreach ($prefectures as $prefecture)
                    <option
                        value="{{ $prefecture->id }}"
                        @selected(request('prefecture') == $prefecture->id)
                    >
                        {{ $prefecture->name }}
                    </option>
                @endforeach
            </select>
        </form>

        {{-- 登録件数 --}}
        <div class="mb-6 flex items-center justify-between">
            <p class="text-sm text-gray-600">
                全 {{ $stations->total() }} 件
            </p>
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

        {{-- ページネーション --}}
        <div class="mt-8">
            {{ $stations->links() }}
        </div>

    </div>
</x-layouts.app>
