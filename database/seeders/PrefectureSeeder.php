<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrefectureSeeder extends Seeder
{
    public function run(): void
    {
        // CSVファイルのパスを指定
        $path = database_path('seeders/data/prefectures.csv');
        // CSVファイルを開く
        $handle = fopen($path, 'r');

        // ヘッダーを読み飛ばす
        fgetcsv($handle, 0, ',', '"', '');

        $prefectures = [];

        while (($row = fgetcsv($handle, 0, ',', '"', '')) !== false) {
            [$code, $name] = $row;

            $prefectures[] = [
                'code' => $code,
                'name' => $name,
            ];
        }

        // CSVファイルを閉じる
        fclose($handle);

        // 都道府県データをDBに挿入
        DB::table('prefectures')->upsert(
            $prefectures,
            ['code'],
            ['name']
        );
    }
}
