<div
    class="relative overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-xl">

    <!-- Header -->
    <div class="flex items-center justify-between border-b border-slate-800 p-6">

        <div>

            <h2 class="text-2xl font-bold text-white">

                Live Property Map

            </h2>

            <p class="mt-1 text-sm text-slate-400">

                Monitor properties, installations and AI predictions.

            </p>

        </div>

        <div class="flex gap-3">

            <button
                class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-2 text-sm text-slate-300 transition hover:bg-slate-700">

                Satellite

            </button>

            <button
                class="rounded-xl border border-blue-500/30 bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-500">

                Full Screen

            </button>

        </div>

    </div>

    <!-- Map -->
    <div class="relative h-[730px] bg-slate-950">

        <!-- Replace this div with Google Maps later -->
        <div
            id="property-map"
            class="absolute inset-0">

            <div
                class="flex h-full items-center justify-center">

                <div class="text-center">

                    <div
                        class="mx-auto mb-6 flex h-28 w-28 items-center justify-center rounded-full bg-blue-500/10 text-6xl">

                        🌍

                    </div>

                    <h2
                        class="text-3xl font-bold text-white">

                        Interactive Map

                    </h2>

                    <p
                        class="mt-4 text-slate-400">

                        Google Maps / CesiumJS / Mapbox

                    </p>

                </div>

            </div>

        </div>

        <!-- Search -->
        <div
            class="absolute left-6 top-6 w-96">

            <input
                class="w-full rounded-2xl border border-slate-700 bg-slate-900/90 px-5 py-4 text-white backdrop-blur placeholder:text-slate-500 focus:border-blue-500 focus:outline-none"
                placeholder="Search address..."
                type="text">

        </div>

        <!-- Legend -->
        <div
            class="absolute bottom-6 left-6 rounded-2xl border border-slate-700 bg-slate-900/90 p-5 backdrop-blur">

            <h3 class="font-semibold text-white">

                Legend

            </h3>

            <div class="mt-4 space-y-3">

                <div class="flex items-center gap-3">

                    <div
                        class="h-4 w-4 rounded-full bg-green-500">

                    </div>

                    <span class="text-slate-300">

                        Installed

                    </span>

                </div>

                <div class="flex items-center gap-3">

                    <div
                        class="h-4 w-4 rounded-full bg-yellow-500">

                    </div>

                    <span class="text-slate-300">

                        Pending

                    </span>

                </div>

                <div class="flex items-center gap-3">

                    <div
                        class="h-4 w-4 rounded-full bg-red-500">

                    </div>

                    <span class="text-slate-300">

                        Needs Inspection

                    </span>

                </div>

            </div>

        </div>

        <!-- Quick Stats -->
        <div
            class="absolute right-6 top-6 w-72 space-y-4">

            <div
                class="rounded-2xl border border-slate-700 bg-slate-900/90 p-5 backdrop-blur">

                <p class="text-sm text-slate-400">

                    Active Properties

                </p>

                <h2
                    class="mt-2 text-4xl font-bold text-white">

                    1,284

                </h2>

                <p
                    class="mt-2 text-green-400">

                    ↑ 15%

                </p>

            </div>

            <div
                class="rounded-2xl border border-slate-700 bg-slate-900/90 p-5 backdrop-blur">

                <p class="text-sm text-slate-400">

                    AI Analysis

                </p>

                <h2
                    class="mt-2 text-4xl font-bold text-cyan-400">

                    96%

                </h2>

                <p
                    class="mt-2 text-slate-300">

                    Roof detection accuracy

                </p>

            </div>

        </div>

        <!-- Floating Property Card -->
        <div
            class="absolute bottom-6 right-6 w-96 rounded-3xl border border-slate-700 bg-slate-900/95 p-6 backdrop-blur">

            <div class="flex items-center justify-between">

                <div>

                    <h3
                        class="text-xl font-bold text-white">

                        Green Valley Residence

                    </h3>

                    <p
                        class="text-slate-400">

                        Marilao, Bulacan

                    </p>

                </div>

                <span
                    class="rounded-full bg-green-500/20 px-4 py-2 text-sm font-semibold text-green-400">

                    Verified

                </span>

            </div>

            <div
                class="mt-6 grid grid-cols-3 gap-4">

                <div>

                    <p class="text-xs text-slate-500">

                        Roof Area

                    </p>

                    <p class="font-semibold text-white">

                        145㎡

                    </p>

                </div>

                <div>

                    <p class="text-xs text-slate-500">

                        Solar Score

                    </p>

                    <p class="font-semibold text-yellow-400">

                        94%

                    </p>

                </div>

                <div>

                    <p class="text-xs text-slate-500">

                        Est. Savings

                    </p>

                    <p class="font-semibold text-green-400">

                        ₱2.4M

                    </p>

                </div>

            </div>

            <div
                class="mt-6 flex gap-3">

                <button
                    class="flex-1 rounded-xl bg-blue-600 py-3 font-semibold text-white transition hover:bg-blue-500">

                    Open Property

                </button>

                <button
                    class="rounded-xl border border-slate-700 bg-slate-800 px-5 text-white transition hover:bg-slate-700">

                    AI

                </button>

            </div>

        </div>

    </div>

</div>