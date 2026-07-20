<x-app-layout>
    
<div class="mx-auto max-w-7xl py-8 space-y-8">

    <x-property.header
        title="New Property"
        description="Register a property for solar assessment." />

    @if ($errors->any())
        <div class="rounded-2xl border border-red-500/30 bg-red-500/10 p-6">
            <div class="font-semibold text-red-400">
                ❌ Please fix the following errors:
            </div>

            <ul class="mt-3 space-y-1 text-red-300">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $initialStep = (int) old('current_step', 1);

        if ($errors->any()) {
            $initialStep = max($initialStep, 1);

            if ($errors->hasAny(['latitude', 'longitude', 'place_id'])) {
                $initialStep = max($initialStep, 4);
            }

            if ($errors->hasAny(['address', 'city', 'province', 'postal_code', 'country'])) {
                $initialStep = max($initialStep, 3);
            }

            if ($errors->hasAny(['property_name', 'status'])) {
                $initialStep = max($initialStep, 2);
            }

            if ($errors->hasAny(['owner_name', 'email', 'phone'])) {
                $initialStep = max($initialStep, 1);
            }
        }
    @endphp

    <div x-data="propertyWizard({
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
        })" x-on:property-location-selected.window="applyLocation($event.detail)" x-cloak>
        <style>[x-cloak]{display:none!important;}</style>

        <div class="flex flex-col gap-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">
                    Property setup
                </p>
                <h2 class="mt-2 text-3xl font-black text-white">
                    Follow the steps to create a new property
                </h2>
            </div>

            <div class="relative flex items-center gap-4 overflow-x-auto pb-4">
                <div class="flex w-full items-center gap-4">
                    <button
                        type="button"
                        disabled
                        :class="step === 1 ? 'bg-blue-600 text-white' : 'bg-slate-800 text-slate-300'"
                        class="flex items-center gap-3 rounded-3xl px-5 py-4 shadow-xl transition">
                        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-950 text-lg font-bold">1</div>
                        <div>
                            <div class="text-xs uppercase tracking-[0.2em] text-slate-200">Step 1</div>
                            <div class="text-sm font-semibold">Owner</div>
                        </div>
                    </button>

                    <div class="hidden h-0.5 flex-1 bg-slate-700 md:block"></div>

                    <button
                        type="button"
                        disabled
                        :class="step === 2 ? 'bg-blue-600 text-white' : 'bg-slate-800 text-slate-300'"
                        class="flex items-center gap-3 rounded-3xl px-5 py-4 transition">
                        <div class="flex h-11 w-11 items-center justify-center rounded-full border border-slate-700 text-lg font-bold">2</div>
                        <div>
                            <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Step 2</div>
                            <div class="text-sm font-semibold">Property</div>
                        </div>
                    </button>

                    <div class="hidden h-0.5 flex-1 bg-slate-700 md:block"></div>

                    <button
                        type="button"
                        disabled
                        :class="step === 3 ? 'bg-blue-600 text-white' : 'bg-slate-800 text-slate-300'"
                        class="flex items-center gap-3 rounded-3xl px-5 py-4 transition">
                        <div class="flex h-11 w-11 items-center justify-center rounded-full border border-slate-700 text-lg font-bold">3</div>
                        <div>
                            <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Step 3</div>
                            <div class="text-sm font-semibold">Address</div>
                        </div>
                    </button>

                    <div class="hidden h-0.5 flex-1 bg-slate-700 md:block"></div>

                    <button
                        type="button"
                        disabled
                        :class="step === 4 ? 'bg-blue-600 text-white' : 'bg-slate-800 text-slate-300'"
                        class="flex items-center gap-3 rounded-3xl px-5 py-4 transition">
                        <div class="flex h-11 w-11 items-center justify-center rounded-full border border-slate-700 text-lg font-bold">4</div>
                        <div>
                            <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Step 4</div>
                            <div class="text-sm font-semibold">Map</div>
                        </div>
                    </button>

                    <div class="hidden h-0.5 flex-1 bg-slate-700 md:block"></div>

                    <button
                        type="button"
                        disabled
                        :class="step === 5 ? 'bg-blue-600 text-white' : 'bg-slate-800 text-slate-300'"
                        class="flex items-center gap-3 rounded-3xl px-5 py-4 transition">
                        <div class="flex h-11 w-11 items-center justify-center rounded-full border border-slate-700 text-lg font-bold">5</div>
                        <div>
                            <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Step 5</div>
                            <div class="text-sm font-semibold">Save</div>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <form
            method="POST"
            action="{{ route('properties.store') }}"
            enctype="multipart/form-data"
            class="space-y-8">

            @csrf
            <input type="hidden" name="current_step" x-model="step" />

            <div data-property-wizard-panel="1" x-show.important="step === 1">
                <x-property.owner-section />
                 <div class="mt-6 flex justify-end">
                    <button type="button" @click="next()"
                        class="rounded-2xl bg-blue-600 px-8 py-4 font-semibold text-white transition hover:bg-blue-500">
                        Continue
                    </button>
                </div> 
            </div>

            <div data-property-wizard-panel="2" x-show.important="step === 2" hidden>
                <x-property.property-section />
                <div class="flex justify-between gap-4 pt-6">
                    <button
                        type="button"
                        @click="prev()"
                        class="rounded-2xl border border-slate-700 px-8 py-4 text-white transition hover:bg-slate-800">
                        Back
                    </button>
                    <button
                        type="button"
                        @click="next()"
                        class="rounded-2xl bg-blue-600 px-8 py-4 font-semibold text-white transition hover:bg-blue-500">
                        Continue
                    </button>
                </div>
            </div>

            <div data-property-wizard-panel="3" x-show.important="step === 3" hidden>
                <x-property.location-section />
                <div class="flex justify-between gap-4 pt-6">
                    <button
                        type="button"
                        @click="prev()"
                        class="rounded-2xl border border-slate-700 px-8 py-4 text-white transition hover:bg-slate-800">
                        Back
                    </button>
                    <button
                        type="button"
                        @click="next()"
                        class="rounded-2xl bg-blue-600 px-8 py-4 font-semibold text-white transition hover:bg-blue-500">
                        Continue
                    </button>
                </div>
            </div>

            <div data-property-wizard-panel="4" x-show.important="step === 4" hidden>
                <x-property.map-section />
                <div class="flex justify-between gap-4 mt-6">
                    <button
                        type="button"
                        @click="prev()"
                        class="rounded-2xl border border-slate-700 px-8 py-4 text-white transition hover:bg-slate-800">
                        Back
                    </button>
                    <button
                        type="button"
                        @click="next()"
                        class="rounded-2xl bg-blue-600 px-8 py-4 font-semibold text-white transition hover:bg-blue-500">
                        Review
                    </button>
                </div>
            </div>

            <div data-property-wizard-panel="5" x-show.important="step === 5" hidden>
                <x-property.review-section />
                <div class="flex justify-between gap-4 mt-6">
                    <button
                        type="button"
                        @click="prev()"
                        class="rounded-2xl border border-slate-700 px-8 py-4 text-white transition hover:bg-slate-800">
                        Back
                    </button>
                    <button
                        type="submit"
                        class="rounded-2xl bg-blue-600 px-10 py-4 font-bold text-white transition hover:bg-blue-500">
                        🚀 Create Property
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>



