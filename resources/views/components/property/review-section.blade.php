<div class="rounded-3xl border border-slate-800 bg-slate-900 shadow-xl">
    <div class="border-b border-slate-800 p-6">
        <h2 class="text-2xl font-bold text-white">✅ Review Property</h2>
        <p class="mt-2 text-slate-400">Confirm the entered details before creating the property.</p>
    </div>

    <div class="p-6 space-y-6">
        <div class="rounded-3xl border border-slate-700 bg-slate-950 p-6">
            <h3 class="text-lg font-semibold text-white">Owner</h3>
            <p class="mt-3 text-slate-300" x-text="ownerName || 'No owner name provided'"></p>
            <p class="text-sm text-slate-500" x-text="ownerEmail || 'No email provided'"></p>
            <p class="text-sm text-slate-500" x-text="ownerPhone || 'No phone provided'"></p>
        </div>

        <div class="rounded-3xl border border-slate-700 bg-slate-950 p-6">
            <h3 class="text-lg font-semibold text-white">Property</h3>
            <p class="mt-3 text-slate-300" x-text="propertyName || 'No property name provided'"></p>
            <p class="text-sm text-slate-500" x-text="`Status: ${status || 'Pending'}`"></p>
        </div>

        <div class="rounded-3xl border border-slate-700 bg-slate-950 p-6">
            <h3 class="text-lg font-semibold text-white">Address</h3>
            <p class="mt-3 text-slate-300" x-text="address || 'No address entered'"></p>
            <p class="text-sm text-slate-500" x-text="`${city || '—'}, ${province || '—'} ${postal_code || ''}`"></p>
            <p class="text-sm text-slate-500" x-text="country || 'Philippines'"></p>
            <p class="text-sm text-slate-500" x-text="`Lat: ${latitude || 'unset'} | Lng: ${longitude || 'unset'}`"></p>
        </div>
    </div>
</div>