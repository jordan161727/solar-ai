<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Property;
use App\Models\SolarAssessment;


class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reuse customers seeded by CustomerSeeder instead of creating
        // a new one per property.
        $customers = Customer::all();

        if ($customers->isEmpty()) {
            $customers = Customer::factory(20)->create();
        }

        Property::factory(50)
            ->recycle($customers)
            ->create()
            ->each(function (Property $property) {
                // Only analysed properties have an assessment yet
                if ($property->status === 'Pending') {
                    return;
                }

                SolarAssessment::factory()->create([
                    'property_id' => $property->id,
                ]);
            });
    }
}
