<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class StationSeeder extends Seeder
{
    public function run(): void
    {
        // CSVファイルのパスを指定
        $path = database_path('seeders/data/stations.csv');
        if (! file_exists($path)) {
            throw new RuntimeException("CSV file not found: {$path}");
        }
        $file = new \SplFileObject($path);
        $file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $header = $file->fgetcsv();

        $stations = [];
        // 各行を処理
        foreach ($file as $row) {

            // 先頭または空行をスキップ
            if ($file->key() === 0 || $row === false || $row === [null]) {
                continue;
            }
            // ヘッダーと行のカラム数が一致しない場合は例外を投げる
            if (count($header) !== count($row)) {
                throw new RuntimeException('Invalid CSV format.');
            }

            $data = array_combine($header, $row);

            // 都市IDを取得
            $cityId = $this->resolveCityId($data['address']);

            // 都市が見つからない場合は例外を投げる
            if (! $cityId) {
                throw new RuntimeException(
                    "City not found: {$data['address']}"
                );
            }

            // 駅データを配列に追加
            $stations[] = [
                'city_id' => $cityId,
                'code_prefix' => $data['code_prefix'],
                'code_number' => (int) $data['code_number'],
                'name' => $data['name'],
                'address' => $data['address'],
                'opened_at' => $data['opened_at'] ?? null,
                'closed_at' => $data['closed_at'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

        }

        // 駅データをDBに挿入（存在する場合は更新）
        DB::table('stations')->upsert(
            $stations,
            ['code_prefix', 'code_number'],
            ['city_id', 'name', 'address', 'opened_at', 'closed_at', 'updated_at']
        );

    }

    // 住所から都市IDを解決するメソッド
    private function resolveCityId(string $address): int
    {

        $cities = DB::table('cities')
            ->join('prefectures', 'cities.prefecture_id', '=', 'prefectures.id')
            ->select(
                'cities.id',
                'cities.name',
                'prefectures.name as prefecture_name'
            )
            ->get();

        // 住所の先頭に都道府県名がある市町村に絞る
        $matches = $cities->filter(function ($city) use ($address) {
            return str_starts_with($address, $city->prefecture_name)
                && str_contains($address, $city->name);
        });

        // 市町村名が最も長く一致するものを採用
        $city = $matches->sortByDesc(
            fn ($city) => mb_strlen($city->name)
        )->first();

        if (! $city) {
            throw new RuntimeException("City not found: {$address}");
        }

        return $city->id;
    }
}
