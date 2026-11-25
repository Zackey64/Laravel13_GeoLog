<header class="sticky top-0 z-1000 bg-main shadow-md">
    <div class="mx-auto flex p-2 max-w-7xl items-center justify-between">

        {{-- ロゴ --}}
        <a href="{{ route('dashboard.index') }}"
            class="flex items-center justify-center"
        >
            <span
                aria-hidden="true"
                class="inline-block h-9 w-40 bg-white "
                style="mask: url('{{ asset('images/logo.png') }}') left center / contain no-repeat;"
            ></span>
        </a>
        


        {{-- ナビゲーション --}}
        <nav class="flex items-center">
            <a href="{{ route('visits.index') }}"
                @class([
                    'mr-2 rounded-lg px-4 py-2 text-sm font-bold',
                    'text-main bg-main-soft' => request()->routeIs('visits.index'),
                    'text-gray-300 bg-white' => !request()->routeIs('visits.index')
                ])
                >
                記録
            </a>
            <a href="{{ route('stations.index') }}"
                @class([
                    'rounded-l-lg px-4 py-2 text-sm font-bold',
                    'text-main bg-main-soft border-r-2 border-main' => request()->routeIs('stations.index'),
                    'text-gray-300 bg-white' => !request()->routeIs('stations.index')
                ])
                >
                道の駅
            </a>
            <a href="{{ route('cities.index') }}"
                @class([
                    'rounded-r-lg px-4 py-2 text-sm font-bold',
                    'text-main bg-main-soft border-l-2 border-main' => request()->routeIs('cities.index'),
                    'text-gray-300 bg-white' => !request()->routeIs('cities.index')
                ])>
                市町村
            </a>
        </nav>

    </div>
</header>