@props(['filtered' => false])

<div class="card px-6 py-16 text-center">

    <div class="mx-auto grid h-11 w-11 place-items-center rounded-full bg-surface-muted">
        <x-ui.icon name="{{ $filtered ? 'search' : 'building' }}" class="h-5 w-5 text-content-subtle" />
    </div>

    @if($filtered)

        <h2 class="mt-4 text-sm font-medium text-content">No matching properties</h2>

        <p class="mx-auto mt-1 max-w-sm text-sm text-content-muted">
            Try a different search term, or clear the filters to see everything.
        </p>

        <a href="{{ route('properties.index') }}" class="btn btn-secondary btn-md mt-5">
            Clear filters
        </a>

    @else

        <h2 class="mt-4 text-sm font-medium text-content">No properties yet</h2>

        <p class="mx-auto mt-1 max-w-sm text-sm text-content-muted">
            Add your first property to run a solar assessment and generate a proposal.
        </p>

        <a href="{{ route('properties.create') }}" class="btn btn-primary btn-md mt-5">
            <x-ui.icon name="plus" class="h-4 w-4" />
            Add property
        </a>

    @endif

</div>
