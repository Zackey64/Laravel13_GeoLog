<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityIndexRequest;
use App\Models\City;
use App\Models\Prefecture;
use Illuminate\View\View;

class CityController extends Controller
{
    public function index(CityIndexRequest $request): View
    {
        $filters = $request->validated();

        $query = City::query()->with('prefecture')
            ->join('prefectures', 'cities.prefecture_id', '=', 'prefectures.id')
            ->select('cities.*');

        if (! empty($filters['keyword'])) {
            $query->where('cities.kana', 'like', '%'.$filters['keyword'].'%');
        }

        if (! empty($filters['prefecture_id'])) {
            $query->where('cities.prefecture_id', $filters['prefecture_id']);
        }

        if (! empty($filters['sort'])) {
            $query->orderBy('cities.'.$filters['sort']);
        }

        // 一覧用：ページネーションあり
        $cities = (clone $query)->paginate(40)->withQueryString();
        // 地図用：ページネーションなし
        $mapCities = (clone $query)->get();

        $prefectures = Prefecture::orderBy('code')->get();

        return view('cities.index', compact('cities', 'prefectures', 'mapCities'));
    }

    public function show(City $city): View
    {
        return view('cities.show', compact('city'));
    }
}
