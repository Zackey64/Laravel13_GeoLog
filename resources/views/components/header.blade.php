<header class="sticky top-0 z-1000 border-b border-gray-200 bg-white/95">
    <div class="mx-auto flex p-2 max-w-7xl items-center justify-between">

        {{-- ロゴ --}}
        <a href="{{ route('stations.index') }}"
            class="text-2xl font-extrabold tracking-tight text-blue-600">
            GeoLog
        </a>

        {{-- ナビゲーション --}}
        <nav class="flex items-center">

            <a href="{{ route('stations.index') }}"
                @class([
                    'rounded-l-lg px-4 py-2 text-sm font-bold',
                    'text-white  bg-blue-600' => request()->routeIs('stations.index'),
                    'text-gray-600 border border-gray-300' => !request()->routeIs('stations.index')
                ])
                >
                道の駅
            </a>
            <a href="{{ route('cities.index') }}"
                @class([
                    'rounded-r-lg px-4 py-2 text-sm font-bold',
                    'text-white bg-blue-600' => request()->routeIs('cities.index'),
                    'text-gray-600 border border-gray-300' => !request()->routeIs('cities.index')
                ])>
                市町村
            </a>
        </nav>

    </div>
</header>