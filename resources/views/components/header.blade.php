<header class="sticky top-0 z-1000 border-b border-gray-200 bg-white/90">
    <div class="mx-auto flex p-4 max-w-7xl items-center justify-between">

        {{-- ロゴ --}}
        <a href="{{ route('stations.index') }}"
            class="text-3xl font-bold tracking-tight text-blue-600">
            GeoLog
        </a>

        {{-- ナビゲーション --}}
        <nav class="flex items-center gap-4">

            <a href="{{ route('stations.index') }}"
                class="rounded-lg px-4 py-1 text-md text-white font-bold transition bg-blue-600 hover:bg-gray-300"
                >
                道の駅
            </a>
            <a href="{{ route('cities.index') }}"
                class="rounded-lg px-4 py-1 text-md text-white font-bold transition bg-blue-600 hover:bg-gray-300">
                市町村
            </a>
        </nav>

    </div>
</header>