@props([
    'size' => 'md',
    'showText' => true,
])

@php
    $mark = $size === 'lg' ? 'h-10 w-10' : 'h-8 w-8';
    $glyph = $size === 'lg' ? 'h-[22px] w-[22px]' : 'h-[18px] w-[18px]';
    $text = $size === 'lg' ? 'text-lg' : 'text-[15px]';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5']) }}>

    <span class="grid {{ $mark }} shrink-0 place-items-center rounded-lg bg-accent text-accent-contrast">
        <x-ui.icon name="sun" class="{{ $glyph }}" stroke-width="2" />
    </span>

    @if($showText)
        <span class="{{ $text }} font-semibold tracking-tight text-content">
            Solar<span class="text-accent">AI</span>
        </span>
    @endif

</span>
