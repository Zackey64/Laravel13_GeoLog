<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Services\GeocodingService;
use Illuminate\Console\Command;

class FetchCityCoordinates extends Command
{
    protected $signature = 'cities:fetch-coordinates';

    protected $description = '市区町村の座標を取得する';

    public function handle(GeocodingService $geocodingService): int
    {
        $cities = City::query()
            ->with('prefecture')
            ->where(function ($query) {
                $query->whereNull('latitude')
                    ->orWhereNull('longitude');
            })
            ->get();

        if ($cities->isEmpty()) {
            $this->info('座標未取得の市区町村はありません。');

            return self::SUCCESS;
        }

        foreach ($cities as $city) {
            $this->info("取得中: {$city->name}");

            $coordinates = $geocodingService->getCoordinates(
                $city->prefecture->name.$city->name
            );

            if ($coordinates === null) {
                $this->warn("失敗: {$city->name}");

                continue;
            }

            $city->update($coordinates);

            $this->info(
                "成功: {$city->name} ({$coordinates['latitude']}, {$coordinates['longitude']})"
            );
        }

        $this->info('座標取得処理が完了しました。');

        return self::SUCCESS;
    }
}
