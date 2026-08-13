<x-app-layout title="Dashboard">

@php
    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');

    $compact = function ($amount) {
        if ($amount >= 1_000_000) return '₱'.number_format($amount / 1_000_000, 1).'M';
        if ($amount >= 1_000)     return '₱'.number_format($amount / 1_000, 1).'K';
        return '₱'.number_format($amount);
    };
@endphp

<div class="space-y-5">

    {{-- Page header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-display text-content">
                {{ $greeting }}{{ $user ? ', '.explode(' ', $user->name)[0] : '' }}
            </h1>
            <p class="mt-1 text-sm text-content-muted">
                {{ $stats['todayProjects'] }} {{ Str::plural('property', $stats['todayProjects']) }} added today ·
                {{ now()->format('l, j F Y') }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            @if(Route::has('reports'))
                <a href="{{ route('reports') }}" class="btn btn-secondary btn-md">
                    <x-ui.icon name="chart" class="h-4 w-4" />
                    Reports
                </a>
            @endif

            @if(Route::has('properties.create'))
                <a href="{{ route('properties.create') }}" class="btn btn-primary btn-md">
                    <x-ui.icon name="plus" class="h-4 w-4" />
                    Add property
                </a>
            @endif
        </div>

    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rise">
            <x-dashboard.stat-card
                title="Total properties"
                :value="number_format($stats['properties'])"
                change="+12%"
                icon="building"
            />
        </div>

        <div class="rise delay-1">
            <x-dashboard.stat-card
                title="Assessed"
                :value="number_format($stats['verified'])"
                change="+8%"
                icon="sun"
            />
        </div>

        <div class="rise delay-2">
            <x-dashboard.stat-card
                title="Awaiting analysis"
                :value="number_format($stats['pending'])"
                change="-2%"
                icon="sparkles"
            />
        </div>

        <div class="rise delay-3">
            <x-dashboard.stat-card
                title="Projected savings"
                :value="$compact($stats['savings'])"
                change="+18%"
                icon="card"
            />
        </div>

    </div>

    {{-- Trend + score --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

        <div class="lg:col-span-2">
            <x-dashboard.trend-chart :series="$series" />
        </div>

        <x-dashboard.solar-score
            :score="$stats['solarScore']"
            :breakdown="$statusBreakdown"
        />

    </div>

    {{-- Secondary metrics --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        <x-dashboard.stat-card
            title="Annual generation"
            :value="number_format($stats['generation'] / 1000, 1).' MWh'"
            icon="bolt"
            :change="null"
        />

        <x-dashboard.stat-card
            title="Customers"
            :value="number_format($stats['customers'])"
            icon="user"
            :change="null"
        />

        <x-dashboard.stat-card
            title="CO₂ offset"
            :value="number_format($stats['generation'] * 0.7 / 1000, 1).' t'"
            icon="leaf"
            :change="null"
        />

    </div>

    {{-- Recent properties --}}
    <x-dashboard.recent-properties :properties="$recentProperties" />

</div>

</x-app-layout>
