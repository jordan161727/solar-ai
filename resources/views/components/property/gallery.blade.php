@props(['property'])

<div class="rounded-3xl border border-slate-800 bg-slate-900 p-6">

    <h2 class="text-2xl font-bold text-white">

        📷 Property Gallery

    </h2>

    <div class="mt-6">

        <div class="flex h-96 items-center justify-center rounded-3xl bg-gradient-to-br from-blue-700 to-cyan-500">

            <div class="text-center">

                <div class="text-8xl">

                    🏡

                </div>

                <p class="mt-4 text-white">

                    Main Property Image

                </p>

            </div>

        </div>

    </div>

    <div class="mt-6 grid grid-cols-4 gap-4">

        @for($i=0;$i<4;$i++)

        <div class="flex h-20 items-center justify-center rounded-2xl bg-slate-800">

            🖼️

        </div>

        @endfor

    </div>

</div>