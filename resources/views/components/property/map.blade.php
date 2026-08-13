@props(['property'])

@php
    $hasCoords = filled($property->latitude) && filled($property->longitude);
@endphp

<div class="card overflow-hidden">

    <div class="flex items-center justify-between gap-4 border-b border-line px-5 py-4">

        <h2 class="text-sm font-medium text-content">Location</h2>

        @if($hasCoords)
            <a
                href="https://www.google.com/maps/search/?api=1&query={{ $property->latitude }},{{ $property->longitude }}"
                target="_blank"
                rel="noopener noreferrer"
                class="btn btn-secondary btn-sm"
            >
                Open in Maps
            </a>
        @endif

    </div>

    @if($hasCoords)

        <img
            src="{{ route('map.image', ['lat' => $property->latitude, 'lng' => $property->longitude, 'size' => 'large']) }}"
            alt="Satellite view of {{ $property->property_name ?: 'the property' }}"
            class="block h-56 w-full border-b border-line bg-surface-muted object-cover"
            loading="lazy"
        >

    @else

        <div class="grid h-56 place-items-center border-b border-line bg-surface-muted">
            <p class="text-xs text-content-muted">No coordinates recorded</p>
        </div>

    @endif

    <dl class="grid grid-cols-3 gap-4 px-5 py-4">
        <x-property.info-item label="Latitude" :value="$property->latitude" />
        <x-property.info-item label="Longitude" :value="$property->longitude" />
        <x-property.info-item label="Place ID" :value="$property->place_id" />
    </dl>

</div>
