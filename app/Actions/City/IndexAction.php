<?php

namespace App\Actions\City;

use App\Models\City;

class IndexAction
{
    public function execute(
        array $filters,
    ): array {
        // クエリビルダーを初期化
        $query = City::query()->with('prefecture')
            ->join('prefectures', 'cities.prefecture_id', '=', 'prefectures.id')
            ->select('cities.*');

        // キーワード検索
        if (! empty($filters['keyword'])) {
            $query->where('cities.name', 'like', '%'.$filters['keyword'].'%');
        }
        // 都道府県
        if (! empty($filters['prefecture_id'])) {
            $query->where('cities.prefecture_id', $filters['prefecture_id']);
        }
        // 来訪記録
        match ($filters['visited_status'] ?? null) {
            'visited' => $query->visited(),
            'not_visited' => $query->notVisited(),
            default => null,
        };
        // 並び替え
        match ($filters['sort'] ?? 'code') {
            'name' => $query->orderBy('cities.kana'),
            default => $query->orderBy('prefectures.code')->orderBy('cities.code'),
        };

        // 一覧用：ページネーションあり
        $cities = (clone $query)->paginate(40)->withQueryString();
        // 地図用：ページネーションなし
        $mapCities = (clone $query)->get();

        return [
            'cities' => $cities,
            'mapCities' => $mapCities,
        ];
    }
}
