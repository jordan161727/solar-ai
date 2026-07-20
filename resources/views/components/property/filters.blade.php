<div class="flex flex-wrap gap-3">

    @foreach([
        'All',
        'Verified',
        'Pending',
        'Inspection',
        'Proposal',
        'Installation',
        'Completed'
    ] as $status)

        <button
            class="rounded-full border border-slate-700 bg-slate-900 px-5 py-2 text-sm font-medium text-slate-300 transition hover:border-blue-500 hover:bg-blue-600 hover:text-white">

            {{ $status }}

        </button>

    @endforeach

</div>