<?php

namespace App\Console\Commands;

use App\Models\Station;
use App\Services\GeocodingService;
use Illuminate\Console\Command;

class FetchStationCoordinates extends Command
{
    protected $signature = 'stations:fetch-coordinates';

    protected $description = '道の駅の座標を取得する';

    public function handle(GeocodingService $geocodingService): int
    {
        $stations = Station::query()
            ->whereNull('latitude')
            ->orWhereNull('longitude')
            ->get();

        if ($stations->isEmpty()) {
            $this->info('座標未取得の道の駅はありません。');

            return self::SUCCESS;
        }

        foreach ($stations as $station) {
            $this->info("取得中: {$station->name}");

            $coordinates = $geocodingService->getCoordinates(
                $station->address
            );

            if ($coordinates === null) {
                $this->warn("失敗: {$station->name}");

                continue;
            }

            $station->update($coordinates);

            $this->info(
                "成功: {$station->name} ({$coordinates['latitude']}, {$coordinates['longitude']})"
            );
        }

        $this->info('座標取得処理が完了しました。');

        return self::SUCCESS;
    }
}
