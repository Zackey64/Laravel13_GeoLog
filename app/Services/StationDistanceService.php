<?php

namespace App\Services;

use App\Models\Station;
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
}
