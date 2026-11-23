<?php

namespace App\Services;

use App\Models\Station;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class StationDistanceService
{
    public function getStations(
        float $latitude,
        float $longitude,
        int $radius,
    ): Collection {

        // 駅を取得するクエリを作成
        $stations = Station::query()
            ->with('city.prefecture')
            ->selectRaw(
                'stations.*, ST_Distance_Sphere(
                    POINT(longitude, latitude),
                    POINT(?, ?)
                ) AS distance',
                [$longitude, $latitude]
            )
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        return $stations->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();
    }

    /*
     * 指定された緯度・経度からの距離で都市を並び替える
     */
    public function orderByDistance(
        Builder $query,
        float $latitude,
        float $longitude,
    ): Builder {
        return $query
            ->selectRaw(
                'ST_Distance_Sphere(
                POINT(stations.longitude, stations.latitude),
                POINT(?, ?)
            ) AS distance',
                [$longitude, $latitude]
            )
            ->whereNotNull('stations.latitude')
            ->whereNotNull('stations.longitude')
            ->orderBy('distance');
    }
}
