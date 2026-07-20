<x-app-layout>

    <div class="space-y-8">

        <x-property.header />

        <x-property.search />

        <x-property.stats />

        <x-property.filters />

        <div class="grid gap-8 sm:grid-cols-2 xl:grid-cols-3">

            @forelse($properties as $property)

                <x-property.card :property="$property"/>

            @empty

                <div class="col-span-full">

                 <x-property.empty-state />

                </div>

            @endforelse

        </div>

        <x-property.pagination :properties="$properties"/>

    </div>

</x-app-layout>