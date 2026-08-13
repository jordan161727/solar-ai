<button
    type="button"
    x-data="{ dark: document.documentElement.classList.contains('dark') }"
    x-on:click="dark = !dark; window.setTheme(dark ? 'dark' : 'light')"
    x-bind:aria-label="dark ? 'Switch to light mode' : 'Switch to dark mode'"
    x-bind:title="dark ? 'Switch to light mode' : 'Switch to dark mode'"
    {{ $attributes->merge(['class' => 'btn btn-ghost btn-sm !px-2']) }}
>
    <x-ui.icon name="sun" class="h-[18px] w-[18px]" x-show="!dark" x-cloak />
    <x-ui.icon name="moon" class="h-[18px] w-[18px]" x-show="dark" x-cloak />
</button>
