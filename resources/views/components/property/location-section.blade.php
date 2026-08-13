<x-property.section
    title="Address"
    description="Search for the address — the remaining fields fill in automatically."
>

    <div class="grid gap-4 sm:grid-cols-2">

        {{-- Autocomplete --}}
        <div
            class="relative sm:col-span-2"
            x-data="addressAutocomplete({
                initialAddress: {{ json_encode(old('address')) }},
                initialPlaceId: {{ json_encode(old('place_id')) }},
                autocompleteUrl: {{ json_encode(route('places.autocomplete')) }},
                detailsUrl: {{ json_encode(route('places.details')) }},
            })"
            x-on:click.outside="open = false"
        >

            <label for="address" class="block text-sm font-medium text-content">
                Street address
            </label>

            <div class="relative mt-1.5">

                <x-ui.icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-content-subtle" />

                <input
                    id="address"
                    type="text"
                    name="address"
                    x-model="address"
                    x-on:input="onInput($event.target.value)"
                    x-on:keydown="onKeydown($event)"
                    x-on:focus="if (suggestions.length) open = true"
                    autocomplete="off"
                    role="combobox"
                    aria-autocomplete="list"
                    x-bind:aria-expanded="open"
                    placeholder="Start typing an address…"
                    required
                    class="input !pl-9 !pr-9 {{ $errors->has('address') ? '!border-danger' : '' }}"
                >

                {{-- Status affordance on the right of the field --}}
                <div class="absolute right-3 top-1/2 -translate-y-1/2">

                    <svg x-show="loading" x-cloak class="h-4 w-4 animate-spin text-content-subtle"
                         viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" opacity=".25" />
                        <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>

                    <x-ui.icon
                        name="location"
                        class="h-4 w-4 text-success"
                        x-show="resolved && !loading"
                        x-cloak
                    />

                </div>

                {{-- Suggestions --}}
                <ul
                    x-show="open"
                    x-cloak
                    x-transition.opacity.duration.100ms
                    role="listbox"
                    class="absolute z-20 mt-1 max-h-64 w-full overflow-y-auto rounded-lg border border-line bg-surface py-1 shadow-overlay"
                >
                    <template x-for="(suggestion, index) in suggestions" x-bind:key="suggestion.place_id">
                        <li>
                            <button
                                type="button"
                                x-on:click="choose(suggestion)"
                                x-on:mouseenter="highlighted = index"
                                x-bind:class="highlighted === index ? 'bg-surface-muted' : ''"
                                class="flex w-full items-start gap-2.5 px-3 py-2 text-left transition-colors hover:bg-surface-muted"
                            >
                                <x-ui.icon name="location" class="mt-0.5 h-4 w-4 shrink-0 text-content-subtle" />

                                <span class="min-w-0">
                                    <span class="block truncate text-sm font-medium text-content" x-text="suggestion.primary"></span>
                                    <span class="block truncate text-xs text-content-muted" x-text="suggestion.secondary"></span>
                                </span>
                            </button>
                        </li>
                    </template>
                </ul>

            </div>

            @error('address')
                <p class="mt-1.5 text-sm text-danger">{{ $message }}</p>
            @enderror

            <p x-show="error" x-cloak x-text="error" class="mt-1.5 text-sm text-warning"></p>

        </div>

        {{-- Auto-filled from the chosen place, still editable --}}
        <x-property.field name="city" label="City / Municipality" model="city" placeholder="San Jose Del Monte" />

        <x-property.field name="province" label="Province" model="province" placeholder="Bulacan" />

        <x-property.field name="postal_code" label="Postal code" model="postal_code" placeholder="3023" />

        <x-property.field name="country" label="Country" model="country" placeholder="Philippines" />

    </div>

    {{--
        Coordinates are captured from the selected place but not shown as
        inputs — the map step is where location gets confirmed visually.
    --}}
    <input type="hidden" name="latitude" x-model="latitude" />
    <input type="hidden" name="longitude" x-model="longitude" />
    <input type="hidden" name="place_id" x-model="placeId" />

    @error('latitude')
        <p class="mt-3 text-sm text-danger">{{ $message }}</p>
    @enderror

    @error('longitude')
        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
    @enderror

</x-property.section>
