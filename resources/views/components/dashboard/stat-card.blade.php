@props([
    'title',
    'value',
    'change' => null,
    'icon' => 'chart',
    'caption' => 'vs last month',
])

@php
    // A leading "-" is the only signal needed to flip direction.
    $negative = $change !== null && str_starts_with(trim($change), '-');
@endphp

<div class="card card-pad">

    <div class="flex items-start justify-between gap-3">

        <p class="text-sm text-content-muted">{{ $title }}</p>

        <x-ui.icon :name="$icon" class="h-4 w-4 shrink-0 text-content-subtle" />

    </div>

    <p class="mt-3 text-metric tabular text-content">
        {{ $value }}
    </p>

    @if($change)
        <div class="mt-2 flex items-center gap-1.5">

            <span class="badge {{ $negative ? 'bg-danger-soft text-danger' : 'bg-success-soft text-success' }}">
                <x-ui.icon :name="$negative ? 'arrow-down' : 'arrow-up'" class="h-3 w-3" />
                {{ ltrim($change, '+-') }}
            </span>

            <span class="text-xs text-content-subtle">{{ $caption }}</span>

        </div>
    @endif

</div>
