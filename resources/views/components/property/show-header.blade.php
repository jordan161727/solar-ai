@props(['property'])

<div class="rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-cyan-900 p-8 shadow-xl">

    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

        <div>

            <a href="{{ route('properties.index') }}"
               class="text-slate-300 hover:text-white">

                ← Back to Properties

            </a>

            <h1 class="mt-4 text-4xl font-black text-white">

                {{ $property->property_name }}

            </h1>

            <p class="mt-2 text-slate-300">

                📍 {{ $property->address }}

            </p>

        </div>

        <div class="text-right">

            <span class="rounded-full bg-green-500/20 px-5 py-2 text-green-300">

                {{ $property->status }}

            </span>

            <div class="mt-4">

                <div class="text-slate-300">

                    AI Solar Score

                </div>

                <div class="text-5xl font-black text-green-400">

                    {{ $property->solar_score }}%

                </div>

            </div>

        </div>

    </div>

</div>