<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherRecord extends Model
{
    protected $fillable = [
        'property_id', 'record_date', 'temperature', 'feels_like', 'humidity',
        'cloud_cover', 'wind_speed', 'uv_index', 'irradiance', 'sun_hours',
    ];

    protected $casts = [
        'record_date' => 'date',
        'temperature' => 'decimal:2',
        'feels_like' => 'decimal:2',
        'humidity' => 'decimal:2',
        'cloud_cover' => 'decimal:2',
        'wind_speed' => 'decimal:2',
        'uv_index' => 'decimal:2',
        'irradiance' => 'decimal:2',
        'sun_hours' => 'decimal:2',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
