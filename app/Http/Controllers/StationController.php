<?php

namespace App\Http\Controllers;

use App\Http\Requests\StationIndexRequest;
use App\Models\Prefecture;
use App\Models\Station;
use App\Services\CityDistanceService;
use App\Services\StationDistanceService;
use Illuminate\View\View;

class StationController extends Controller
{
    public function index(StationIndexRequest $request): View
    {
        $filters = $request->validated();
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
            default => $query->orderBy('prefectures.code')->orderBy('stations.code'),
        };

        // 一覧用：ページネーションあり
        $stations = (clone $query)->paginate(40)->withQueryString();
        // 地図用：ページネーションなし
        $mapStations = (clone $query)->get();

        $prefectures = Prefecture::orderBy('code')->get();

        return view('stations.index', compact('stations', 'prefectures', 'mapStations'));
    }

    public function show(
        Station $station,
        CityDistanceService $cityDistanceService,
        StationDistanceService $stationDistanceService,
    ): View {
        $station->load('city.prefecture');
        $visits = $station->visits;

        // 付近の道の駅（最大５件）を取得
        $nearbyStations = $stationDistanceService->getStations(
            $station->latitude,
            $station->longitude,
            50000,
        )->reject(fn ($nearbyStation) => $nearbyStation->id === $station->id)->take(5);

        // 付近の市町村（最大５件）を取得
        $nearbyCities = $cityDistanceService->getCities(
            $station->latitude,
            $station->longitude,
            50000,
        )->reject(fn ($nearbyCity) => $nearbyCity->id === $station->city->id)->take(5);

        return view('stations.show', compact('station', 'visits', 'nearbyCities', 'nearbyStations'));
    }
}
