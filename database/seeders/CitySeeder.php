<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        // CSVファイルのパスを指定
        $path = database_path('seeders/data/cities.csv');
        // CSVファイルを開く
        $handle = fopen($path, 'r');

        // ヘッダーを読み飛ばす
        fgetcsv($handle, 0, ',', '"', '');

        // 都道府県データを取得
        $prefectures = DB::table('prefectures')->pluck('id', 'code');

        $cities = [];
        while (($row = fgetcsv($handle, 0, ',', '"', '')) !== false) {
            [$prefecture_code, $name, $kana, $code] = $row;

            $cities[] = [
                'prefecture_id' => $prefectures[$prefecture_code],
                'name' => $name,
                'kana' => $kana,
                'code' => $code,
            ];
        }

        // CSVファイルを閉じる
        fclose($handle);

        // 都市データをDBに挿入
        DB::table('cities')->upsert(
            $cities,
            ['code'],
            ['prefecture_id', 'name', 'kana']
        );

    }
}
