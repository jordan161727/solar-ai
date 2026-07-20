@props([
    'title',
    'value',
    'change',
    'icon',
    'color' => 'blue'
])

@php

$colors = [

    'blue' => 'from-blue-500 to-cyan-500',

    'green' => 'from-green-500 to-emerald-500',

    'yellow' => 'from-yellow-500 to-orange-500',

    'purple' => 'from-purple-500 to-pink-500',

];

@endphp

<div
    class="group relative overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 p-6 shadow-xl transition duration-300 hover:-translate-y-2 hover:shadow-2xl">

    <div class="absolute inset-0 opacity-0 group-hover:opacity-10 transition bg-gradient-to-r {{ $colors[$color] }}"></div>

    <div class="relative">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-slate-400">

                    {{ $title }}

                </p>

                <h2 class="mt-3 text-4xl font-black text-white">

                    {{ $value }}

                </h2>

            </div>

            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-r {{ $colors[$color] }} text-3xl shadow-lg">

                {{ $icon }}

            </div>

        </div>

        <div class="mt-6 flex items-center justify-between">

            <span class="rounded-full bg-green-500/20 px-3 py-1 text-sm text-green-400">

                {{ $change }}

            </span>

            <span class="text-sm text-slate-500">

                This Month

            </span>

        </div>

    </div>

</div>