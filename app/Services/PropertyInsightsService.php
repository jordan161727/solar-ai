<?php

namespace App\Services;

use App\Models\Property;
use App\Models\WeatherRecord;
use Illuminate\Support\Arr;

class PropertyInsightsService
{
    /** Meralco residential rate, PHP per kWh. */
    public const TARIFF_PER_KWH = 12.0;

    /** PH grid emission factor, kg CO2 per kWh displaced. */
    public const CO2_KG_PER_KWH = 0.7;

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

        $panelWatts = (float) ($potential['panelCapacityWatts'] ?? 400);
        $maxPanels = (int) ($potential['maxArrayPanelsCount'] ?? data_get($configuration, 'panelsCount', 0));
        $annualKwh = (float) data_get($configuration, 'yearlyEnergyDcKwh', 0);

        $imageryDate = $solarData['imageryDate'] ?? null;

        $property->solarAssessment()->updateOrCreate([], [
            'solar_api_id' => $solarData['name'] ?? null,
            'roof_area' => data_get($potential, 'wholeRoofStats.areaMeters2') ?? data_get($potential, 'maxArrayAreaMeters2'),
            'roof_pitch' => data_get($segment, 'pitchDegrees'),
            'roof_orientation' => data_get($segment, 'azimuthDegrees'),
            'solar_score' => min(100, (int) round(($sunshine / (365 * 5.5)) * 100)),
            'max_panels' => $maxPanels,
            'system_size_kw' => round($maxPanels * $panelWatts / 1000, 2),
            'annual_generation' => $annualKwh,
            'monthly_generation' => round($annualKwh / 12, 2),
            'estimated_savings' => round($annualKwh * self::TARIFF_PER_KWH, 2),
            'co2_offset' => round($annualKwh * self::CO2_KG_PER_KWH, 2),
            'last_synced_at' => now(),

            // Panel geometry for the solar designer.
            'panel_layout' => $potential['solarPanels'] ?? [],
            'roof_segments' => $potential['roofSegmentStats'] ?? [],
            'panel_configs' => $potential['solarPanelConfigs'] ?? [],
            'panel_width_m' => $potential['panelWidthMeters'] ?? null,
            'panel_height_m' => $potential['panelHeightMeters'] ?? null,
            'panel_capacity_w' => $panelWatts,
            'selected_panel_count' => $maxPanels,
            'imagery_quality' => $solarData['imageryQuality'] ?? null,
            'imagery_date' => $imageryDate
                ? sprintf('%04d-%02d-%02d', $imageryDate['year'] ?? 2000, $imageryDate['month'] ?? 1, $imageryDate['day'] ?? 1)
                : null,
        ]);

        $property->update(['status' => 'Completed']);
    }
}
