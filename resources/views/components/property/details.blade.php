@props(['property'])

@php
    $customer = $property->customer;
    $a = $property->solarAssessment;

    $ownerName = $customer ? trim($customer->first_name.' '.$customer->last_name) : null;
@endphp

<div class="card overflow-hidden">

    <div class="flex items-center justify-between gap-4 border-b border-line px-5 py-4">

        <h2 class="text-sm font-medium text-content">Property information</h2>

        <span class="text-xs text-content-subtle tabular">ID #{{ $property->id }}</span>

    </div>

    <div class="divide-y divide-line">

        {{-- Owner --}}
        <section class="px-5 py-4">

            <p class="eyebrow">Owner</p>

            <dl class="mt-3 grid gap-4 sm:grid-cols-2">
                <x-property.info-item label="Name" :value="$ownerName" />
                <x-property.info-item label="Email" :value="$customer?->email" />
                <x-property.info-item label="Phone" :value="$customer?->phone" />
                <x-property.info-item label="Status" :value="$property->status" />
            </dl>

        </section>

        {{-- Location --}}
        <section class="px-5 py-4">

            <p class="eyebrow">Location</p>

            <dl class="mt-3 grid gap-4 sm:grid-cols-2">
                <x-property.info-item label="Address" :value="$property->address" />
                <x-property.info-item label="City" :value="$property->city" />
                <x-property.info-item label="Province" :value="$property->province" />
                <x-property.info-item label="Postal code" :value="$property->postal_code" />
                <x-property.info-item label="Country" :value="$property->country" />
                <x-property.info-item label="Added" :value="$property->created_at?->format('j F Y')" />
            </dl>

        </section>

        {{-- Roof --}}
        <section class="px-5 py-4">

            <p class="eyebrow">Roof</p>

            @if($a)
                <dl class="mt-3 grid gap-4 sm:grid-cols-3">
                    <x-property.info-item label="Type" :value="$a->roof_type" />
                    <x-property.info-item label="Area" :value="number_format($a->roof_area).' m²'" />
                    <x-property.info-item label="Pitch" :value="number_format($a->roof_pitch, 1).'°'" />
                    <x-property.info-item label="Orientation" :value="number_format($a->roof_orientation).'°'" />
                    <x-property.info-item label="Max panels" :value="number_format($a->max_panels)" />
                    <x-property.info-item label="System size" :value="number_format($a->system_size_kw, 2).' kW'" />
                </dl>
            @else
                <p class="mt-2 text-sm text-content-muted">
                    Roof data appears once an assessment has been run.
                </p>
            @endif

        </section>

    </div>

</div>
