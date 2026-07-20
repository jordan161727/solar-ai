<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Customer;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'property_name',
        'address',
        'city',
        'province',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'place_id',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function solarAssessment()
    {
        return $this->hasOne(SolarAssessment::class);
    }

    public function weatherRecords()
    {
        return $this->hasMany(WeatherRecord::class);
    }
}
