<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Thin wrapper over the Places API (New).
 *
 * Calls are made server-side so the API key never reaches the browser. That
 * also means the key can be IP-restricted rather than left open.
 */
class GooglePlacesService
{
    private const AUTOCOMPLETE_URL = 'https://places.googleapis.com/v1/places:autocomplete';
    private const DETAILS_URL = 'https://places.googleapis.com/v1/places/';

    public function configured(): bool
    {
        return filled($this->key());
    }

    /**
     * Address suggestions for a partial query.
     *
     * @return array<int, array{place_id: string, primary: string, secondary: string}>
     */
    public function autocomplete(string $input, ?string $sessionToken = null, string $region = 'ph'): array
    {
        if (! $this->configured() || trim($input) === '') {
            return [];
        }

        $payload = array_filter([
            'input' => $input,
            'includedRegionCodes' => [$region],
            'sessionToken' => $sessionToken,
        ]);

        try {
            $response = Http::withHeaders([
                'X-Goog-Api-Key' => $this->key(),
            ])
                ->timeout(10)
                ->post(self::AUTOCOMPLETE_URL, $payload)
                ->throw()
                ->json();
        } catch (\Throwable $exception) {
            report($exception);

            return [];
        }

        return collect($response['suggestions'] ?? [])
            ->pluck('placePrediction')
            ->filter()
            ->map(fn (array $prediction) => [
                'place_id' => $prediction['placeId'] ?? '',
                'primary' => data_get($prediction, 'structuredFormat.mainText.text', ''),
                'secondary' => data_get($prediction, 'structuredFormat.secondaryText.text', ''),
            ])
            ->filter(fn (array $row) => $row['place_id'] !== '')
            ->values()
            ->all();
    }

    /**
     * Resolve a place id into the individual address fields the form needs.
     *
     * @return array<string, mixed>|null
     */
    public function details(string $placeId, ?string $sessionToken = null): ?array
    {
        if (! $this->configured() || $placeId === '') {
            return null;
        }

        try {
            $place = Http::withHeaders([
                'X-Goog-Api-Key' => $this->key(),
                'X-Goog-FieldMask' => 'id,formattedAddress,shortFormattedAddress,location,addressComponents',
            ])
                ->timeout(10)
                ->get(self::DETAILS_URL.$placeId, array_filter(['sessionToken' => $sessionToken]))
                ->throw()
                ->json();
        } catch (\Throwable $exception) {
            report($exception);

            return null;
        }

        $components = collect($place['addressComponents'] ?? []);

        // Pull the first component carrying any of the given types.
        $component = function (array $types, string $field = 'longText') use ($components) {
            return $components
                ->first(fn (array $item) => ! empty(array_intersect($types, $item['types'] ?? [])))[$field] ?? null;
        };

        $streetNumber = $component(['street_number']);
        $route = $component(['route']);

        // Google returns the full formatted address; the form wants just the
        // street line, so prefer street_number + route when both are present.
        $street = trim(implode(' ', array_filter([$streetNumber, $route])));

        return [
            'place_id' => $place['id'] ?? $placeId,
            'address' => $street !== '' ? $street : ($place['shortFormattedAddress'] ?? $place['formattedAddress'] ?? ''),
            'formatted_address' => $place['formattedAddress'] ?? '',
            // PH cities surface as locality; fall back through the admin levels.
            'city' => $component(['locality', 'administrative_area_level_3']),
            // In the Philippines level 2 is the province (Bulacan) and level 1
            // is the region (Central Luzon), so prefer level 2 here.
            'province' => $component(['administrative_area_level_2', 'administrative_area_level_1']),
            'postal_code' => $component(['postal_code']),
            'country' => $component(['country']),
            'latitude' => data_get($place, 'location.latitude'),
            'longitude' => data_get($place, 'location.longitude'),
        ];
    }

    private function key(): ?string
    {
        return config('services.google.places_api_key')
            ?: config('services.google.maps_api_key');
    }
}
