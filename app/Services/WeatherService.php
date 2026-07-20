<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function current(float $latitude, float $longitude): ?array
    {
        try {
            $payload = Http::acceptJson()
                ->timeout(10)
                ->get('https://api.open-meteo.com/v1/forecast', [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'current' => 'temperature_2m,apparent_temperature,relative_humidity_2m,cloud_cover,wind_speed_10m',
                    'daily' => 'uv_index_max,sunshine_duration,shortwave_radiation_sum',
                    'timezone' => 'Asia/Manila',
                    'forecast_days' => 1,
                ])
                ->throw()
                ->json();
        } catch (\Throwable $exception) {
            report($exception);

            return null;
        }

        return [
            'temperature' => data_get($payload, 'current.temperature_2m'),
            'feels_like' => data_get($payload, 'current.apparent_temperature'),
            'humidity' => data_get($payload, 'current.relative_humidity_2m'),
            'cloud_cover' => data_get($payload, 'current.cloud_cover'),
            'wind_speed' => data_get($payload, 'current.wind_speed_10m'),
            'uv_index' => data_get($payload, 'daily.uv_index_max.0'),
            // Open-Meteo reports sunshine duration in seconds and radiation in MJ/m².
            'sun_hours' => ($seconds = data_get($payload, 'daily.sunshine_duration.0')) === null ? null : $seconds / 3600,
            'irradiance' => data_get($payload, 'daily.shortwave_radiation_sum.0'),
        ];
    }
}
