<?php

namespace App\Actions\Station;

use App\Models\Station;
use App\Services\StationDistanceService;

class IndexAction
{
    public function __construct(
        private StationDistanceService $stationDistanceService,
    ) {}

    public function execute(
        array $filters,
    ): array {
        // クエリビルダーを初期化
        $query = Station::query()->with('city.prefecture')->ordered()->reorder();

        // キーワード検索
        if (! empty($filters['keyword'])) {
            $query->where('stations.name', 'like', "%{$filters['keyword']}%");
        }
        // 都道府県
        if (! empty($filters['prefecture_id'])) {
            $query->where('prefectures.id', $filters['prefecture_id']);
        }
        // 来訪記録
        match ($filters['visited_status'] ?? null) {
            'visited' => $query->visited(),
            'not_visited' => $query->notVisited(),
            default => null,
        };
        // 並び替え
        match ($filters['sort'] ?? 'code') {
            'name' => $query->orderBy('stations.name'),
            'distance' => $query = $this->stationDistanceService->orderByDistance(
                $query,
                (float) $filters['latitude'],
                (float) $filters['longitude'],
            ),
            default => $query->orderBy('prefectures.code')->orderBy('stations.code'),
        };

        // 一覧用：ページネーションあり
        $stations = (clone $query)->paginate(40)->withQueryString();
        // 地図用：ページネーションなし
        $mapStations = (clone $query)->get();

        return [
            'stations' => $stations,
            'mapStations' => $mapStations,
        ];
    }
}
