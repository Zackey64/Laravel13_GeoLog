
<x-layouts.app title="{{ $station->name }}">
    <div>
        
        {{-- ページタイトル --}}
        <x-page-header
            title="{{ $station->name }}"
            description="{{ $station->city->prefecture->name }} {{ $station->city->name }}"
        />
<x-back-button />

        {{-- コンテンツをここに追加 --}}
        {{-- 背景画像 --}}
        <div class="relative aspect-video w-full">
        @if ($station->image_path)
            <img
                src="{{ asset('storage/' . $station->image_path) }}"
                alt="{{ $station->name }}"
                class="absolute inset-0 h-full w-full object-cover"
            >
        @endif

        </div>
    </div>
</x-layouts.app>