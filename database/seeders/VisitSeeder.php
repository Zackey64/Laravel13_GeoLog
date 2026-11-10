<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Station;
use App\Models\Visit;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    public function run(): void
    {
        // 市町村への訪問
        $cities = City::inRandomOrder()->take(50)->get();
        foreach ($cities as $city) {
            Visit::create([
                'city_id' => $city->id,
                'context' => '市町村訪問',
            ]);
        }

        // 道の駅への訪問
        $stations = Station::inRandomOrder()->take(50)->get();
        foreach ($stations as $station) {
            Visit::create([
                'station_id' => $station->id,
                'context' => '道の駅訪問',
            ]);
        }
    }
}
