<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        // CSVファイルのパスを指定
        $path = database_path('seeders/data/cities.csv');
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

        $cities = [];
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

            // 都道府県IDを取得
            $prefectureId = DB::table('prefectures')
                ->where('code', $data['prefecture_code'])
                ->value('id');

            // 都道府県が見つからない場合は例外を投げる
            if (! $prefectureId) {
                throw new RuntimeException(
                    "Prefecture not found: {$data['prefecture_code']}"
                );
            }

            // 都市データを配列に追加
            $cities[] = [
                'prefecture_id' => $prefectureId,
                'code' => (int) $data['code'],
                'name' => $data['name'],
                'kana' => $data['kana'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // 都市データをDBに挿入（存在する場合は更新）
        DB::table('cities')->upsert(
            $cities,
            ['code'],
            ['prefecture_id', 'name', 'kana', 'updated_at']
        );

    }
}
