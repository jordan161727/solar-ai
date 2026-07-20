@props(['property'])

<div class="rounded-3xl bg-gradient-to-br from-indigo-900 via-blue-900 to-cyan-900 p-8 shadow-2xl">

    <div class="flex items-center justify-between">

        <h2 class="text-3xl font-black text-white">
            🤖 AI Recommendation
        </h2>

        <div class="rounded-full bg-green-500 px-4 py-2 text-white">
            98%
        </div>

    </div>

    <div class="mt-8 space-y-6">

        <div class="flex justify-between">
            <span class="text-slate-300">Roof Quality</span>
            <span class="text-yellow-400 text-xl">★★★★★</span>
        </div>

        <div class="flex justify-between">
            <span class="text-slate-300">Recommended Panels</span>
            <span class="font-bold text-white">20 Panels</span>
        </div>

        <div class="flex justify-between">
            <span class="text-slate-300">Expected Savings</span>
            <span class="font-bold text-green-400">₱2.4M</span>
        </div>

        <div class="flex justify-between">
            <span class="text-slate-300">ROI</span>
            <span class="font-bold text-cyan-400">5.3 Years</span>
        </div>

        <div class="flex justify-between">
            <span class="text-slate-300">Confidence</span>
            <span class="font-bold text-white">98%</span>
        </div>

    </div>

    <button
        class="mt-10 w-full rounded-2xl bg-cyan-500 py-4 font-bold text-white transition hover:bg-cyan-400 hover:scale-105">

        🚀 Generate AI Proposal

    </button>

</div>