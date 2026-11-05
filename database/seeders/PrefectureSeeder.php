<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PrefectureSeeder extends Seeder
{
    public function run(): void
    {
        // CSVファイルのパスを指定
        $path = database_path('seeders/data/prefectures.csv');
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

        $prefectures = [];
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

            // 都道府県データを配列に追加
            $prefectures[] = [
                'code_number' => (int) $data['code_number'],
                'name' => $data['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // 都道府県データをDBに挿入
        DB::table('prefectures')->upsert(
            $prefectures,
            ['code_number'],
            ['name', 'updated_at']
        );
    }
}
