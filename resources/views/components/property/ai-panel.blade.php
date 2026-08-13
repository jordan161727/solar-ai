@props(['property'])

@php
    $a = $property->solarAssessment;

    // Straight-line payback against a ~₱55k/kW installed cost for PH residential.
    $installCost = $a ? $a->system_size_kw * 55000 : null;
    $paybackYears = $a && $a->estimated_savings > 0
        ? round($installCost / $a->estimated_savings, 1)
        : null;
@endphp

<div class="card overflow-hidden">

    <div class="flex items-center justify-between gap-4 border-b border-line px-5 py-4">

        <div class="flex items-center gap-2">
            <x-ui.icon name="sparkles" class="h-4 w-4 text-accent" />
            <h2 class="text-sm font-medium text-content">AI recommendation</h2>
        </div>

        @if($a)
            <span class="badge bg-accent-soft text-accent tabular">{{ $a->solar_score }}/100</span>
        @endif

    </div>

    @if($a)

        <dl class="divide-y divide-line">

            @foreach([
                ['Recommended panels', number_format($a->max_panels)],
                ['System size', number_format($a->system_size_kw, 2).' kW'],
                ['Annual generation', number_format($a->annual_generation).' kWh'],
                ['Annual savings', '₱'.number_format($a->estimated_savings)],
                ['Est. install cost', '₱'.number_format($installCost)],
                ['Payback period', $paybackYears ? $paybackYears.' years' : '—'],
            ] as [$label, $value])
                <div class="flex items-center justify-between gap-4 px-5 py-2.5">
                    <dt class="text-sm text-content-muted">{{ $label }}</dt>
                    <dd class="text-sm font-medium tabular text-content">{{ $value }}</dd>
                </div>
            @endforeach

        </dl>

        <div class="border-t border-line p-5">
            <button type="button" class="btn btn-primary btn-md w-full">
                Generate proposal
            </button>

            <p class="mt-2 text-center text-xs text-content-subtle">
                Estimates only — confirm with a site inspection.
            </p>
        </div>

    @else

        <div class="px-5 py-10 text-center">
            <p class="text-sm text-content-muted">
                Run an assessment to see panel counts, savings and payback.
            </p>
        </div>

    @endif

</div>
