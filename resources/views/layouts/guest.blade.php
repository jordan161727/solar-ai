@props([
    'title' => null,
    'heading' => null,
    'subheading' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <x-app-head :title="$title" />
</head>

<body class="h-full font-sans">

<div class="flex min-h-full">

    {{-- ── Form side ─────────────────────────────────────────────── --}}
    <div class="flex w-full flex-col px-6 py-8 lg:w-[46%] lg:px-12 xl:px-20">

        <div class="flex shrink-0 items-center justify-between">
            <a href="/" class="rounded-lg">
                <x-brand />
            </a>

            <x-theme-toggle />
        </div>

        <div class="flex flex-1 items-center justify-center py-10">

            <div class="w-full max-w-[22rem] rise">

                @if($heading)
                    <h1 class="text-display text-content">{{ $heading }}</h1>
                @endif

                @if($subheading)
                    <p class="mt-1.5 text-sm text-content-muted">{{ $subheading }}</p>
                @endif

                <div class="{{ $heading ? 'mt-7' : '' }}">
                    {{ $slot }}
                </div>

            </div>

        </div>

        <p class="shrink-0 text-center text-xs text-content-subtle lg:text-left">
            &copy; {{ date('Y') }} Solar AI · San Jose Del Monte, Bulacan
        </p>

    </div>

    {{-- ── Brand side ────────────────────────────────────────────── --}}
    <div class="relative hidden overflow-hidden bg-surface-muted lg:block lg:w-[54%]">

        {{-- Warm wash suggesting sunlight, kept low-contrast --}}
        <div class="absolute inset-0 bg-gradient-to-br from-accent/[0.12] via-transparent to-accent/[0.05]"></div>

        {{-- Blueprint grid --}}
        <div
            class="absolute inset-0 opacity-[0.5] dark:opacity-[0.35]"
            style="
                background-image:
                    linear-gradient(to right, rgb(var(--color-border)) 1px, transparent 1px),
                    linear-gradient(to bottom, rgb(var(--color-border)) 1px, transparent 1px);
                background-size: 56px 56px;
                mask-image: radial-gradient(ellipse 80% 70% at 50% 40%, #000 40%, transparent 100%);
                -webkit-mask-image: radial-gradient(ellipse 80% 70% at 50% 40%, #000 40%, transparent 100%);
            "
        ></div>

        <div class="relative flex h-full flex-col justify-between p-12 xl:p-16">

            <div class="max-w-md">

                <span class="badge bg-accent-soft text-accent">
                    <x-ui.icon name="sparkles" class="h-3.5 w-3.5" />
                    AI-assisted solar assessment
                </span>

                <h2 class="mt-6 text-3xl font-semibold leading-tight tracking-tight text-content xl:text-[2.5rem] xl:leading-[1.15]">
                    Know a roof's solar
                    <span class="text-accent">potential</span>
                    before you visit it.
                </h2>

                <p class="mt-4 max-w-sm text-[15px] leading-relaxed text-content-muted">
                    Solar AI scores rooftops from satellite imagery and local weather,
                    then turns the numbers into a client-ready proposal.
                </p>

            </div>

            {{-- Sample readout — gives the panel a product feel without faking a full UI --}}
            <div class="max-w-md">

                <div class="card card-pad">

                    <div class="flex items-start justify-between gap-4">

                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-content">Rest House 78</p>
                            <p class="mt-0.5 flex items-center gap-1 truncate text-xs text-content-muted">
                                <x-ui.icon name="location" class="h-3.5 w-3.5 shrink-0" />
                                San Jose Del Monte, Bulacan
                            </p>
                        </div>

                        <span class="badge shrink-0 bg-success-soft text-success">Assessed</span>

                    </div>

                    <dl class="mt-5 grid grid-cols-3 gap-4">

                        @foreach([
                            ['Solar score', '84', '/100'],
                            ['System', '39.6', 'kW'],
                            ['Savings', '780K', '₱/yr'],
                        ] as [$label, $value, $unit])
                            <div>
                                <dt class="text-[11px] text-content-subtle">{{ $label }}</dt>
                                <dd class="mt-1 text-lg font-semibold tabular tracking-tight text-content">
                                    {{ $value }}<span class="ml-0.5 text-xs font-normal text-content-subtle">{{ $unit }}</span>
                                </dd>
                            </div>
                        @endforeach

                    </dl>

                    <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-surface-muted">
                        <div class="h-full rounded-full bg-accent" style="width:84%"></div>
                    </div>

                </div>

                <div class="mt-6 flex items-center gap-6 text-xs text-content-muted">
                    <span class="flex items-center gap-1.5">
                        <x-ui.icon name="bolt" class="h-4 w-4 text-accent" />
                        Google Solar API
                    </span>
                    <span class="flex items-center gap-1.5">
                        <x-ui.icon name="leaf" class="h-4 w-4 text-success" />
                        CO&#8322; offset modelling
                    </span>
                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>
