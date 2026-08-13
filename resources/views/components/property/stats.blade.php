@props(['stats'])

<div class="grid grid-cols-2 gap-4 xl:grid-cols-4">

    <x-dashboard.stat-card
        title="Total properties"
        :value="number_format($stats['totalProperties'])"
        icon="building"
        :change="null"
    />

    <x-dashboard.stat-card
        title="Assessed"
        :value="number_format($stats['completedProperties'])"
        icon="sun"
        :change="null"
    />

    <x-dashboard.stat-card
        title="Awaiting analysis"
        :value="number_format($stats['pendingProperties'])"
        icon="sparkles"
        :change="null"
    />

    <x-dashboard.stat-card
        title="Average score"
        :value="$stats['averageScore']"
        icon="chart"
        :change="null"
    />

</div>
