<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'property_code'=>'PROP-'.fake()->unique()->numberBetween(1000,9999),

            'owner_name'=>fake()->name(),

            'email'=>fake()->safeEmail(),

            'phone'=>fake()->phoneNumber(),

            'address'=>fake()->streetAddress(),

            'barangay'=>'Barangay '.fake()->numberBetween(1,20),

            'city'=>'San Jose Del Monte',

            'province'=>'Bulacan',

            'zipcode'=>'3023',

            'latitude'=>14.8139,

            'longitude'=>121.0458,

            'roof_type'=>fake()->randomElement([
                'Metal',
                'Concrete',
                'Tile'
            ]),

            'roof_area'=>fake()->numberBetween(70,220),

            'solar_score'=>fake()->numberBetween(70,99),

            'estimated_generation'=>fake()->numberBetween(6000,18000),

            'estimated_savings'=>fake()->numberBetween(80000,350000),

            'status'=>fake()->randomElement([
                'Pending',
                'Completed',
                'Installed'
            ])
        ];
    }
}