<script>
    // The active wizard implementation lives in resources/js/app.js.
    // Keep this legacy helper isolated so it cannot overwrite Alpine's global.
    function legacyPropertyWizard(config) {
        return {
            step: config.initialStep || 1,
            ownerName: config.initialOwnerName || '',
            ownerEmail: config.initialEmail || '',
            ownerPhone: config.initialPhone || '',
            propertyName: config.initialPropertyName || '',
            status: config.initialStatus || 'Pending',
            address: config.initialAddress || '',
            city: config.initialCity || '',
            province: config.initialProvince || '',
            postal_code: config.initialPostalCode || '',
            country: config.initialCountry || 'Philippines',
            latitude: config.initialLatitude || '',
            longitude: config.initialLongitude || '',
            placeId: config.initialPlaceId || '',
            mapMessage: 'Ready for API lookup.',
            next() {
                this.step = Math.min(this.step + 1, 5);
            },
            prev() {
                this.step = Math.max(this.step - 1, 1);
            },
            lookupCoordinates() {
                if (!this.address) {
                    this.mapMessage = 'Enter the address in step 3 first.';
                    return;
                }
                this.mapMessage = 'API lookup stub: replace with your address lookup integration.';

                // Example integration stub:
                // axios.post('/api/geocode', { address: this.address })
                //      .then(response => {
                //          this.latitude = response.data.latitude;
                //          this.longitude = response.data.longitude;
                //          this.placeId = response.data.place_id;
                //          this.mapMessage = 'Location loaded from API.';
                //      });
            },
            applyLocation(location) {
                this.address = location.address || this.address;
                this.city = location.city || '';
                this.province = location.province || '';
                this.postal_code = location.postalCode || '';
                this.country = location.country || 'Philippines';
                this.latitude = location.latitude;
                this.longitude = location.longitude;
                this.placeId = location.placeId || '';
                this.mapMessage = 'Location selected. Solar and weather data will be fetched when you save.';
            },
        };
    }
</script>
</x-app-layout>
