@props(['property'])

<div class="rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl overflow-hidden">

    <!-- Header -->
    <div class="flex items-center justify-between border-b border-slate-800 p-6">

        <div>
            <h2 class="text-2xl font-bold text-white">
                📍 Property Location
            </h2>

            <p class="mt-1 text-slate-400">
                Google Maps integration ready
            </p>
        </div>

        <span class="rounded-full bg-blue-500/20 px-4 py-2 text-sm text-cyan-300">
            Google Maps API
        </span>

    </div>

    <div class="p-6">

        <!-- Map -->
        <div class="relative h-96 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-800 via-slate-900 to-blue-900">

            <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,.04)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.04)_1px,transparent_1px)] bg-[size:40px_40px]"></div>

            <div class="absolute inset-0 flex flex-col items-center justify-center">

                <div class="text-8xl animate-bounce">
                    🗺️
                </div>

                <h3 class="mt-6 text-3xl font-black text-white">
                    Google Maps Placeholder
                </h3>

                <p class="mt-2 text-slate-400">
                    Interactive Map Coming Soon
                </p>

            </div>

        </div>

        <!-- Coordinates -->

        <div class="mt-8 grid gap-6 md:grid-cols-2">

            <div class="rounded-2xl bg-slate-950 p-5 border border-slate-800">

                <p class="text-sm text-slate-400">
                    Latitude
                </p>

                <h3 class="mt-2 text-xl font-bold text-white">
                    {{ $property->latitude ?? '14.8134' }}
                </h3>

            </div>

            <div class="rounded-2xl bg-slate-950 p-5 border border-slate-800">

                <p class="text-sm text-slate-400">
                    Longitude
                </p>

                <h3 class="mt-2 text-xl font-bold text-white">
                    {{ $property->longitude ?? '120.9481' }}
                </h3>

            </div>

        </div>

    </div>

</div>