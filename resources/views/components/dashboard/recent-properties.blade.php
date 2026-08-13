@props(['properties'])

<div class="card overflow-hidden">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4 border-b border-line px-5 py-4">

        <div>
            <h2 class="text-sm font-medium text-content">Recent properties</h2>
            <p class="mt-0.5 text-xs text-content-muted">Latest additions to your pipeline</p>
        </div>

        @if(Route::has('properties.index'))
            <a href="{{ route('properties.index') }}" class="btn btn-secondary btn-sm">
                View all
            </a>
        @endif

    </div>

    @if($properties->isEmpty())

        <div class="px-5 py-14 text-center">

            <div class="mx-auto grid h-10 w-10 place-items-center rounded-full bg-surface-muted">
                <x-ui.icon name="building" class="h-5 w-5 text-content-subtle" />
            </div>

            <p class="mt-3 text-sm font-medium text-content">No properties yet</p>
            <p class="mt-1 text-sm text-content-muted">Add a property to run its first solar assessment.</p>

            @if(Route::has('properties.create'))
                <a href="{{ route('properties.create') }}" class="btn btn-primary btn-md mt-4">
                    <x-ui.icon name="plus" class="h-4 w-4" />
                    Add property
                </a>
            @endif

        </div>

    @else

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead>
                    <tr class="border-b border-line text-left">
                        <th class="eyebrow px-5 py-2.5 font-medium">Property</th>
                        <th class="eyebrow px-5 py-2.5 font-medium">Customer</th>
                        <th class="eyebrow px-5 py-2.5 font-medium">Status</th>
                        <th class="eyebrow px-5 py-2.5 text-right font-medium">Score</th>
                        <th class="eyebrow px-5 py-2.5 text-right font-medium">Est. savings</th>
                        <th class="eyebrow px-5 py-2.5 text-right font-medium">Added</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-line">

                    @foreach($properties as $property)

                        @php
                            $assessment = $property->solarAssessment;
                            $customer = $property->customer;
                        @endphp

                        <tr class="transition-colors hover:bg-surface-muted/60">

                            {{-- Property --}}
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">

                                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-surface-muted">
                                        <x-ui.icon name="building" class="h-4 w-4 text-content-subtle" />
                                    </span>

                                    <div class="min-w-0">
                                        @if(Route::has('properties.show'))
                                            <a href="{{ route('properties.show', $property) }}"
                                               class="block truncate rounded font-medium text-content transition-colors hover:text-accent">
                                                {{ $property->property_name ?: 'Untitled property' }}
                                            </a>
                                        @else
                                            <p class="truncate font-medium text-content">
                                                {{ $property->property_name ?: 'Untitled property' }}
                                            </p>
                                        @endif

                                        <p class="mt-0.5 truncate text-xs text-content-muted">
                                            {{ collect([$property->city, $property->province])->filter()->implode(', ') ?: $property->address }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            {{-- Customer --}}
                            <td class="whitespace-nowrap px-5 py-3 text-content-muted">
                                {{ $customer ? trim($customer->first_name.' '.$customer->last_name) : '—' }}
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-3">
                                <x-status-badge :status="$property->status" />
                            </td>

                            {{-- Score --}}
                            <td class="px-5 py-3 text-right">
                                @if($assessment)
                                    <div class="flex items-center justify-end gap-2">
                                        <div class="hidden h-1.5 w-14 overflow-hidden rounded-full bg-surface-muted sm:block">
                                            <div class="h-full rounded-full bg-accent" style="width:{{ $assessment->solar_score }}%"></div>
                                        </div>
                                        <span class="tabular font-medium text-content">{{ $assessment->solar_score }}</span>
                                    </div>
                                @else
                                    <span class="text-content-subtle">—</span>
                                @endif
                            </td>

                            {{-- Savings --}}
                            <td class="whitespace-nowrap px-5 py-3 text-right tabular font-medium text-content">
                                {{ $assessment ? '₱'.number_format($assessment->estimated_savings) : '—' }}
                            </td>

                            {{-- Added --}}
                            <td class="whitespace-nowrap px-5 py-3 text-right text-content-muted">
                                {{ $property->created_at?->diffForHumans(short: true) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>
