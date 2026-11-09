@props([
    'stations' => collect(),
    'cities' => collect(),
])

<div class="grid gap-8 grid-cols-1 sm:grid-cols-2">
    {{-- 付近の道の駅 --}}
    <div>
        <h2 class="py-2 text-lg font-bold border-b border-blue-600">付近の道の駅</h2>

        @forelse ($stations as $station)
            <a
                href="{{ route('stations.show', $station) }}"
                class="flex justify-between items-center py-2 border-b border-gray-200 hover:bg-gray-50"
            >
                <span>{{ $station->name }}</span>
                <span class="text-sm text-gray-500">
                    {{ number_format($station->distance / 1000, 1) }} km
                </span>
            </a>
        @empty
            <p class="py-2 text-sm text-gray-600">付近に道の駅はありません。</p>
        @endforelse
    </div>

    {{-- 付近の市町村 --}}
    <div>
        <h2 class="py-2 text-lg font-bold border-b border-blue-600">付近の市町村</h2>

        @forelse ($cities as $city)
            <a
                href="{{ route('cities.show', $city) }}"
                class="flex justify-between items-center py-2 border-b border-gray-200 hover:bg-gray-50"
            >
                <span>
                    {{ $city->prefecture->name }}{{ $city->name }}
                </span>
                <span class="text-sm text-gray-500">
                    {{ number_format($city->distance / 1000, 1) }} km
                </span>
            </a>
        @empty
            <p class="py-2 text-sm text-gray-600">付近に市町村はありません。</p>
        @endforelse
        </div>
</div>