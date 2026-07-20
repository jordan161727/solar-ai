<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weather_records', function (Blueprint $table) {
         $table->id();

    $table->foreignId('property_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->date('record_date');

    $table->decimal('temperature',5,2)->nullable();

    $table->decimal('feels_like',5,2)->nullable();

    $table->decimal('humidity',5,2)->nullable();

    $table->decimal('cloud_cover',5,2)->nullable();

    $table->decimal('wind_speed',5,2)->nullable();

    $table->decimal('uv_index',5,2)->nullable();

    $table->decimal('irradiance',8,2)->nullable();

    $table->decimal('sun_hours',8,2)->nullable();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_records');
    }
};
