@props(['stats'])

<div
    class="rounded-3xl border border-cyan-500/20 bg-gradient-to-r from-cyan-500/10 to-blue-500/10 p-6 backdrop-blur">

    <div class="flex items-center justify-between">

        <div>

            <p class="text-cyan-300 font-semibold">

                🤖 AI Insight

            </p>

            <h2 class="mt-2 text-2xl font-bold text-white">

                {{ $stats['pending'] }} properties are ready for AI analysis.

            </h2>

            <p class="mt-3 text-slate-300">

                Estimated savings:

                <span class="font-bold text-green-400">

                    ₱{{ number_format($stats['savings']) }}

                </span>

            </p>

        </div>

        <button
            class="rounded-xl bg-cyan-500 px-5 py-3 font-semibold text-white hover:bg-cyan-400">

            Analyze →

        </button>

    </div>

</div>