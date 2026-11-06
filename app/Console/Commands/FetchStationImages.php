<?php

namespace App\Console\Commands;

use App\Models\Station;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FetchStationImages extends Command
{
    protected $signature = 'stations:fetch-images';

    protected $description = '公式ページから道の駅の画像を取得する';

    public function handle()
    {
        $stations = Station::query()->whereNotNull('official_url')
            ->whereNull('image_path')->get();

        foreach ($stations as $station) {
            try {
                $this->fetchImage($station);
            } catch (\Throwable $e) {
                $this->warn("失敗: {$station->name} - {$e->getMessage()}");
            }
        }

        return self::SUCCESS;
    }

    private function fetchImage(Station $station): void
    {
        // 公式ページを取得
        $response = Http::timeout(15)->get($station->official_url);
        $response->throw();

        // HTMLを解析
        $dom = new DOMDocument;

        libxml_use_internal_errors(true);
        $dom->loadHTML($response->body());
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        // src属性を持つ画像を取得
        $images = $xpath->query('//img[@src]');

        $imageUrl = null;
        $extension = null;

        // 画像のURLを取得（最初に見つかった有効な画像）
        foreach ($images as $image) {
            $src = trim($image->getAttribute('src'));

            if ($src === '') {
                continue;
            }

            // jpg / jpeg 以外は除外
            $extension = strtolower(
                pathinfo(parse_url($src, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION)
            );

            if (! in_array($extension, ['png', 'jpg', 'jpeg'], true)) {
                continue;
            }

            $url = $this->resolveUrl($station->official_url, $src);

            // image ディレクトリ配下は除外
            if (str_contains(strtolower($url), '/image/')) {
                continue;
            }

            // root ディレクトリ配下は除外
            if (str_contains(strtolower($url), '/root/')) {
                continue;
            }
            // kobetu を含まない画像は除外
            if (! str_contains(strtolower($url), 'kobetu')) {
                continue;
            }

            if (! in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'], true)
                || ! parse_url($url, PHP_URL_HOST)) {
                continue;
            }

            $imageUrl = $url;

            break;
        }

        if (! $imageUrl) {
            $this->warn("画像なし: {$station->name}");

            return;
        }

        // 画像をダウンロード
        $imageResponse = Http::timeout(15)->get($imageUrl);
        $imageResponse->throw();

        // 保存
        $path = 'stations/'.$station->id.'.'.$extension;

        Storage::disk('public')->put(
            $path,
            $imageResponse->body()
        );

        $station->update([
            'image_path' => $path,
        ]);

        $this->info("取得成功: {$station->name} ({$imageUrl})");
    }

    private function resolveUrl(string $baseUrl, string $imageUrl): string
    {
        return (string) UriResolver::resolve(
            new Uri($baseUrl),
            new Uri($imageUrl)
        );
    }
}
