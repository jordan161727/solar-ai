@props(['total' => 0])

<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

    <div>
        <h1 class="text-display text-content">Properties</h1>

        <p class="mt-1 text-sm text-content-muted">
            {{ number_format($total) }} {{ Str::plural('property', $total) }} in your portfolio
        </p>
    </div>

    <a href="{{ route('properties.create') }}" class="btn btn-primary btn-md">
        <x-ui.icon name="plus" class="h-4 w-4" />
        Add property
    </a>

</div>
