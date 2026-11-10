<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityIndexRequest;
use App\Models\City;
use App\Models\Prefecture;
use App\Models\Visit;
use App\Services\CityDistanceService;
use App\Services\StationDistanceService;
use Illuminate\View\View;

class CityController extends Controller
{
    public function index(CityIndexRequest $request): View
    {
        $filters = $request->validated();
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

        $prefectures = Prefecture::orderBy('code')->get();

        return view('cities.index', compact('cities', 'prefectures', 'mapCities'));
    }

    public function show(
        City $city,
        CityDistanceService $cityDistanceService,
        StationDistanceService $stationDistanceService,
    ): View {

        // 市町村を取得
        $city->load('prefecture');
        // 道の駅を取得
        $stations = $city->stations;

        // 市町村の訪問履歴
        $visits = $city->visits()->with('station')->get();
        // 道の駅の訪問履歴
        $stationVisits = Visit::query()->with('station')
            ->whereIn('station_id', $city->stations()->select('id'))->get();
        // 結合
        $visits = $visits->concat($stationVisits)->sortByDesc('visited_at')->values();

        // 付近の道の駅（最大10件）を取得
        $nearbyStations = $stationDistanceService->getStations(
            $city->latitude,
            $city->longitude,
            20000,
        )->reject(fn ($station) => $city->stations->pluck('id')->contains($station->id))->take(10); // 市町村の道の駅を除外する

        // 付近の市町村（最大10件）を取得
        $nearbyCities = $cityDistanceService->getCities(
            $city->latitude,
            $city->longitude,
            20000,
        )->reject(fn ($nearbyCity) => $nearbyCity->id === $city->id)->take(10); // 付近の市町村なので除外する

        return view('cities.show', compact('city', 'stations', 'visits', 'nearbyCities', 'nearbyStations'));
    }
}
