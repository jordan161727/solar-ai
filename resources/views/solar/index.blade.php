<x-app-layout title="Solar Designer">

<div class="space-y-5">

    <div>
        <h1 class="text-display text-content">Solar Designer</h1>
        <p class="mt-1 text-sm text-content-muted">
            Pick a property to lay panels out on its roof and size the system.
        </p>
    </div>

    @if($properties->isEmpty())

        <div class="card px-6 py-16 text-center">

            <div class="mx-auto grid h-11 w-11 place-items-center rounded-full bg-surface-muted">
                <x-ui.icon name="sun" class="h-5 w-5 text-content-subtle" />
            </div>

            <h2 class="mt-4 text-sm font-medium text-content">Nothing to design yet</h2>

            <p class="mx-auto mt-1 max-w-sm text-sm text-content-muted">
                Add a property with an address — coordinates are captured automatically
                and the roof analysis runs on save.
            </p>

            <a href="{{ route('properties.create') }}" class="btn btn-primary btn-md mt-5">
                <x-ui.icon name="plus" class="h-4 w-4" />
                Add property
            </a>

        </div>

    @else

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

            @foreach($properties as $property)

                @php
                    $a = $property->solarAssessment;
                    $ready = $a && filled($a->panel_layout);
                @endphp

                <a
                    href="{{ route('solar.design', $property) }}"
                    class="card group flex flex-col overflow-hidden transition-colors hover:border-line-strong"
                >

                    {{-- Satellite thumbnail --}}
                    <img
                        src="{{ route('map.image', ['lat' => $property->latitude, 'lng' => $property->longitude, 'zoom' => 20, 'size' => 'small', 'pin' => 0]) }}"
                        alt=""
                        class="h-32 w-full bg-surface-muted object-cover"
                        loading="lazy"
                    >

                    <div class="flex flex-1 flex-col p-4">

                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-content transition-colors group-hover:text-accent">
                                    {{ $property->property_name ?: 'Untitled property' }}
                                </p>
                                <p class="mt-0.5 truncate text-xs text-content-muted">
                                    {{ collect([$property->city, $property->province])->filter()->implode(', ') }}
                                </p>
                            </div>

                            @if($ready)
                                <span class="badge shrink-0 bg-accent-soft text-accent tabular">
                                    {{ count($a->panel_layout) }} panels
                                </span>
                            @else
                                <span class="badge shrink-0 bg-surface-muted text-content-muted">No analysis</span>
                            @endif

                        </div>

                        @if($ready)
                            <dl class="mt-4 grid grid-cols-3 gap-3 border-t border-line pt-3">

                                <div>
                                    <dt class="text-[11px] text-content-subtle">System</dt>
                                    <dd class="mt-0.5 text-sm font-semibold tabular text-content">
                                        {{ number_format($a->system_size_kw, 1) }} kW
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-[11px] text-content-subtle">Annual</dt>
                                    <dd class="mt-0.5 text-sm font-semibold tabular text-content">
                                        {{ number_format($a->annual_generation / 1000, 1) }} MWh
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-[11px] text-content-subtle">Score</dt>
                                    <dd class="mt-0.5 text-sm font-semibold tabular text-content">
                                        {{ $a->solar_score }}
                                    </dd>
                                </div>

                            </dl>
                        @else
                            <p class="mt-auto pt-3 text-xs text-content-muted">
                                Open to run the roof analysis.
                            </p>
                        @endif

                    </div>

                </a>

            @endforeach

        </div>

    @endif

</div>

</x-app-layout>
