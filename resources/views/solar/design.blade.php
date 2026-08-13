<x-app-layout title="Solar Designer">

@php
    // Weights normalised here so the client only multiplies.
    $annual = $design['annual_kwh'] ?? 0;
    $monthlyWeights = collect($design['monthly'] ?? [])
        ->map(fn ($m) => [
            'label' => $m['label'],
            'weight' => $annual > 0 ? $m['value'] / $annual : 0,
        ])
        ->all();
@endphp

<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">

        <div class="min-w-0">

            <a href="{{ route('solar') }}"
               class="inline-flex items-center gap-1.5 rounded text-sm text-content-muted transition-colors hover:text-content">
                <x-ui.icon name="arrow-down" class="h-4 w-4 rotate-90" />
                All properties
            </a>

            <h1 class="mt-2 text-display text-content">
                {{ $property->property_name ?: 'Untitled property' }}
            </h1>

            <p class="mt-1 flex items-center gap-1.5 text-sm text-content-muted">
                <x-ui.icon name="location" class="h-4 w-4 shrink-0" />
                {{ collect([$property->address, $property->city, $property->province])->filter()->implode(', ') }}
            </p>

        </div>

        <a href="{{ route('properties.show', $property) }}" class="btn btn-secondary btn-md shrink-0">
            View property
        </a>

    </div>

    @if(session('status'))
        <div class="rounded-xl border border-success/25 bg-success-soft px-4 py-3 text-sm font-medium text-success">
            {{ session('status') }}
        </div>
    @endif

    @if($layout === null)

        {{-- No assessment yet --}}
        <div class="card px-6 py-16 text-center">

            <div class="mx-auto grid h-11 w-11 place-items-center rounded-full bg-accent-soft">
                <x-ui.icon name="sparkles" class="h-5 w-5 text-accent" />
            </div>

            <h2 class="mt-4 text-sm font-medium text-content">No roof analysis yet</h2>

            <p class="mx-auto mt-1 max-w-md text-sm text-content-muted">
                @if($property->latitude === null)
                    This property has no coordinates, so Google's Solar API can't locate the roof.
                    Edit the property and pick its address from the suggestions.
                @else
                    Run an assessment to fetch the roof geometry and panel layout from Google's Solar API.
                @endif
            </p>

            <a href="{{ route('properties.edit', $property) }}" class="btn btn-secondary btn-md mt-5">
                Edit property
            </a>

        </div>

    @else

        <div
            x-data="solarDesigner({
                initialPanels: {{ $design['panels'] }},
                yields: {{ json_encode(collect($assessment->panel_layout)->map(fn ($p) => round((float) ($p['yearlyEnergyDcKwh'] ?? 0), 2))->values()) }},
                panelWatts: {{ $design['panel_watts'] }},
                tariff: {{ \App\Services\PropertyInsightsService::TARIFF_PER_KWH }},
                co2Factor: {{ \App\Services\PropertyInsightsService::CO2_KG_PER_KWH }},
                costPerKw: 55000,
                monthlyWeights: {{ json_encode($monthlyWeights) }},
            })"
            class="grid grid-cols-1 gap-4 xl:grid-cols-12"
        >

            {{-- Canvas --}}
            <div class="xl:col-span-8">
                <x-solar.canvas
                    :property="$property"
                    :assessment="$assessment"
                    :layout="$layout"
                />
            </div>

            {{-- Configuration panel --}}
            <div class="space-y-4 xl:col-span-4">

                {{-- Headline --}}
                <div class="card card-pad">

                    <p class="eyebrow">System</p>

                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-metric tabular text-content" x-text="formattedKw"></span>
                        <span class="text-sm text-content-muted">kW</span>
                    </div>

                    <p class="mt-1 text-sm text-content-muted">
                        <span class="tabular" x-text="panels"></span> ×
                        {{ $design['panel_watts'] }} W panels
                    </p>

                    <dl class="mt-4 grid grid-cols-2 gap-4 border-t border-line pt-4">

                        <div>
                            <dt class="text-xs text-content-subtle">Annual output</dt>
                            <dd class="mt-1 text-sm font-semibold tabular text-content">
                                <span x-text="formattedAnnual"></span> kWh
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-content-subtle">Monthly avg</dt>
                            <dd class="mt-1 text-sm font-semibold tabular text-content">
                                <span x-text="formattedMonthly"></span> kWh
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-content-subtle">Annual savings</dt>
                            <dd class="mt-1 text-sm font-semibold tabular text-success" x-text="formattedSavings"></dd>
                        </div>

                        <div>
                            <dt class="text-xs text-content-subtle">CO₂ offset</dt>
                            <dd class="mt-1 text-sm font-semibold tabular text-content" x-text="formattedCo2 + '/yr'"></dd>
                        </div>

                        <div>
                            <dt class="text-xs text-content-subtle">Est. install cost</dt>
                            <dd class="mt-1 text-sm font-semibold tabular text-content" x-text="formattedCost"></dd>
                        </div>

                        <div>
                            <dt class="text-xs text-content-subtle">Payback</dt>
                            <dd class="mt-1 text-sm font-semibold tabular text-content" x-text="formattedPayback"></dd>
                        </div>

                    </dl>

                </div>

                {{-- Monthly production --}}
                <div class="card card-pad">

                    <div class="flex items-baseline justify-between gap-3">
                        <p class="eyebrow">Monthly production</p>
                        <p class="text-xs text-content-subtle">kWh</p>
                    </div>

                    <div class="mt-4 flex h-28 items-end gap-1">
                        <template x-for="month in monthly" x-bind:key="month.label">
                            <div class="flex flex-1 flex-col items-center gap-1.5">
                                <div class="flex w-full flex-1 items-end">
                                    <div
                                        class="w-full rounded-sm bg-accent transition-[height] duration-200"
                                        x-bind:style="`height:${barHeight(month.value)}`"
                                        x-bind:title="month.label + ': ' + money(month.value) + ' kWh'"
                                    ></div>
                                </div>
                                <span class="text-[10px] text-content-subtle" x-text="month.label.charAt(0)"></span>
                            </div>
                        </template>
                    </div>

                    <p class="mt-3 border-t border-line pt-3 text-xs text-content-subtle">
                        Seasonal shape is modelled for ~15°N; totals come from Google's per-panel yields.
                    </p>

                </div>

                {{-- Save --}}
                <form method="POST" action="{{ route('solar.design.store', $property) }}" class="card card-pad">
                    @csrf

                    <input type="hidden" name="panels" x-bind:value="panels">

                    <button type="submit" class="btn btn-primary btn-md w-full">
                        Save this design
                    </button>

                    <p class="mt-2 text-center text-xs text-content-subtle">
                        Updates the property's system size and savings.
                    </p>
                </form>

                {{-- Roof detail --}}
                <div class="card card-pad">

                    <p class="eyebrow">Roof</p>

                    <dl class="mt-3 space-y-2.5">
                        @foreach([
                            ['Usable area', number_format($assessment->roof_area, 1).' m²'],
                            ['Pitch', number_format($assessment->roof_pitch, 1).'°'],
                            ['Azimuth', number_format($assessment->roof_orientation).'°'],
                            ['Segments', count($assessment->roof_segments ?? [])],
                            ['Panel size', $assessment->panel_width_m.' × '.$assessment->panel_height_m.' m'],
                            ['Imagery', $assessment->imagery_quality.($assessment->imagery_date ? ' · '.$assessment->imagery_date->format('M Y') : '')],
                        ] as [$label, $value])
                            <div class="flex items-baseline justify-between gap-3">
                                <dt class="text-sm text-content-muted">{{ $label }}</dt>
                                <dd class="text-sm font-medium tabular text-content">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>

                </div>

            </div>

        </div>

    @endif

</div>

</x-app-layout>
