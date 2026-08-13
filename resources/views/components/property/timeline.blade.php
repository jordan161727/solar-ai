@props(['property'])

@php
    $a = $property->solarAssessment;

    // Built from real timestamps only — no invented history.
    $events = collect([
        [
            'title' => 'Property created',
            'at' => $property->created_at,
            'icon' => 'plus',
            'tone' => 'muted',
        ],
        $a ? [
            'title' => 'Solar assessment completed',
            'at' => $a->created_at,
            'icon' => 'sun',
            'tone' => 'accent',
        ] : null,
        $a?->last_synced_at ? [
            'title' => 'Solar data synced',
            'at' => $a->last_synced_at,
            'icon' => 'sparkles',
            'tone' => 'muted',
        ] : null,
        $property->updated_at && $property->updated_at->ne($property->created_at) ? [
            'title' => 'Property updated',
            'at' => $property->updated_at,
            'icon' => 'settings',
            'tone' => 'muted',
        ] : null,
    ])->filter()->sortByDesc('at')->values();
@endphp

<div class="card overflow-hidden">

    <div class="border-b border-line px-5 py-4">
        <h2 class="text-sm font-medium text-content">Activity</h2>
    </div>

    <div class="p-5">

        <ol class="relative space-y-5 border-l border-line pl-6">

            @foreach($events as $event)
                <li class="relative">

                    <span class="absolute -left-[31px] grid h-[22px] w-[22px] place-items-center rounded-full ring-4 ring-surface
                                 {{ $event['tone'] === 'accent' ? 'bg-accent text-accent-contrast' : 'bg-surface-muted text-content-subtle' }}">
                        <x-ui.icon :name="$event['icon']" class="h-3 w-3" />
                    </span>

                    <p class="text-sm font-medium text-content">{{ $event['title'] }}</p>

                    <p class="mt-0.5 text-xs text-content-muted">
                        {{ $event['at']?->format('j M Y, g:i A') }}
                        <span class="text-content-subtle">· {{ $event['at']?->diffForHumans() }}</span>
                    </p>

                </li>
            @endforeach

        </ol>

    </div>

</div>
