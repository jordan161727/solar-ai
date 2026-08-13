@props([
    'label',
    'value' => null,
])

<div class="min-w-0">

    <dt class="text-xs text-content-subtle">{{ $label }}</dt>

    <dd class="mt-1 break-words text-sm font-medium text-content">
        {{ filled($value) ? $value : '—' }}
    </dd>

</div>
