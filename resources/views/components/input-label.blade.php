@props(['value' => null])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-content']) }}>
    {{ $value ?? $slot }}
</label>
