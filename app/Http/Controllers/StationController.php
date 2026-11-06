<?php

namespace App\Http\Controllers;

use App\Http\Requests\StationIndexRequest;
use App\Models\Prefecture;
use App\Models\Station;
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
        // 並び替え
        match ($filters['sort'] ?? 'code') {
            'name' => $query->orderBy('stations.name'),
            default => $query
                ->orderBy('prefectures.code')
                ->orderBy('stations.code'),
        };

        // 一覧用：ページネーションあり
        $stations = (clone $query)->paginate(40)->withQueryString();
        // 地図用：ページネーションなし
        $mapStations = (clone $query)->get();

        $prefectures = Prefecture::orderBy('code')->get();

        return view('stations.index', compact('stations', 'prefectures', 'mapStations'));
    }

    public function show(Station $station): View
    {
        $station->load('city.prefecture');

        return view('stations.show', compact('station'));
    }
}
