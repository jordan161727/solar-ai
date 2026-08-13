<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolarAssessment extends Model
{
    use HasFactory;

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

        'panel_layout',

        'roof_segments',

        'panel_configs',

        'panel_width_m',

        'panel_height_m',

        'panel_capacity_w',

        'selected_panel_count',

        'imagery_quality',

        'imagery_date',

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

        'panel_layout' => 'array',

        'roof_segments' => 'array',

        'panel_configs' => 'array',

        'panel_width_m' => 'float',

        'panel_height_m' => 'float',

        'imagery_date' => 'date',

    ];

    /**
     * Google returns panels sorted by yearly yield, best first, so a system of
     * N panels is simply the first N entries.
     *
     * @return array<int, array<string, mixed>>
     */
    public function panelsForCount(int $count): array
    {
        return array_slice($this->panel_layout ?? [], 0, max($count, 0));
    }

    /**
     * The config Google pre-computed for a given panel count, if any.
     *
     * @return array<string, mixed>|null
     */
    public function configForCount(int $count): ?array
    {
        return collect($this->panel_configs ?? [])
            ->first(fn (array $config) => (int) ($config['panelsCount'] ?? 0) === $count);
    }

    /**
     * Property relationship
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
