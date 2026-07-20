<div class="rounded-3xl border border-slate-800 bg-slate-900 shadow-xl">
    <div class="border-b border-slate-800 p-6">
        <h2 class="text-2xl font-bold text-white">📍 Google Maps</h2>
        <p class="mt-2 text-slate-400">Preview the property location or fetch coordinates using the map service.</p>
    </div>

    <div class="p-6 grid gap-6 lg:grid-cols-2">
        <div class="rounded-3xl border border-slate-700 bg-slate-950 p-6">
            <div class="h-80 rounded-3xl bg-slate-900 p-4">
                <div class="flex h-full flex-col items-center justify-center text-slate-500">
                    <span class="text-6xl">🗺️</span>
                    <p class="mt-4 text-white">Google Maps placeholder</p>
                    <p class="mt-2 text-sm">Swap this with your Maps API embed or map component.</p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-700 bg-slate-950 p-6 space-y-5">
            <div class="space-y-2">
                <p class="text-sm text-slate-400">Address</p>
                <div class="rounded-2xl border border-slate-700 bg-slate-900 p-4 text-slate-200" x-text="address || 'Enter the address in Step 3'" />
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="space-y-2">
                    <p class="text-sm text-slate-400">Latitude</p>
                    <div class="rounded-2xl border border-slate-700 bg-slate-900 p-4 text-slate-200" x-text="latitude || 'Not set'" />
                </div>
                <div class="space-y-2">
                    <p class="text-sm text-slate-400">Longitude</p>
                    <div class="rounded-2xl border border-slate-700 bg-slate-900 p-4 text-slate-200" x-text="longitude || 'Not set'" />
                </div>
            </div>

            <div class="space-y-2">
                <p class="text-sm text-slate-400">Place ID</p>
                <div class="rounded-2xl border border-slate-700 bg-slate-900 p-4 text-slate-200" x-text="placeId || 'Not provided'" />
            </div>

            <button
                type="button"
                @click="lookupCoordinates()"
                class="w-full rounded-2xl bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-500">
                Lookup coordinates
            </button>

            <p class="text-sm text-slate-400" x-text="mapMessage"></p>
        </div>
    </div>
</div>