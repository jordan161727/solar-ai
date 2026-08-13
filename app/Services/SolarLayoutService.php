<?php

namespace App\Services;

use App\Models\SolarAssessment;

/**
 * Projects the Solar API's panel positions onto a Static Maps image.
 *
 * Static Maps uses Web Mercator, so a lat/lng maps to a world pixel at a given
 * zoom and the on-screen position is the offset from the world pixel of the
 * image centre.
 *
 * Note on `scale`: Static Maps returns `size * scale` real pixels covering the
 * same ground area, so requesting scale=2 doubles the effective resolution.
 * All geometry here is expressed in *displayed* pixels, which is why the
 * effective zoom is `zoom + log2(scale)`.
 */
class SolarLayoutService
{
    /** Web Mercator tile size in CSS pixels. */
    private const TILE_SIZE = 256;

    /** Metres per pixel at zoom 0 on the equator. */
    private const EQUATOR_METERS_PER_PIXEL = 156543.03392;

    /** Google's satellite imagery generally stops here. */
    private const MAX_ZOOM = 21;

    private const MIN_ZOOM = 17;

    /** Static Maps caps the requested size at 640 per side. */
    private const MAX_REQUEST_SIZE = 640;

    /**
     * Build everything the designer view needs.
     *
     * @return array<string, mixed>
     */
    public function forAssessment(
        SolarAssessment $assessment,
        float $propertyLat,
        float $propertyLng,
        int $viewportWidth = 800,
        int $viewportHeight = 500,
        int $scale = 2,
    ): array {
        $panels = $assessment->panel_layout ?? [];
        $segments = $assessment->roof_segments ?? [];

        $panelWidthM = (float) ($assessment->panel_width_m ?: 1.045);
        $panelHeightM = (float) ($assessment->panel_height_m ?: 1.879);

        // Centre on the array so the roof sits in the middle of the frame.
        [$centerLat, $centerLng] = $this->arrayCenter($panels, $propertyLat, $propertyLng);

        $zoom = $this->bestZoom(
            $panels,
            $centerLat,
            $viewportWidth,
            $viewportHeight,
            max($panelWidthM, $panelHeightM),
            $scale,
        );

        // Effective zoom accounts for the retina scale factor.
        $effectiveZoom = $zoom + (int) round(log($scale, 2));
        $metersPerPixel = $this->metersPerPixel($centerLat, $effectiveZoom);

        [$centerX, $centerY] = $this->worldPixel($centerLat, $centerLng, $effectiveZoom);

        $projected = [];

        foreach ($panels as $index => $panel) {
            $lat = data_get($panel, 'center.latitude');
            $lng = data_get($panel, 'center.longitude');

            if ($lat === null || $lng === null) {
                continue;
            }

            [$x, $y] = $this->worldPixel((float) $lat, (float) $lng, $effectiveZoom);

            $segmentIndex = (int) ($panel['segmentIndex'] ?? 0);
            $azimuth = (float) data_get($segments, $segmentIndex.'.azimuthDegrees', 0);

            // A portrait panel is the landscape rectangle turned a quarter turn.
            $orientation = ($panel['orientation'] ?? 'LANDSCAPE') === 'PORTRAIT' ? 90 : 0;

            $projected[] = [
                'index' => $index,
                'x' => round($x - $centerX + $viewportWidth / 2, 2),
                'y' => round($y - $centerY + $viewportHeight / 2, 2),
                'rotation' => round($azimuth + $orientation, 2),
                'segment' => $segmentIndex,
                'yearly_kwh' => round((float) ($panel['yearlyEnergyDcKwh'] ?? 0), 1),
            ];
        }

        // Static Maps takes the pre-scale size, capped at 640 per side.
        $requestWidth = min((int) round($viewportWidth / $scale), self::MAX_REQUEST_SIZE);
        $requestHeight = min((int) round($viewportHeight / $scale), self::MAX_REQUEST_SIZE);

        return [
            'panels' => $projected,
            'panel_width_px' => round($panelWidthM / $metersPerPixel, 2),
            'panel_height_px' => round($panelHeightM / $metersPerPixel, 2),
            'meters_per_pixel' => round($metersPerPixel, 5),
            'width' => $viewportWidth,
            'height' => $viewportHeight,
            'zoom' => $zoom,
            'scale' => $scale,
            'center_lat' => round($centerLat, 7),
            'center_lng' => round($centerLng, 7),
            'request_width' => $requestWidth,
            'request_height' => $requestHeight,
            // Metre marker for the scale bar.
            'scale_bar_px' => round(5 / $metersPerPixel, 1),
        ];
    }

