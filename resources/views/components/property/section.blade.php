@props([
    'title',
    'description' => null,
])

<div class="card overflow-hidden">

    <div class="border-b border-line px-5 py-4">

        <h2 class="text-sm font-medium text-content">{{ $title }}</h2>

        @if($description)
            <p class="mt-0.5 text-sm text-content-muted">{{ $description }}</p>
        @endif

    </div>

    <div class="p-5">
        {{ $slot }}
    </div>

</div>
