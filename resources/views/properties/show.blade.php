<x-app-layout :title="$property->property_name ?: 'Property'">

<div class="space-y-5">

    <x-property.show-header :property="$property" />

    {{-- Solar analytics --}}
    <x-property.analytics :property="$property" />

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">

        <div class="xl:col-span-7 space-y-4">
            <x-property.details :property="$property" />
            <x-property.map :property="$property" />
        </div>

        <div class="xl:col-span-5 space-y-4">
            <x-property.ai-panel :property="$property" />
            <x-property.timeline :property="$property" />
        </div>

    </div>

</div>

</x-app-layout>
