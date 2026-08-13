@props([
    'property',
    'assessment',
    'layout',
])

@php
    $imageUrl = route('map.image', [
        'lat' => $layout['center_lat'],
        'lng' => $layout['center_lng'],
        'zoom' => $layout['zoom'],
        'scale' => $layout['scale'],
        'w' => $layout['request_width'],
        'h' => $layout['request_height'],
        'pin' => 0,
    ]);

    $w = $layout['width'];
    $h = $layout['height'];
    $pw = $layout['panel_width_px'];
    $ph = $layout['panel_height_px'];
@endphp

<div class="card overflow-hidden">

    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-line px-4 py-3">

        <div class="flex items-center gap-2">
            <x-ui.icon name="sun" class="h-4 w-4 text-accent" />
            <h2 class="text-sm font-medium text-content">Panel layout</h2>
        </div>

        <div class="flex items-center gap-3 text-xs text-content-muted">

            <span class="flex items-center gap-1.5">
                <span class="h-2.5 w-2.5 rounded-[2px] bg-accent"></span>
                Selected
            </span>

            <span class="flex items-center gap-1.5">
                <span class="h-2.5 w-2.5 rounded-[2px] border border-white/60 bg-white/10"></span>
                Available
            </span>

        </div>

    </div>

    {{-- Canvas --}}
    <div class="relative bg-surface-muted">

        <div class="relative mx-auto" style="width:{{ $w }}px;max-width:100%;aspect-ratio:{{ $w }}/{{ $h }};">

            <img
                src="{{ $imageUrl }}"
                alt="Satellite view of {{ $property->property_name ?: 'the property' }}"
                width="{{ $w }}"
                height="{{ $h }}"
                class="absolute inset-0 h-full w-full object-cover"
                loading="lazy"
            >

            {{-- Panels are drawn in the same coordinate space as the image --}}
            <svg
                viewBox="0 0 {{ $w }} {{ $h }}"
                class="absolute inset-0 h-full w-full"
                role="img"
                aria-label="{{ count($layout['panels']) }} solar panels on the roof"
            >
                @foreach($layout['panels'] as $panel)
                    <g transform="translate({{ $panel['x'] }} {{ $panel['y'] }}) rotate({{ $panel['rotation'] }})">
                        <rect
                            x="{{ round(-$pw / 2, 2) }}"
                            y="{{ round(-$ph / 2, 2) }}"
                            width="{{ $pw }}"
                            height="{{ $ph }}"
                            rx="1"
                            {{-- Alpine flips the fill as the slider moves --}}
                            x-bind:fill="{{ $panel['index'] }} < panels ? 'rgb(217 119 6 / 0.85)' : 'rgb(255 255 255 / 0.12)'"
                            x-bind:stroke="{{ $panel['index'] }} < panels ? 'rgb(255 255 255 / 0.9)' : 'rgb(255 255 255 / 0.5)'"
                            stroke-width="0.75"
                        >
                            <title>Panel {{ $panel['index'] + 1 }} — {{ number_format($panel['yearly_kwh']) }} kWh/yr</title>
                        </rect>
                    </g>
                @endforeach
            </svg>

            {{-- Scale bar --}}
            <div class="absolute bottom-3 left-3 flex items-center gap-2 rounded bg-slate-900/70 px-2 py-1 backdrop-blur-sm">
                <span class="block h-[3px] rounded-full bg-white/90" style="width:{{ $layout['scale_bar_px'] }}px"></span>
                <span class="text-[11px] font-medium text-white">5 m</span>
            </div>

            {{-- Imagery credit --}}
            <div class="absolute bottom-3 right-3 rounded bg-slate-900/70 px-2 py-1 text-[11px] text-white/90 backdrop-blur-sm">
                Imagery &copy; Google
                @if($assessment->imagery_date)
                    · {{ $assessment->imagery_date->format('M Y') }}
                @endif
            </div>

        </div>

    </div>

    {{-- Size control --}}
    <div class="border-t border-line px-4 py-4">

        <div class="flex items-baseline justify-between gap-4">
            <label for="panel-count" class="text-sm font-medium text-content">System size</label>

            <p class="text-sm text-content-muted">
                <span class="font-semibold tabular text-content" x-text="panels"></span>
                of {{ count($layout['panels']) }} panels
            </p>
        </div>

        <input
            id="panel-count"
            type="range"
            min="1"
            max="{{ count($layout['panels']) }}"
            step="1"
            x-model.number="panels"
            class="mt-3 h-1.5 w-full cursor-pointer appearance-none rounded-full bg-surface-muted accent-accent"
        >

        <div class="mt-1.5 flex justify-between text-[11px] text-content-subtle">
            <span>1 panel</span>
            <span>{{ count($layout['panels']) }} panels (max)</span>
        </div>

    </div>

</div>
