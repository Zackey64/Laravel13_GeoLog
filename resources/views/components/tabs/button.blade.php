@props(['name', 'label'])

<button
    type="button"
    @click="
        tab = '{{ $name }}';
        if (tab === 'map') {
            $nextTick(() => {
                window.initializeStationMap?.();
                window.initializeCityMap?.();

                window.stationMap?.invalidateSize();
                window.cityMap?.invalidateSize();
            });
        }
    "
    :class="tab === '{{ $name }}'
        ? 'border-main text-main'
        : 'border-transparent text-gray-600'"
    class="border-b-4 px-6 py-1 text-base font-bold hover:bg-gray-50"
>
    {{ $label }}
</button>