@props(['properties'])

@if($properties->hasPages())

    <div class="flex items-center justify-between gap-4">

        <p class="text-sm text-content-muted">
            Showing
            <span class="font-medium text-content tabular">{{ $properties->firstItem() }}</span>–<span
                class="font-medium text-content tabular">{{ $properties->lastItem() }}</span>
            of
            <span class="font-medium text-content tabular">{{ number_format($properties->total()) }}</span>
        </p>

        <div class="flex gap-2">

            @if($properties->onFirstPage())
                <span class="btn btn-secondary btn-sm cursor-not-allowed opacity-50">Previous</span>
            @else
                <a href="{{ $properties->previousPageUrl() }}" rel="prev" class="btn btn-secondary btn-sm">Previous</a>
            @endif

            @if($properties->hasMorePages())
                <a href="{{ $properties->nextPageUrl() }}" rel="next" class="btn btn-secondary btn-sm">Next</a>
            @else
                <span class="btn btn-secondary btn-sm cursor-not-allowed opacity-50">Next</span>
            @endif

        </div>

    </div>

@endif
