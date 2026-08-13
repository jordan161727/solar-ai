<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\SolarAssessment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SolarAssessment>
 */
class SolarAssessmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roofArea = fake()->numberBetween(70, 220);

        // Roughly one 600W panel per 2 sqm of usable roof
        $maxPanels = (int) floor($roofArea / 2);
        $systemSizeKw = round($maxPanels * 0.6, 2);

        // PH averages ~4.5 peak sun hours/day
        $annualGeneration = round($systemSizeKw * 4.5 * 365, 2);

        return [
            'property_id' => Property::factory(),

            'solar_api_id' => null,

            'roof_type' => fake()->randomElement([
                'Metal',
                'Concrete',
                'Tile',
            ]),

            'roof_area' => $roofArea,

            'roof_pitch' => fake()->randomFloat(2, 5, 35),

            'roof_orientation' => fake()->randomFloat(2, 0, 359),

            'solar_score' => fake()->numberBetween(70, 99),

            'max_panels' => $maxPanels,

            'system_size_kw' => $systemSizeKw,

            'annual_generation' => $annualGeneration,

            'monthly_generation' => round($annualGeneration / 12, 2),

            // ~PHP 12 per kWh displaced from the grid
            'estimated_savings' => round($annualGeneration * 12, 2),

            'co2_offset' => round($annualGeneration * 0.7, 2),

            'last_synced_at' => now(),
        ];
    }
}
