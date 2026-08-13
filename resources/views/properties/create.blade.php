<x-app-layout title="New property">

@php
    $steps = [
        1 => 'Owner',
        2 => 'Property',
        3 => 'Address',
        4 => 'Map',
        5 => 'Review',
    ];

    // Jump straight to the step that failed validation.
    $initialStep = (int) old('current_step', 1);

    if ($errors->any()) {
        $initialStep = 1;

        if ($errors->hasAny(['property_name', 'status'])) {
            $initialStep = 2;
        }

        if ($errors->hasAny(['address', 'city', 'province', 'postal_code', 'country'])) {
            $initialStep = 3;
        }

        if ($errors->hasAny(['latitude', 'longitude', 'place_id'])) {
            $initialStep = 4;
        }

        if ($errors->hasAny(['owner_name', 'email', 'phone'])) {
            $initialStep = 1;
        }
    }
@endphp

<div class="mx-auto max-w-4xl space-y-5">

    {{-- Header --}}
    <div>
        <a href="{{ route('properties.index') }}"
           class="inline-flex items-center gap-1.5 rounded text-sm text-content-muted transition-colors hover:text-content">
            <x-ui.icon name="arrow-down" class="h-4 w-4 rotate-90" />
            Back to properties
        </a>

        <h1 class="mt-3 text-display text-content">New property</h1>

        <p class="mt-1 text-sm text-content-muted">
            Register a property so it can be assessed for solar potential.
        </p>
    </div>

    @if ($errors->any())
        <div class="rounded-xl border border-danger/25 bg-danger-soft px-4 py-3">

            <p class="text-sm font-medium text-danger">
                Please fix {{ $errors->count() }} {{ Str::plural('error', $errors->count()) }} before continuing.
            </p>

            <ul class="mt-1.5 list-disc space-y-0.5 pl-4 text-sm text-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <div
        x-data="propertyWizard({
            initialStep: {{ $initialStep }},
            initialOwnerName: {{ json_encode(old('owner_name')) }},
            initialEmail: {{ json_encode(old('email')) }},
            initialPhone: {{ json_encode(old('phone')) }},
            initialPropertyName: {{ json_encode(old('property_name')) }},
            initialStatus: {{ json_encode(old('status', 'Pending')) }},
            initialAddress: {{ json_encode(old('address')) }},
            initialCity: {{ json_encode(old('city')) }},
            initialProvince: {{ json_encode(old('province')) }},
            initialPostalCode: {{ json_encode(old('postal_code')) }},
            initialCountry: {{ json_encode(old('country', 'Philippines')) }},
            initialLatitude: {{ json_encode(old('latitude')) }},
            initialLongitude: {{ json_encode(old('longitude')) }},
            initialPlaceId: {{ json_encode(old('place_id')) }},
            mapImageUrl: {{ json_encode(route('map.image')) }},
        })"
        x-on:property-location-selected.window="applyLocation($event.detail)"
        class="space-y-5"
    >

        {{-- Stepper --}}
        <ol class="flex items-center gap-2 overflow-x-auto pb-1">

            @foreach($steps as $number => $label)
                <li class="flex shrink-0 items-center gap-2">

                    <div class="flex items-center gap-2">

                        <span
                            class="grid h-6 w-6 shrink-0 place-items-center rounded-full text-xs font-medium transition-colors"
                            x-bind:class="step === {{ $number }}
                                ? 'bg-accent text-accent-contrast'
                                : (step > {{ $number }}
                                    ? 'bg-accent-soft text-accent'
                                    : 'bg-surface-muted text-content-subtle')"
                        >{{ $number }}</span>

                        <span
                            class="text-sm transition-colors"
                            x-bind:class="step >= {{ $number }} ? 'font-medium text-content' : 'text-content-subtle'"
                        >{{ $label }}</span>

                    </div>

                    @unless($loop->last)
                        <span class="ml-1 hidden h-px w-8 bg-line sm:block"></span>
                    @endunless

                </li>
            @endforeach

        </ol>

        <form
            method="POST"
            action="{{ route('properties.store') }}"
            enctype="multipart/form-data"
            class="space-y-4"
        >

            @csrf
            <input type="hidden" name="current_step" x-model="step" />

            @foreach($steps as $number => $label)

                <div data-property-wizard-panel="{{ $number }}"
                     x-show.important="step === {{ $number }}"
                     @if($number !== 1) hidden @endif>

                    @switch($number)
                        @case(1) <x-property.owner-section /> @break
                        @case(2) <x-property.property-section /> @break
                        @case(3) <x-property.location-section /> @break
                        @case(4) <x-property.map-section /> @break
                        @case(5) <x-property.review-section /> @break
                    @endswitch

                    <div class="mt-4 flex items-center justify-between gap-3">

                        @if($number === 1)
                            <a href="{{ route('properties.index') }}" class="btn btn-ghost btn-md">Cancel</a>
                        @else
                            <button type="button" x-on:click="prev()" class="btn btn-secondary btn-md">Back</button>
                        @endif

                        @if($number === 5)
                            <button type="submit" class="btn btn-primary btn-md">Create property</button>
                        @else
                            <button type="button" x-on:click="next()" class="btn btn-primary btn-md">Continue</button>
                        @endif

                    </div>

                </div>

            @endforeach

        </form>

    </div>

</div>

</x-app-layout>
