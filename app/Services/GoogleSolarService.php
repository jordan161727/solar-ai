<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleSolarService
{
    public function buildingInsights(float $latitude, float $longitude): ?array
    {
        $apiKey = config('services.google.solar_api_key');

        if (blank($apiKey)) {
            return null;
        }

        try {
            return Http::acceptJson()
                ->timeout(15)
                ->get('https://solar.googleapis.com/v1/buildingInsights:findClosest', [
                    'location.latitude' => $latitude,
                    'location.longitude' => $longitude,
                    // BASE provides the widest coverage. A 404 is handled by the caller.
                    'requiredQuality' => 'BASE',
                    'experiments' => 'EXPANDED_COVERAGE',
                    'key' => $apiKey,
                ])
                ->throw()
                ->json();
        } catch (\Throwable $exception) {
            report($exception);

            return null;
        }
    }
}
