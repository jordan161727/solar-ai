@props(['status'])

@php
    $styles = [
        'Completed' => 'bg-success-soft text-success',
        'Analyzing' => 'bg-info-soft text-info',
        'Pending'   => 'bg-warning-soft text-warning',
    ];

    $dots = [
        'Completed' => 'bg-success',
        'Analyzing' => 'bg-info',
        'Pending'   => 'bg-warning',
    ];

    $style = $styles[$status] ?? 'bg-surface-muted text-content-muted';
    $dot = $dots[$status] ?? 'bg-content-subtle';
@endphp

<span {{ $attributes->merge(['class' => 'badge '.$style]) }}>
    <span class="h-1.5 w-1.5 rounded-full {{ $dot }}"></span>
    {{ $status }}
</span>
