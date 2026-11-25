<?php

namespace App\Console\Commands;

use App\Models\Station;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class FetchStationImages extends Command
{
    protected $signature = 'stations:fetch-images
        {--refresh : 画像URLが登録済みの道の駅も再取得する}';

    protected $description = '公式ページから道の駅の画像URLを取得する';

    public function handle(): int
    {
        $stations = Station::query()
            ->whereNotNull('official_url')
            ->when(! $this->option('refresh'), function ($query) {
                $query->where(function ($query) {
                    $query->whereNull('image_path')
                        ->orWhere('image_path', 'like', 'stations/%');
                });
            })
            ->lazyById();

        $failed = false;

        foreach ($stations as $station) {
            try {
                $this->fetchImage($station);
            } catch (Throwable $e) {
                $failed = true;
                $this->warn("失敗: {$station->name} - {$e->getMessage()}");
            }
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }

    private function fetchImage(Station $station): void
    {
        $response = Http::timeout(15)
            ->get($station->official_url)
            ->throw();

        $dom = new DOMDocument;
        $previous = libxml_use_internal_errors(true);

        try {
            if (! $dom->loadHTML($response->body())) {
                throw new RuntimeException('公式ページのHTMLを解析できませんでした。');
            }
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }

        $xpath = new DOMXPath($dom);
        $baseUrl = new Uri($station->official_url);

        foreach ($xpath->query('//img[@src]') as $image) {
            $src = trim($image->getAttribute('src'));

            if ($src === '') {
                continue;
            }

            $url = UriResolver::resolve($baseUrl, new Uri($src));
            $path = strtolower($url->getPath());
            $extension = pathinfo($path, PATHINFO_EXTENSION);

            if (! in_array($url->getScheme(), ['http', 'https'], true)
                || $url->getHost() === ''
                || ! in_array($extension, ['png', 'jpg', 'jpeg'], true)
                || str_contains($path, '/image/')
                || str_contains($path, '/root/')
                || ! str_contains(strtolower((string) $url), 'kobetu')) {
                continue;
            }

            $station->update(['image_path' => (string) $url]);

            $this->info("取得成功: {$station->name} ({$url})");

            return;
        }

        $this->warn("画像なし: {$station->name}");
    }
}