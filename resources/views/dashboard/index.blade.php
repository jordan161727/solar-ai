<x-app-layout>

<div class="space-y-8">

    {{-- ===========================================
        HERO
    ============================================ --}}
    <x-dashboard.hero :stats="$stats" />

    {{-- ===========================================
        QUICK OVERVIEW
    ============================================ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <x-dashboard.stat-card
            title="Properties"
            :value="$stats['properties']"
            change="+12%"
            color="blue"
            icon="🏠"
        />

        <x-dashboard.stat-card
            title="Verified"
            :value="$stats['verified']"
            change="+8%"
            color="green"
            icon="✅"
        />

        <x-dashboard.stat-card
            title="Pending AI"
            :value="$stats['pending']"
            change="-2%"
            color="yellow"
            icon="🤖"
        />

        <x-dashboard.stat-card
            title="Savings"
            :value="'₱ '.number_format($stats['savings'])"
            change="+18%"
            color="purple"
            icon="💰"
        />

    </div>

    {{-- ===========================================
        SOLAR ANALYTICS
    ============================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <x-dashboard.hero.analytics />

        <x-dashboard.hero.solar-gauge
            :score="$stats['solarScore']"
        />

        <x-dashboard.hero.weather />

    </div>

    {{-- ===========================================
        MAP + AI PANEL
    ============================================ --}}
    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 xl:col-span-8">

            <x-dashboard.map-preview />

        </div>

        <div class="col-span-12 xl:col-span-4 space-y-6">

            <x-dashboard.ai-widget />

            <x-dashboard.activity />

        </div>

    </div>

    {{-- ===========================================
        REVENUE + TIMELINE
    ============================================ --}}
    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 xl:col-span-8">

            <x-dashboard.revenue-chart />

        </div>

        {{-- <div class="col-span-12 xl:col-span-4">

            <x-dashboard.hero.ai-insight />

        </div> --}}

    </div>

    {{-- ===========================================
        RECENT PROPERTIES
    ============================================ --}}
    <x-dashboard.recent-properties />

</div>

</x-app-layout>