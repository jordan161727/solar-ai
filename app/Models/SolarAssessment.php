<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolarAssessment extends Model
{
   protected $fillable = [

        'property_id',

        'solar_api_id',

        'roof_type',

        'roof_area',

        'roof_pitch',

        'roof_orientation',

        'solar_score',

        'max_panels',

        'system_size_kw',

        'annual_generation',

        'monthly_generation',

        'estimated_savings',

        'co2_offset',

        'last_synced_at',

    ];

    protected $casts = [

        'roof_area' => 'decimal:2',

        'roof_pitch' => 'decimal:2',

        'roof_orientation' => 'decimal:2',

        'system_size_kw' => 'decimal:2',

        'annual_generation' => 'decimal:2',

        'monthly_generation' => 'decimal:2',

        'estimated_savings' => 'decimal:2',

        'co2_offset' => 'decimal:2',

        'last_synced_at' => 'datetime',

    ];

    /**
     * Property relationship
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
