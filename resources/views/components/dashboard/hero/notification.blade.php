<div x-data="{open:false}" class="relative">

    <button
        @click="open=!open"
        class="relative flex h-12 w-12 items-center justify-center rounded-xl bg-slate-800 border border-slate-700 hover:bg-slate-700">

        🔔

        <span
            class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white">

            3

        </span>

    </button>

    <div
        x-show="open"
        @click.outside="open=false"
        x-transition
        class="absolute right-0 mt-3 w-80 rounded-2xl border border-slate-700 bg-slate-900 shadow-2xl z-50">

        <div class="p-5 border-b border-slate-700">

            <h3 class="font-bold text-white">

                Notifications

            </h3>

        </div>

        <div class="divide-y divide-slate-800">

            <div class="p-4 hover:bg-slate-800">
                🤖 AI Analysis Completed
            </div>

            <div class="p-4 hover:bg-slate-800">
                📄 Proposal Generated
            </div>

            <div class="p-4 hover:bg-slate-800">
                🏠 New Property Added
            </div>

        </div>

    </div>

</div>