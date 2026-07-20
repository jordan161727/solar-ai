@props(['stats'])

@php
    $hour = now()->hour;

    if ($hour < 12) {
        $greeting = "Good Morning";
    } elseif ($hour < 18) {
        $greeting = "Good Afternoon";
    } else {
        $greeting = "Good Evening";
    }

    function formatMoney($amount)
    {
        if ($amount >= 1000000) {
            return '₱'.number_format($amount / 1000000,1).'M';
        }

        if ($amount >= 1000) {
            return '₱'.number_format($amount / 1000,1).'K';
        }

        return '₱'.number_format($amount);
    }
@endphp

<div
    class="relative overflow-hidden rounded-3xl border border-slate-800 bg-gradient-to-br from-slate-900 via-slate-900 to-blue-950 shadow-2xl transition-all duration-500 hover:shadow-cyan-500/20">

    {{-- Background --}}
    <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-blue-500/20 blur-3xl animate-pulse"></div>

    <div class="absolute bottom-0 left-0 h-64 w-64 rounded-full bg-cyan-500/10 blur-3xl"></div>

    <div
        class="absolute inset-0 opacity-[0.04]"
        style="background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:40px 40px;">
    </div>

    <div class="relative z-10 p-10">

        <div class="flex flex-col lg:flex-row lg:justify-between gap-10">

            {{-- LEFT --}}
            <div class="max-w-3xl">

                <div class="inline-flex items-center gap-2 rounded-full border border-emerald-500/20 bg-emerald-500/10 px-4 py-2">

                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>

                    <span class="text-sm font-medium text-emerald-300">

                        AI System Online

                    </span>

                </div>

                <h1 class="mt-6 text-5xl font-black tracking-tight text-white">

                    {{ $greeting }},

                    <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">

                        {{ auth()->user()->name }}

                    </span>

                    👋

                </h1>

                <p class="mt-3 text-slate-400">

                    {{ now()->format('l, F d, Y') }}

                    •

                    <span id="live-clock"></span>

                </p>

                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">

                    Manage

                    <span class="font-semibold text-cyan-400">

                        {{ number_format($stats['properties']) }}

                    </span>

                    properties, monitor

                    <span class="font-semibold text-green-400">

                        {{ $stats['verified'] }}

                    </span>

                    solar installations and generate AI-powered proposals with

                    <span class="font-semibold text-yellow-400">

                        {{ number_format($stats['generation']) }} kWh

                    </span>

                    estimated energy generation.

                </p>

                {{-- Buttons --}}
                <div class="mt-8 flex flex-wrap gap-4">

                    <a
                        href="{{ route('properties.index') }}"
                        class="rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white transition hover:-translate-y-1 hover:bg-blue-500 hover:shadow-xl hover:shadow-blue-500/30">

                        🔍 Search Property

                    </a>

                    <a
                        href="{{ route('properties.create') }}"
                        class="rounded-xl border border-slate-700 bg-slate-800/60 px-6 py-3 font-semibold text-slate-200 transition hover:bg-slate-700">

                        ➕ Add Property

                    </a>

                    <a
                        href="#"
                        class="rounded-xl border border-slate-700 bg-slate-800/60 px-6 py-3 font-semibold text-slate-200 transition hover:bg-slate-700">

                        📄 Generate Proposal

                    </a>

                </div>

                {{-- AI Insight --}}
                <div class="mt-8 rounded-2xl border border-cyan-500/20 bg-cyan-500/10 p-6">

                    <div class="flex flex-col gap-4 lg:flex-row lg:justify-between lg:items-center">

                        <div>

                            <p class="font-semibold text-cyan-300">

                                🤖 AI Insight

                            </p>

                            <h3 class="mt-2 text-2xl font-bold text-white">

                                {{ $stats['pending'] }} properties are waiting for AI analysis.

                            </h3>

                            <p class="mt-2 text-slate-300">

                                Estimated Savings

                                <span class="font-semibold text-green-400">

                                    {{ formatMoney($stats['savings']) }}

                                </span>

                            </p>

                        </div>

                        <a
                            href="{{ route('properties.index') }}"
                            class="rounded-xl bg-cyan-500 px-6 py-3 font-semibold text-white transition hover:bg-cyan-400">

                            Analyze Now →

                        </a>

                    </div>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="grid w-full max-w-md grid-cols-2 gap-4">

                @foreach([
                    ['Today\'s Projects',$stats['todayProjects'],'↑ Today','emerald'],
                    ['AI Accuracy',$stats['solarScore'].'%','Excellent','cyan'],
                    ['Customers',number_format($stats['customers']),'Active','green'],
                    ['Revenue',formatMoney($stats['savings']),'This Month','orange']
                ] as $card)

                <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-5 backdrop-blur transition hover:-translate-y-1 hover:border-cyan-500">

                    <p class="text-sm text-slate-400">

                        {{ $card[0] }}

                    </p>

                    <h2 class="mt-3 text-4xl font-bold text-white">

                        {{ $card[1] }}

                    </h2>

                    <p class="mt-2 text-sm text-{{ $card[3] }}-400">

                        {{ $card[2] }}

                    </p>

                </div>

                @endforeach

            </div>

        </div>

        {{-- Bottom Stats --}}
        <div class="mt-10 grid grid-cols-2 gap-6 border-t border-slate-800 pt-8 lg:grid-cols-4">

            <div class="flex items-center gap-3">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/10">🏠</div>

                <div>

                    <p class="text-sm text-slate-400">Properties</p>

                    <p class="font-bold text-white">{{ number_format($stats['properties']) }}</p>

                </div>

            </div>

            <div class="flex items-center gap-3">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-500/10">☀️</div>

                <div>

                    <p class="text-sm text-slate-400">Verified</p>

                    <p class="font-bold text-green-400">{{ $stats['verified'] }}</p>

                </div>

            </div>

            <div class="flex items-center gap-3">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-500/10">⚡</div>

                <div>

                    <p class="text-sm text-slate-400">Generation</p>

                    <p class="font-bold text-yellow-400">{{ number_format($stats['generation']) }} kWh</p>

                </div>

            </div>

            <div class="flex items-center gap-3">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-500/10">💰</div>

                <div>

                    <p class="text-sm text-slate-400">Savings</p>

                    <p class="font-bold text-purple-400">{{ formatMoney($stats['savings']) }}</p>

                </div>

            </div>

        </div>

    </div>

</div>

@once
<script>
function updateClock(){
    const clock=document.getElementById('live-clock');
    if(clock){
        clock.innerHTML=new Date().toLocaleTimeString();
    }
}
updateClock();
setInterval(updateClock,1000);
</script>
@endonce