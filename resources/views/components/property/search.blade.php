@props([
    'search' => '',
    'status' => null,
])

@php
    $tabs = [
        ['label' => 'All', 'value' => null],
        ['label' => 'Pending', 'value' => 'Pending'],
        ['label' => 'Analyzing', 'value' => 'Analyzing'],
        ['label' => 'Completed', 'value' => 'Completed'],
    ];
@endphp

<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

    {{-- Status filter — plain links so the state stays in the URL and is shareable --}}
    <div class="flex flex-wrap items-center gap-1 rounded-lg border border-line bg-surface p-1">

        @foreach($tabs as $tab)
            @php
                $active = $status === $tab['value'];
                $query = array_filter([
                    'q' => $search !== '' ? $search : null,
                    'status' => $tab['value'],
                ]);
            @endphp

            <a
                href="{{ route('properties.index', $query) }}"
                @if($active) aria-current="page" @endif
                class="rounded-md px-3 py-1.5 text-sm font-medium transition-colors
                       {{ $active
                            ? 'bg-accent-soft text-accent'
                            : 'text-content-muted hover:bg-surface-muted hover:text-content' }}"
            >
                {{ $tab['label'] }}
            </a>
        @endforeach

    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('properties.index') }}" class="flex items-center gap-2">

        @if($status)
            <input type="hidden" name="status" value="{{ $status }}">
        @endif

        <div class="relative w-full sm:w-64">

            <x-ui.icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-content-subtle" />

            <input
                type="search"
                name="q"
                value="{{ $search }}"
                placeholder="Search name, address or owner…"
                class="input h-9 !pl-9"
                aria-label="Search properties"
            >

        </div>

        <button type="submit" class="btn btn-secondary btn-sm">Search</button>

        @if($search !== '')
            <a href="{{ route('properties.index', array_filter(['status' => $status])) }}"
               class="btn btn-ghost btn-sm"
               aria-label="Clear search">
                <x-ui.icon name="close" class="h-4 w-4" />
            </a>
        @endif

    </form>

</div>
