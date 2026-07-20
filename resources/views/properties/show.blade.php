<x-app-layout>

<div class="mx-auto max-w-7xl space-y-8 py-8">

    {{-- Header --}}
    <x-property.show-header :property="$property"/>

    {{-- Property Gallery --}}
    <x-property.gallery :property="$property"/>

    {{-- Property Information --}}
    <x-property.details :property="$property"/>

    {{-- Map + AI --}}
    <div class="grid grid-cols-1 gap-8 xl:grid-cols-12">

        <div class="xl:col-span-7">
            <x-property.map :property="$property"/>
        </div>

        <div class="xl:col-span-5">
            <x-property.ai-panel :property="$property"/>
        </div>

    </div>

    {{-- Analytics + Timeline --}}
    <div class="grid grid-cols-1 gap-8 xl:grid-cols-12">

        <div class="xl:col-span-7">
            <x-property.analytics :property="$property"/>
        </div>

        <div class="xl:col-span-5">
            <x-property.timeline :property="$property"/>
        </div>

    </div>

</div>

</x-app-layout>