<?php

namespace App\Services;

use App\Models\Property;
use App\Models\WeatherRecord;
use Illuminate\Support\Arr;

class PropertyInsightsService
{
    public function __construct(
        private GoogleSolarService $solar,
        private WeatherService $weather,
    ) {
    }

    public function refresh(Property $property): void
    {
        if ($property->latitude === null || $property->longitude === null) {
            return;
        }

        $latitude = (float) $property->latitude;
        $longitude = (float) $property->longitude;
        $solarData = $this->solar->buildingInsights($latitude, $longitude);
        $weather = $this->weather->current($latitude, $longitude);

        if ($weather !== null) {
            WeatherRecord::updateOrCreate(
                ['property_id' => $property->id, 'record_date' => today()],
                Arr::except($weather, [])
            );
        }

        if ($solarData === null) {
            $property->update(['status' => 'Analyzing']);
            return;
        }

        $potential = $solarData['solarPotential'] ?? [];
        $configuration = collect($potential['solarPanelConfigs'] ?? [])
            ->sortBy('panelsCount')
            ->last() ?? [];
        $segment = collect($potential['roofSegmentStats'] ?? [])
            ->sortByDesc(fn (array $item) => data_get($item, 'stats.areaMeters2', 0))
            ->first() ?? [];
        $sunshine = (float) ($potential['maxSunshineHoursPerYear'] ?? 0);

        $property->solarAssessment()->updateOrCreate([], [
            'solar_api_id' => $solarData['name'] ?? null,
            'roof_area' => data_get($potential, 'wholeRoofStats.areaMeters2') ?? data_get($potential, 'maxArrayAreaMeters2'),
            'roof_pitch' => data_get($segment, 'pitchDegrees'),
            'roof_orientation' => data_get($segment, 'azimuthDegrees'),
            'solar_score' => min(100, (int) round(($sunshine / (365 * 5.5)) * 100)),
            'max_panels' => $potential['maxArrayPanelsCount'] ?? data_get($configuration, 'panelsCount', 0),
            'system_size_kw' => round(((float) data_get($configuration, 'panelsCount', 0) * 0.45), 2),
            'annual_generation' => data_get($configuration, 'yearlyEnergyDcKwh', 0),
            'monthly_generation' => round(((float) data_get($configuration, 'yearlyEnergyDcKwh', 0)) / 12, 2),
            'estimated_savings' => 0,
            'co2_offset' => 0,
            'last_synced_at' => now(),
        ]);

        $property->update(['status' => 'Completed']);
    }
}
