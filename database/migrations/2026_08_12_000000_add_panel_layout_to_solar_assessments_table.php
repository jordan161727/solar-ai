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
        Schema::table('solar_assessments', function (Blueprint $table) {
            // Google's computed panel positions and the pre-costed array sizes.
            // Stored so the designer can render without re-hitting the Solar API.
            $table->json('panel_layout')->nullable()->after('max_panels');
            $table->json('roof_segments')->nullable()->after('panel_layout');
            $table->json('panel_configs')->nullable()->after('roof_segments');

            $table->decimal('panel_width_m', 6, 3)->nullable()->after('panel_configs');
            $table->decimal('panel_height_m', 6, 3)->nullable()->after('panel_width_m');
            $table->unsignedInteger('panel_capacity_w')->nullable()->after('panel_height_m');

            // The size the user settled on in the designer.
            $table->unsignedInteger('selected_panel_count')->nullable()->after('panel_capacity_w');

            $table->string('imagery_quality')->nullable()->after('selected_panel_count');
            $table->date('imagery_date')->nullable()->after('imagery_quality');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solar_assessments', function (Blueprint $table) {
            $table->dropColumn([
                'panel_layout',
                'roof_segments',
                'panel_configs',
                'panel_width_m',
                'panel_height_m',
                'panel_capacity_w',
                'selected_panel_count',
                'imagery_quality',
                'imagery_date',
            ]);
        });
    }
};
