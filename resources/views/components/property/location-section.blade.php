<div class="rounded-3xl border border-slate-800 bg-slate-900 p-8">

    <h2 class="text-2xl font-bold text-white mb-6">

        📍 Property Location

    </h2>

    <div class="grid grid-cols-1 gap-6">

      <div>
    <label class="text-slate-400">
        Search Address
    </label>
    <input
        id="autocomplete"
        type="text"
        name="address"
        x-model="address"
        value="{{ old('address') }}"
        placeholder="Search property address..."
        autocomplete="off"
        class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-800 p-4 text-white">

    @error('address')
        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
    @enderror
</div>
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="text-slate-400">City</label>
                <input
                    id="city"
                    type="text"
                    name="city"
                    x-model="city"
                    value="{{ old('city') }}"
                    placeholder="Marilao"
                    class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white">
                @error('city')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-slate-400">Province</label>
                <input
                    id="province"
                    type="text"
                    name="province"
                    x-model="province"
                    value="{{ old('province') }}"
                    placeholder="Bulacan"
                    class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white">
                @error('province')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="text-slate-400">Postal Code</label>
                <input
                    id="postal_code"
                    type="text"
                    name="postal_code"
                    x-model="postal_code"
                    value="{{ old('postal_code') }}"
                    placeholder="3000"
                    class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white">
                @error('postal_code')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-slate-400">Country</label>
                <input
                    id="country"
                    type="text"
                    name="country"
                    x-model="country"
                    value="{{ old('country', 'Philippines') }}"
                    placeholder="Philippines"
                    class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white">
                @error('country')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="rounded-3xl border border-slate-700 bg-slate-950 p-6 text-center text-slate-400">
            <div class="text-6xl">🗺️</div>
            <p class="mt-4 font-semibold text-white">Map integration placeholder</p>
            <p class="mt-2 text-sm">Will show map results after API connection.</p>
        </div>

        <div id="map" class="h-96 rounded-3xl border border-slate-700 bg-slate-900"></div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="text-slate-400">Latitude</label>
                <input
                    id="latitude"
                    type="text"
                    name="latitude"
                    x-model="latitude"
                    value="{{ old('latitude') }}"
                    placeholder="Latitude"
                    class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white">
                @error('latitude')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-slate-400">Longitude</label>
                <input
                    type="text"
                    name="longitude"
                    x-model="longitude"
                    value="{{ old('longitude') }}"
                    placeholder="Longitude"
                    class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white">
                @error('longitude')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <input type="hidden" name="place_id" x-model="placeId" />

    </div>

    <script>
let map;
let marker;
let autocomplete;

window.initMap = function() {
    console.log('Google Maps initMap callback fired');

    const philippines = {
        lat: 14.5995,
        lng: 120.9842
    };

    map = new google.maps.Map(document.getElementById("map"), {
        center: philippines,
        zoom: 6,
    });

    marker = new google.maps.Marker({
        map,
        draggable: true,
        position: philippines
    });

    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById("autocomplete"),
        {
            componentRestrictions: {
                country: ["ph"]
            },
            fields: [
                "address_components",
                "formatted_address",
                "geometry",
                "place_id"
            ]
        }
    );

    autocomplete.addListener("place_changed", () => {

        const place = autocomplete.getPlace();

        if (!place.geometry) return;

        map.setCenter(place.geometry.location);
        map.setZoom(18);

        marker.setPosition(place.geometry.location);

        let city = "";
        let province = "";
        let postal = "";
        let country = "";

        place.address_components.forEach(component => {

            if (component.types.includes("locality")) {
                city = component.long_name;
            }

            if (component.types.includes("administrative_area_level_1")) {
                province = component.long_name;
            }

            if (component.types.includes("postal_code")) {
                postal = component.long_name;
            }

            if (component.types.includes("country")) {
                country = component.long_name;
            }

        });

        window.dispatchEvent(new CustomEvent('property-location-selected', {
            detail: {
                address: place.formatted_address,
                city,
                province,
                postalCode: postal,
                country,
                latitude: place.geometry.location.lat(),
                longitude: place.geometry.location.lng(),
                placeId: place.place_id,
            }
        }));

    });

    marker.addListener("dragend", () => {

        const pos = marker.getPosition();

        window.dispatchEvent(new CustomEvent('property-location-selected', {
            detail: { latitude: pos.lat(), longitude: pos.lng() }
        }));

    });

}
</script>
@push('scripts')
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places&callback=initMap"
    async
    defer>
</script>
@endpush
</div>
