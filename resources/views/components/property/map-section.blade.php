<x-property.section
    title="Map"
    description="Confirm the rooftop before saving."
>

    {{-- No coordinates yet --}}
    <div x-show="!hasCoordinates" x-cloak class="rounded-lg border border-dashed border-line-strong px-6 py-12 text-center">

        <span class="mx-auto grid h-10 w-10 place-items-center rounded-full bg-surface-muted">
            <x-ui.icon name="map" class="h-5 w-5 text-content-subtle" />
        </span>

        <p class="mt-3 text-sm font-medium text-content">No location selected</p>

        <p class="mx-auto mt-1 max-w-sm text-sm text-content-muted">
            Go back to the address step and pick an address from the suggestions —
            coordinates are captured automatically.
        </p>

        <button type="button" x-on:click="selectStep(3)" class="btn btn-secondary btn-md mt-4">
            Back to address
        </button>

    </div>

    {{-- Located --}}
    <div x-show="hasCoordinates" x-cloak class="space-y-4">

        <div class="overflow-hidden rounded-lg border border-line">

            <img
                x-bind:src="mapPreviewSrc"
                x-bind:alt="'Satellite view of ' + (address || 'the property')"
                class="block h-64 w-full bg-surface-muted object-cover"
                loading="lazy"
            >

            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-line px-4 py-3">

                <div class="min-w-0">
                    <p class="truncate text-sm font-medium text-content"
                       x-text="formattedAddress || address"></p>

                    <p class="mt-0.5 text-xs tabular text-content-muted">
                        <span x-text="latitude"></span>, <span x-text="longitude"></span>
                    </p>
                </div>

                <a
                    x-bind:href="googleMapsUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn btn-secondary btn-sm shrink-0"
                >
                    Open in Google Maps
                </a>

            </div>

        </div>

        <p class="text-xs text-content-muted" x-text="mapMessage"></p>

    </div>

</x-property.section>
