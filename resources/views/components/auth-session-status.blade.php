@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-lg border border-success/25 bg-success-soft px-3.5 py-2.5 text-sm font-medium text-success']) }}>
        {{ $status }}
    </div>
@endif
