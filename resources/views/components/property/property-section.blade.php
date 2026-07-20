<div class="rounded-3xl border border-slate-800 bg-slate-900 shadow-xl">

    {{-- Header --}}
    <div class="border-b border-slate-800 p-6">
        <h2 class="text-2xl font-bold text-white">
            🏡 Property Information
        </h2>

        <p class="mt-2 text-slate-400">
            Basic information about the property.
        </p>
    </div>

    <div class="space-y-6 p-6">

        <div>
            <label class="mb-2 block text-slate-300">
                Property Name
            </label>

            <input
                type="text"
                name="property_name"
                x-model="propertyName"
                value="{{ old('property_name') }}"
                placeholder="Green Valley Residence"
                class="w-full rounded-2xl border border-slate-700 bg-slate-950 p-4 text-white focus:border-blue-500 focus:outline-none">

            @error('property_name')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <input type="hidden" name="status" x-model="status" value="Pending">

    </div>

</div>
