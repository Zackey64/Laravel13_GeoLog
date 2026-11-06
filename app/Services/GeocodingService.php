<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeocodingService
{
    public function getCoordinates(string $address): ?array
    {
        $response = Http::get(
            'https://maps.googleapis.com/maps/api/geocode/json',
            [
                'address' => $address,
                'key' => config('services.google_maps.key'),
                'language' => 'ja',
                'region' => 'jp',
            ]
        );

        $response->throw();

        $data = $response->json();

        if ($data['status'] !== 'OK') {
            logger()->warning('Geocoding失敗', [
                'address' => $address,
                'status' => $data['status'],
            ]);

            return null;
        }

        $location = $data['results'][0]['geometry']['location'];

        return [
            'latitude' => $location['lat'],
            'longitude' => $location['lng'],
        ];
    }
}
