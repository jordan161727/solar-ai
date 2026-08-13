@props(['property'])

@php
    $assessment = $property->solarAssessment;
    $location = collect([$property->address, $property->city, $property->province])
        ->filter()
        ->implode(', ');
@endphp

<div class="space-y-4">

    <a href="{{ route('properties.index') }}"
       class="inline-flex items-center gap-1.5 rounded text-sm text-content-muted transition-colors hover:text-content">
        <x-ui.icon name="arrow-down" class="h-4 w-4 rotate-90" />
        Back to properties
    </a>

    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

        <div class="min-w-0">

            <div class="flex flex-wrap items-center gap-2.5">
                <h1 class="text-display text-content">
                    {{ $property->property_name ?: 'Untitled property' }}
                </h1>

                <x-status-badge :status="$property->status" />
            </div>

            <p class="mt-1.5 flex items-center gap-1.5 text-sm text-content-muted">
                <x-ui.icon name="location" class="h-4 w-4 shrink-0" />
                {{ $location ?: 'No address recorded' }}
            </p>

        </div>

        <div class="flex shrink-0 items-center gap-2">

            <a href="{{ route('properties.edit', $property) }}" class="btn btn-secondary btn-md">
                Edit
            </a>

            @if($assessment && filled($assessment->panel_layout))
                <a href="{{ route('solar.design', $property) }}" class="btn btn-primary btn-md">
                    <x-ui.icon name="sun" class="h-4 w-4" />
                    Design system
                </a>
            @else
                <button type="button" class="btn btn-primary btn-md">
                    <x-ui.icon name="sparkles" class="h-4 w-4" />
                    Run analysis
                </button>
            @endif

        </div>

    </div>

</div>
