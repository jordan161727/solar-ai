@props([
    'series',
    'title' => 'Properties added',
    'subtitle' => 'Last 6 months',
])

@php
    $points = collect($series)->values();
    $count = max($points->count(), 1);
    $max = max($points->max('value') ?: 0, 1);

    // Fixed drawing space; the SVG stretches to the card via preserveAspectRatio="none".
    // vector-effect keeps strokes an even weight despite that non-uniform scaling.
    $w = 600;
    $h = 180;
    $padY = 16;

    $coords = $points->map(function ($point, $index) use ($count, $max, $w, $h, $padY) {
        $x = $count > 1 ? ($index / ($count - 1)) * $w : $w / 2;
        $y = $h - $padY - (($point['value'] / $max) * ($h - $padY * 2));

        return ['x' => round($x, 2), 'y' => round($y, 2)] + $point;
    });

    $line = $coords->map(fn ($c) => $c['x'].','.$c['y'])->implode(' ');
    $area = $line.' '.$w.','.$h.' 0,'.$h;

    $total = $points->sum('value');
@endphp

<div class="card flex flex-col">

    <div class="flex items-start justify-between gap-4 border-b border-line px-5 py-4">

        <div>
            <h2 class="text-sm font-medium text-content">{{ $title }}</h2>
            <p class="mt-0.5 text-xs text-content-muted">{{ $subtitle }}</p>
        </div>

        <div class="text-right">
            <p class="text-xl font-semibold tabular tracking-tight text-content">{{ number_format($total) }}</p>
            <p class="text-xs text-content-subtle">total</p>
        </div>

    </div>

    <div class="flex-1 px-2 pt-5">

        <svg
            viewBox="0 0 {{ $w }} {{ $h }}"
            preserveAspectRatio="none"
            class="h-40 w-full overflow-visible text-accent"
            role="img"
            aria-label="{{ $title }}, {{ $subtitle }}"
        >
            <defs>
                <linearGradient id="trendFill" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="currentColor" stop-opacity="0.18" />
                    <stop offset="100%" stop-color="currentColor" stop-opacity="0" />
                </linearGradient>
            </defs>

            {{-- Baselines --}}
            @foreach([0.25, 0.5, 0.75] as $fraction)
                <line
                    x1="0" x2="{{ $w }}"
                    y1="{{ $h * $fraction }}" y2="{{ $h * $fraction }}"
                    stroke="rgb(var(--color-border))"
                    stroke-width="1"
                    vector-effect="non-scaling-stroke"
                />
            @endforeach

            <polygon points="{{ $area }}" fill="url(#trendFill)" />

            <polyline
                points="{{ $line }}"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                vector-effect="non-scaling-stroke"
            />

            @foreach($coords as $c)
                <circle
                    cx="{{ $c['x'] }}" cy="{{ $c['y'] }}" r="3"
                    fill="rgb(var(--color-surface))"
                    stroke="currentColor"
                    stroke-width="2"
                    vector-effect="non-scaling-stroke"
                >
                    <title>{{ $c['label'] }}: {{ $c['value'] }}</title>
                </circle>
            @endforeach
        </svg>

        <div class="mt-2 flex justify-between px-1 pb-4">
            @foreach($coords as $c)
                <span class="text-[11px] text-content-subtle">{{ $c['label'] }}</span>
            @endforeach
        </div>

    </div>

</div>
