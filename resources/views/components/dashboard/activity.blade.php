<div class="rounded-3xl border border-slate-800 bg-slate-900 shadow-xl">

    <!-- Header -->
    <div class="flex items-center justify-between border-b border-slate-800 p-6">

        <div>

            <h2 class="text-2xl font-bold text-white">
                Live Activity
            </h2>

            <p class="mt-1 text-slate-400">
                Latest actions across your platform
            </p>

        </div>

        <span
            class="rounded-full bg-emerald-500/20 px-4 py-2 text-sm font-medium text-emerald-400">

            Live

        </span>

    </div>

    <div class="relative p-8">

        <!-- Timeline Line -->
        <div class="absolute left-[39px] top-10 h-[80%] w-px bg-slate-700"></div>

        @foreach([
        [
            'icon'=>'🏠',
            'title'=>'New Property Added',
            'message'=>'Green Valley Residence was added.',
            'time'=>'2 min ago',
            'color'=>'bg-blue-500'
        ],
        [
            'icon'=>'🤖',
            'title'=>'AI Roof Analysis',
            'message'=>'Solar score generated (94%).',
            'time'=>'8 min ago',
            'color'=>'bg-cyan-500'
        ],
        [
            'icon'=>'📄',
            'title'=>'Proposal Generated',
            'message'=>'Proposal PDF is ready.',
            'time'=>'18 min ago',
            'color'=>'bg-green-500'
        ],
        [
            'icon'=>'💰',
            'title'=>'Payment Received',
            'message'=>'Client paid reservation fee.',
            'time'=>'42 min ago',
            'color'=>'bg-yellow-500'
        ],
        [
            'icon'=>'☀️',
            'title'=>'Installation Scheduled',
            'message'=>'Crew assigned for tomorrow.',
            'time'=>'1 hour ago',
            'color'=>'bg-orange-500'
        ]
        ] as $activity)

        <div class="relative mb-8 flex gap-6">

            <div
                class="z-10 flex h-10 w-10 items-center justify-center rounded-full {{ $activity['color'] }} shadow-lg">

                {{ $activity['icon'] }}

            </div>

            <div class="flex-1">

                <div
                    class="rounded-2xl border border-slate-800 bg-slate-800/60 p-5 transition duration-300 hover:border-blue-500 hover:bg-slate-800">

                    <div class="flex items-center justify-between">

                        <h3 class="font-semibold text-white">

                            {{ $activity['title'] }}

                        </h3>

                        <span
                            class="text-sm text-slate-500">

                            {{ $activity['time'] }}

                        </span>

                    </div>

                    <p class="mt-2 text-slate-400">

                        {{ $activity['message'] }}

                    </p>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>