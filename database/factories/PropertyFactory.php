<?php

namespace Database\Factories;

use App\Models\Customer;
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
            'customer_id' => Customer::factory(),

            'property_name' => fake()->randomElement([
                'Residence',
                'Warehouse',
                'Commercial Building',
                'Rest House',
            ]).' '.fake()->numberBetween(1, 200),

            'address' => fake()->streetAddress(),

            'city' => 'San Jose Del Monte',

            'province' => 'Bulacan',

            'postal_code' => '3023',

            'country' => 'Philippines',

            // Spread around San Jose Del Monte, Bulacan
            'latitude' => fake()->randomFloat(7, 14.7600, 14.8600),

            'longitude' => fake()->randomFloat(7, 121.0200, 121.0900),

            'place_id' => null,

            'status' => fake()->randomElement([
                'Pending',
                'Analyzing',
                'Completed',
            ]),
        ];
    }
}
