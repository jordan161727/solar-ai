@props(['property'])

@php
    $a = $property->solarAssessment;

    // 25-year lifetime is the standard panel warranty window used for ROI framing.
    $lifetimeSavings = $a ? $a->estimated_savings * 25 : null;
@endphp

@if($a)

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        <x-dashboard.stat-card
            title="Annual generation"
            :value="number_format($a->annual_generation).' kWh'"
            icon="bolt"
            :change="null"
        />

        <x-dashboard.stat-card
            title="Annual savings"
            :value="'₱'.number_format($a->estimated_savings)"
            icon="card"
            :change="null"
        />

        <x-dashboard.stat-card
            title="CO₂ offset"
            :value="number_format($a->co2_offset / 1000, 1).' t/yr'"
            icon="leaf"
            :change="null"
        />

        <x-dashboard.stat-card
            title="25-year value"
            :value="'₱'.number_format($lifetimeSavings / 1_000_000, 1).'M'"
            icon="chart"
            :change="null"
        />

    </div>

@else

    <div class="card flex flex-col items-start gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-accent-soft">
                <x-ui.icon name="sparkles" class="h-[18px] w-[18px] text-accent" />
            </span>

            <div>
                <p class="text-sm font-medium text-content">No solar assessment yet</p>
                <p class="mt-0.5 text-sm text-content-muted">
                    Run an analysis to generate roof, generation and savings figures.
                </p>
            </div>

        </div>

        <button type="button" class="btn btn-primary btn-md shrink-0">
            Run analysis
        </button>

    </div>

@endif
