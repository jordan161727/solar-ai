<x-app-layout title="Properties">

    <div class="space-y-5">

        <x-property.header :total="$stats['totalProperties']" />

        <x-property.stats :stats="$stats" />

        <x-property.search :search="$search" :status="$status" />

        @if($properties->isEmpty())

            <x-property.empty-state :filtered="$search !== '' || $status" />

        @else

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

                @foreach($properties as $property)
                    <x-property.card :property="$property" />
                @endforeach

            </div>

            <x-property.pagination :properties="$properties" />

        @endif

    </div>

</x-app-layout>
