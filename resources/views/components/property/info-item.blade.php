@props([
    'label',
    'value',
    'icon' => '📌'
])

<div
    class="rounded-2xl border border-slate-800 bg-slate-950 p-5 transition duration-300 hover:border-blue-500 hover:shadow-xl hover:-translate-y-1">

    <div class="flex items-start gap-4">

        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-800 text-2xl">

            {{ $icon }}

        </div>

        <div>

            <p class="text-sm text-slate-400">

                {{ $label }}

            </p>

            <h4 class="mt-1 text-lg font-bold text-white break-words">

                {{ $value }}

            </h4>

        </div>

    </div>

</div>