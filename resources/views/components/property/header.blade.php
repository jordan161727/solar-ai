<div
    class="relative overflow-hidden rounded-3xl border border-slate-800 bg-gradient-to-r from-slate-900 via-slate-900 to-blue-950 p-10 shadow-2xl">

    <div class="absolute inset-0 opacity-10">

        <div class="h-full w-full bg-[linear-gradient(rgba(255,255,255,.08)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.08)_1px,transparent_1px)] bg-[size:32px_32px]"></div>

    </div>

    <div class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">

        <div>

            <span
                class="inline-flex items-center rounded-full bg-blue-500/20 px-4 py-2 text-sm font-medium text-cyan-300">

                🏡 Property Management

            </span>

            <h1
                class="mt-6 text-5xl font-black text-white">

                Properties

            </h1>

            <p
                class="mt-4 max-w-2xl text-lg text-slate-300">

                Manage every property, AI analysis, roof information,
                proposals and installations from one intelligent dashboard.

            </p>

        </div>

        <div>

            <a
                href="{{ route('properties.create') }}"
                class="inline-flex items-center gap-3 rounded-2xl bg-blue-600 px-8 py-4 text-lg font-semibold text-white shadow-lg transition duration-300 hover:scale-105 hover:bg-blue-500">

                ➕ Add Property

            </a>

        </div>

    </div>

</div>