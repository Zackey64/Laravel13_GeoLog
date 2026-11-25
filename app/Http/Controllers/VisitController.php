<?php

namespace App\Http\Controllers;

use App\Http\Requests\Visit\IndexRequest;
use App\Http\Requests\Visit\StoreRequest;
use App\Http\Requests\Visit\UpdateRequest;
use App\Models\City;
use App\Models\Prefecture;
use App\Models\Station;
use App\Models\Visit;

class VisitController extends Controller
{
    public function index(IndexRequest $request)
    {
        $filters = $request->validated();

        $keyword = trim($filters['keyword'] ?? '');
        $prefectureId = $filters['prefecture_id'] ?? null;

        $query = Visit::query();

        if ($keyword !== '') {
            $query->where('context', 'like', '%'.$keyword.'%');
        }

        if ($prefectureId !== null) {
            $inPrefecture = fn ($city) => $city->where('prefecture_id', $prefectureId);

            $query->where(function ($visits) use ($inPrefecture) {
                $visits->whereHas('city', $inPrefecture)
                    ->orWhereHas('station.city', $inPrefecture);
            });
        }

        $visits = $query
            ->when(isset($filters['sort']), function ($query) use ($filters) {
                $query->orderByDesc($filters['sort']);
            }, function ($query) {
                $query->orderByDesc('updated_at');
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $stations = Station::all();
        $cities = City::all();
        $prefectures = Prefecture::orderBy('code')->get();

        return view('visits.index', compact(
            'visits', 'prefectures', 'stations', 'cities'
        ));
    }

    public function show(Visit $visit)
    {
        $stations = Station::all();
        $cities = City::all();

        return view('visits.show', compact('visit', 'stations', 'cities'));
    }

    public function create()
    {
        $stations = Station::all();
        $cities = City::all();

        return view('visits.create', compact('stations', 'cities'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $data['station_id'] = $data['station_id'] ?? null;
        $data['city_id'] = $data['city_id'] ?? null;

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('visits', 'public');
        }
        $visit = Visit::create($data);

        return redirect()->route('visits.index')
            ->with('status', '来訪記録を作成しました。');
    }

    public function update(UpdateRequest $request, Visit $visit)
    {
        $data = $request->validated();

        $data['station_id'] = $data['station_id'] ?? null;
        $data['city_id'] = $data['city_id'] ?? null;

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('visits', 'public');
        } else {
            unset($data['image_path']);
        }

        $visit->update($data);

        return redirect()->route('visits.index')
            ->with('status', '来訪記録を更新しました。');
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();

        return redirect()->route('visits.index')
            ->with('status', '来訪記録を削除しました。');
    }
}
