@props(['property'])

@php
    $assessment = $property->solarAssessment;
    $customer = $property->customer;
    $location = collect([$property->city, $property->province])->filter()->implode(', ') ?: $property->address;
@endphp

<div class="card group flex flex-col transition-colors hover:border-line-strong">

    {{-- Head --}}
    <div class="flex items-start justify-between gap-3 p-5 pb-4">

        <div class="flex min-w-0 items-center gap-3">

            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-surface-muted">
                <x-ui.icon name="building" class="h-[18px] w-[18px] text-content-subtle" />
            </span>

            <div class="min-w-0">
                <a href="{{ route('properties.show', $property) }}"
                   class="block truncate rounded text-sm font-medium text-content transition-colors group-hover:text-accent">
                    {{ $property->property_name ?: 'Untitled property' }}
                </a>

                <p class="mt-0.5 flex items-center gap-1 truncate text-xs text-content-muted">
                    <x-ui.icon name="location" class="h-3.5 w-3.5 shrink-0" />
                    {{ $location }}
                </p>
            </div>

        </div>

        <x-status-badge :status="$property->status" class="shrink-0" />

    </div>

    {{-- Metrics --}}
    <dl class="grid grid-cols-3 gap-3 border-t border-line px-5 py-4">

        <div>
            <dt class="text-[11px] text-content-subtle">Score</dt>
            <dd class="mt-0.5 text-sm font-semibold tabular text-content">
                {{ $assessment?->solar_score ?? '—' }}
            </dd>
        </div>

        <div>
            <dt class="text-[11px] text-content-subtle">Roof area</dt>
            <dd class="mt-0.5 text-sm font-semibold tabular text-content">
                {{ $assessment ? number_format($assessment->roof_area).' m²' : '—' }}
            </dd>
        </div>

        <div>
            <dt class="text-[11px] text-content-subtle">Savings</dt>
            <dd class="mt-0.5 text-sm font-semibold tabular text-content">
                {{ $assessment ? '₱'.number_format($assessment->estimated_savings / 1000).'K' : '—' }}
            </dd>
        </div>

    </dl>

    {{-- Score bar --}}
    <div class="px-5">
        <div class="h-1 overflow-hidden rounded-full bg-surface-muted">
            <div class="h-full rounded-full bg-accent" style="width:{{ $assessment?->solar_score ?? 0 }}%"></div>
        </div>
    </div>

    {{-- Foot --}}
    <div class="mt-auto flex items-center justify-between gap-3 p-5 pt-4">

        <p class="truncate text-xs text-content-muted">
            {{ $customer ? trim($customer->first_name.' '.$customer->last_name) : 'No customer' }}
        </p>

        <div class="flex shrink-0 gap-2">
            <a href="{{ route('properties.edit', $property) }}" class="btn btn-secondary btn-sm">Edit</a>
            <a href="{{ route('properties.show', $property) }}" class="btn btn-primary btn-sm">View</a>
        </div>

    </div>

</div>
