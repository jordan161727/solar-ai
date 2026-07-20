@props(['property'])

<div class="rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl overflow-hidden">

    <!-- Header -->
    <div class="border-b border-slate-800 bg-gradient-to-r from-slate-900 to-slate-800 p-6">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-3xl font-black text-white">
                    🏡 Property Information
                </h2>

                <p class="mt-2 text-slate-400">
                    Complete information about this property.
                </p>

            </div>

            <div class="rounded-2xl bg-blue-600/20 px-5 py-3">

                <span class="text-sm text-blue-300">
                    Property ID
                </span>

                <h3 class="mt-1 text-xl font-bold text-white">
                    #{{ $property->id }}
                </h3>

            </div>

        </div>

    </div>

    <!-- Body -->
    <div class="p-8 space-y-8">

        <!-- Owner -->
        <div>

            <h3 class="mb-5 text-xl font-bold text-cyan-400 flex items-center gap-2">
                👤 Owner Information
            </h3>

            <div class="grid gap-5 md:grid-cols-2">

                <x-property.info-item
                    label="Owner Name"
                    :value="$property->customer?->first_name . ' ' . $property->customer?->last_name ?? $property->owner_name ?? 'Juan Dela Cruz'"
                    icon="👤"/>

                <x-property.info-item
                    label="Email"
                    :value="$property->customer?->email ?? $property->email ?? 'owner@email.com'"
                    icon="📧"/>

                <x-property.info-item
                    label="Phone"
                    :value="$property->customer?->phone ?? $property->phone ?? '+63 912 345 6789'"
                    icon="📱"/>

                <x-property.info-item
                    label="Status"
                    :value="$property->status ?? 'Verified'"
                    icon="✅"/>

            </div>

        </div>

        <!-- Property -->
        <div>

            <h3 class="mb-5 text-xl font-bold text-green-400 flex items-center gap-2">
                🏠 Property Details
            </h3>

            <div class="grid gap-5 md:grid-cols-2">

                <x-property.info-item
                    label="Property Name"
                    :value="$property->property_name"
                    icon="🏡"/>

                <x-property.info-item
                    label="Property Type"
                    :value="$property->property_type"
                    icon="🏢"/>

                <x-property.info-item
                    label="City"
                    :value="$property->city"
                    icon="📍"/>

                <x-property.info-item
                    label="Province"
                    :value="$property->province"
                    icon="🌎"/>

            </div>

        </div>

        <!-- Roof -->
        <div>

            <h3 class="mb-5 text-xl font-bold text-yellow-400 flex items-center gap-2">
                ☀ Roof Information
            </h3>

            <div class="grid gap-5 md:grid-cols-3">

                <x-property.info-item
                    label="Roof Area"
                    :value="($property->roof_area ?? 145).' m²'"
                    icon="📐"/>

                <x-property.info-item
                    label="Roof Pitch"
                    :value="($property->roof_pitch ?? 25).'°'"
                    icon="📏"/>

                <x-property.info-item
                    label="Roof Material"
                    :value="$property->roof_material ?? 'Metal'"
                    icon="🧱"/>

            </div>

        </div>

        <!-- Solar -->
        <div>

            <h3 class="mb-5 text-xl font-bold text-orange-400 flex items-center gap-2">
                ⚡ Solar Analysis
            </h3>

            <div class="grid gap-5 md:grid-cols-2">

                <x-property.info-item
                    label="Solar Score"
                    :value="($property->solar_score ?? 94).'%'"
                    icon="☀️"/>

                <x-property.info-item
                    label="Estimated Savings"
                    :value="'₱ '.number_format($property->estimated_savings ?? 2400000)"
                    icon="💰"/>

                <x-property.info-item
                    label="Energy Production"
                    :value="($property->estimated_generation ?? 12500).' kWh'"
                    icon="⚡"/>

                <x-property.info-item
                    label="Created"
                    :value="$property->created_at?->format('F d, Y') ?? now()->format('F d, Y')"
                    icon="📅"/>

            </div>

        </div>

    </div>

</div>