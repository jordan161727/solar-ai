@props([
    'score' => 0,
    'breakdown' => [],
])

@php
    $score = (int) $score;

    // Donut geometry — r=54 keeps the 12px ring inside a 128px box.
    $radius = 54;
    $circumference = 2 * M_PI * $radius;
    $offset = $circumference * (1 - min(max($score, 0), 100) / 100);

    $rating = match (true) {
        $score >= 85 => 'Excellent',
        $score >= 70 => 'Good',
        $score >= 50 => 'Moderate',
        $score > 0   => 'Low',
        default      => 'No data',
    };
@endphp

<div class="card card-pad flex flex-col">

    <div>
        <h2 class="text-sm font-medium text-content">Average solar score</h2>
        <p class="mt-0.5 text-xs text-content-muted">Across all assessments</p>
    </div>

    <div class="flex flex-1 items-center justify-center py-5">

        <div class="relative h-32 w-32">

            <svg viewBox="0 0 128 128" class="h-32 w-32 -rotate-90">

                <circle
                    cx="64" cy="64" r="{{ $radius }}"
                    fill="none"
                    stroke="rgb(var(--color-surface-muted))"
                    stroke-width="12"
                />

                <circle
                    cx="64" cy="64" r="{{ $radius }}"
                    fill="none"
                    stroke="rgb(var(--color-accent))"
                    stroke-width="12"
                    stroke-linecap="round"
                    stroke-dasharray="{{ round($circumference, 2) }}"
                    stroke-dashoffset="{{ round($offset, 2) }}"
                />

            </svg>

            <div class="absolute inset-0 grid place-items-center">
                <div class="text-center">
                    <p class="text-2xl font-semibold tabular tracking-tight text-content">{{ $score }}</p>
                    <p class="text-[11px] text-content-subtle">{{ $rating }}</p>
                </div>
            </div>

        </div>

    </div>

    @if($breakdown)
        <div class="space-y-2.5 border-t border-line pt-4">

            @foreach($breakdown as $row)
                <div class="flex items-center gap-3">

                    <x-status-badge :status="$row['status']" class="w-[104px] shrink-0 justify-center" />

                    <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-surface-muted">
                        <div
                            class="h-full rounded-full {{ match($row['status']) {
                                'Completed' => 'bg-success',
                                'Analyzing' => 'bg-info',
                                default     => 'bg-warning',
                            } }}"
                            style="width:{{ $row['percent'] }}%"
                        ></div>
                    </div>

                    <span class="w-9 shrink-0 text-right text-xs tabular text-content-muted">
                        {{ $row['percent'] }}%
                    </span>

                </div>
            @endforeach

        </div>
    @endif

</div>
