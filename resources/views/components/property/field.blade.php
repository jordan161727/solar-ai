@props([
    'name',
    'label',
    'type' => 'text',
    'model' => null,
    'placeholder' => null,
    'hint' => null,
    'required' => false,
])

<div>

    <label for="{{ $name }}" class="block text-sm font-medium text-content">
        {{ $label }}
        @unless($required)
            <span class="ml-1 text-xs font-normal text-content-subtle">optional</span>
        @endunless
    </label>

    <input
        id="{{ $name }}"
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name) }}"
        @if($model) x-model="{{ $model }}" @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'input mt-1.5 '.($errors->has($name) ? '!border-danger' : '')]) }}
    >

    @error($name)
        <p class="mt-1.5 text-sm text-danger">{{ $message }}</p>
    @else
        @if($hint)
            <p class="mt-1.5 text-xs text-content-subtle">{{ $hint }}</p>
        @endif
    @enderror

</div>