    /**
     * Centroid of the panel array, falling back to the property pin.
     *
     * @param  array<int, array<string, mixed>>  $panels
     * @return array{0: float, 1: float}
     */
    public function arrayCenter(array $panels, float $fallbackLat, float $fallbackLng): array
    {
        $lats = array_filter(array_map(fn ($p) => data_get($p, 'center.latitude'), $panels));
        $lngs = array_filter(array_map(fn ($p) => data_get($p, 'center.longitude'), $panels));

        if ($lats === [] || $lngs === []) {
            return [$fallbackLat, $fallbackLng];
        }

        // Midpoint of the bounding box, not the mean, so a dense cluster on one
        // segment does not drag the frame off the rest of the roof.
        return [
            (min($lats) + max($lats)) / 2,
            (min($lngs) + max($lngs)) / 2,
        ];
    }

    /**
     * Highest zoom at which the whole array still fits the viewport.
     *
     * @param  array<int, array<string, mixed>>  $panels
     */
    public function bestZoom(
        array $panels,
        float $centerLat,
        int $viewportWidth,
        int $viewportHeight,
        float $panelLongestSideM,
        int $scale,
    ): int {
        $spanX = $this->spanMeters($panels, 'longitude', $centerLat);
        $spanY = $this->spanMeters($panels, 'latitude', $centerLat);

        if ($spanX <= 0 && $spanY <= 0) {
            return 20;
        }

        // Pad by a panel on each side plus 25% breathing room.
        $spanX = ($spanX + $panelLongestSideM * 2) * 1.25;
        $spanY = ($spanY + $panelLongestSideM * 2) * 1.25;

        $requiredMpp = max($spanX / $viewportWidth, $spanY / $viewportHeight);

        // Solve metersPerPixel(zoom) <= requiredMpp for the effective zoom.
        $effective = log(
            self::EQUATOR_METERS_PER_PIXEL * cos(deg2rad($centerLat)) / $requiredMpp,
            2
        );

        $zoom = (int) floor($effective) - (int) round(log($scale, 2));

        return max(self::MIN_ZOOM, min(self::MAX_ZOOM, $zoom));
    }

    /**
     * Ground span of the array along one axis, in metres.
     *
     * @param  array<int, array<string, mixed>>  $panels
     */
    private function spanMeters(array $panels, string $axis, float $centerLat): float
    {
        $values = array_filter(array_map(
            fn ($p) => data_get($p, 'center.'.$axis),
            $panels
        ));

        if (count($values) < 2) {
            return 0.0;
        }

        $degrees = max($values) - min($values);

        // ~111,320 m per degree of latitude; longitude shrinks with latitude.
        return $axis === 'latitude'
            ? $degrees * 111320.0
            : $degrees * 111320.0 * cos(deg2rad($centerLat));
    }

    /**
     * Ground resolution at a latitude, in metres per pixel.
     */
    public function metersPerPixel(float $latitude, int $zoom): float
    {
        return self::EQUATOR_METERS_PER_PIXEL
            * cos(deg2rad($latitude))
            / (2 ** $zoom);
    }

    /**
     * Web Mercator world pixel coordinates for a lat/lng at a zoom level.
     *
     * @return array{0: float, 1: float}
     */
    public function worldPixel(float $latitude, float $longitude, int $zoom): array
    {
        $scale = self::TILE_SIZE * (2 ** $zoom);

        $x = ($longitude + 180) / 360 * $scale;

        // Clamp near the poles so the log stays finite.
        $sinLat = sin(deg2rad(max(min($latitude, 89.9999), -89.9999)));
        $y = (0.5 - log((1 + $sinLat) / (1 - $sinLat)) / (4 * M_PI)) * $scale;

        return [$x, $y];
    }

    /**
     * Spread an annual figure across the year using a clear-sky seasonal
     * profile for northern-Philippines latitudes.
     *
     * These are modelled weights, not measured output — the UI labels them as
     * estimates. Jun–Sep dips with the south-west monsoon.
     *
     * @return array<int, array{label: string, value: float}>
     */
    public function monthlyProfile(float $annualKwh): array
    {
        $weights = [
            'Jan' => 0.090, 'Feb' => 0.090, 'Mar' => 0.098, 'Apr' => 0.098,
            'May' => 0.090, 'Jun' => 0.073, 'Jul' => 0.068, 'Aug' => 0.066,
            'Sep' => 0.072, 'Oct' => 0.080, 'Nov' => 0.086, 'Dec' => 0.089,
        ];

        $total = array_sum($weights);

        return collect($weights)
            ->map(fn (float $weight, string $month) => [
                'label' => $month,
                'value' => round($annualKwh * ($weight / $total), 1),
            ])
            ->values()
            ->all();
    }
}
