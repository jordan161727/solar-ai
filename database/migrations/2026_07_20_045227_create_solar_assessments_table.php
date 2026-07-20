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
        Schema::create('solar_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')
        ->constrained()
        ->cascadeOnDelete();

    // Google Solar API
    $table->string('solar_api_id')->nullable();

    $table->string('roof_type')->nullable();
    $table->decimal('roof_area',10,2)->nullable();

    $table->decimal('roof_pitch',8,2)->nullable();
    $table->decimal('roof_orientation',8,2)->nullable();

    $table->integer('solar_score')->default(0);

    $table->integer('max_panels')->default(0);

    $table->decimal('system_size_kw',8,2)->default(0);

    $table->decimal('annual_generation',12,2)->default(0);

    $table->decimal('monthly_generation',12,2)->default(0);

    $table->decimal('estimated_savings',12,2)->default(0);

    $table->decimal('co2_offset',12,2)->default(0);

    $table->timestamp('last_synced_at')->nullable();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solar_assessments');
    }
};
