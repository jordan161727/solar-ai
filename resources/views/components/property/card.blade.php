@props(['property'])

<div
    class="group overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 transition duration-300 hover:-translate-y-2 hover:border-blue-500 hover:shadow-2xl">

    <div
        class="relative h-52 bg-gradient-to-br from-blue-600 via-cyan-500 to-indigo-600">

        <div
            class="absolute inset-0 flex items-center justify-center text-7xl">

            🏡

        </div>

        <div
            class="absolute top-4 right-4 rounded-full bg-green-500 px-3 py-1 text-xs font-bold text-white">

            VERIFIED

        </div>

    </div>

    <div class="p-6">

        <h2 class="text-2xl font-bold text-white">

            {{ $property->address ?? 'Green Valley Residence' }}

        </h2>

        <p class="mt-2 text-slate-400">

            📍 {{ $property->city ?? 'Marilao' }},
            {{ $property->province ?? 'Bulacan' }},
               {{ $property->barangay ?? '1' }}

        </p>

        <div class="mt-6 grid grid-cols-2 gap-4">

            <div>

                <p class="text-xs text-slate-500">

                    Solar Score

                </p>

                <p class="text-xl font-bold text-green-400">

                    {{ $property->solar_score ?? 94 }}%

                </p>

            </div>

            <div>

                <p class="text-xs text-slate-500">

                    Roof Area

                </p>

                <p class="text-xl font-bold text-white">

                    {{ $property->roof_area ?? 145 }}㎡

                </p>

            </div>

        </div>

        <div class="mt-6">

            <div
                class="h-2 overflow-hidden rounded-full bg-slate-700">

                <div
                    class="h-full w-[94%] rounded-full bg-gradient-to-r from-green-400 to-cyan-400">

                </div>

            </div>

        </div>

        <div class="mt-8 flex gap-3">

            <button
                class="flex-1 rounded-xl bg-blue-600 py-3 font-semibold text-white hover:bg-blue-500">

                View

            </button>

            <button
                class="rounded-xl border border-slate-700 px-5 text-white hover:bg-slate-800">

                Edit

            </button>

        </div>

    </div>

</div>