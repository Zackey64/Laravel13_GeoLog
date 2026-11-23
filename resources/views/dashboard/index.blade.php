
<x-layouts.app title="ダッシュボード">
    <div>

        {{-- ページタイトル --}}
        <x-page-header
            title="ダッシュボード"
            description="全国の道の駅や市区町村の訪問状況を確認できます。"
        />


{{-- 道の駅 --}}
<x-progress-bar
    :total="$stationTotal"
    :visited="$stationVisited"
/>

{{-- 市区町村 --}}
<x-progress-bar
    :total="$cityTotal"
    :visited="$cityVisited"
/>


    </div>
</x-layouts.app>