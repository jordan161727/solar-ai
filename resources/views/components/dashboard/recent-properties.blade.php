<div class="rounded-3xl border border-slate-800 bg-slate-900 overflow-hidden shadow-xl">

    <!-- Header -->
    <div class="flex items-center justify-between border-b border-slate-800 px-8 py-6">

        <div>

            <h2 class="text-2xl font-bold text-white">
                Recent Properties
            </h2>

            <p class="mt-1 text-slate-400">
                Latest properties analyzed by AI
            </p>

        </div>

        <button
            class="rounded-xl border border-slate-700 bg-slate-800 px-5 py-2 text-white transition hover:bg-slate-700">

            View All

        </button>

    </div>

    <!-- Properties -->

    <div class="divide-y divide-slate-800">

        @foreach([
        [
            'name'=>'Green Valley Residence',
            'location'=>'Marilao, Bulacan',
            'status'=>'Verified',
            'score'=>94,
            'roof'=>'148㎡',
            'saving'=>'₱2.4M'
        ],
        [
            'name'=>'Sunrise Estate',
            'location'=>'Quezon City',
            'status'=>'Pending',
            'score'=>82,
            'roof'=>'126㎡',
            'saving'=>'₱1.9M'
        ],
        [
            'name'=>'Royal Garden',
            'location'=>'Pasig City',
            'status'=>'Inspection',
            'score'=>76,
            'roof'=>'132㎡',
            'saving'=>'₱1.6M'
        ],
        [
            'name'=>'Palm Heights',
            'location'=>'Taguig',
            'status'=>'Verified',
            'score'=>97,
            'roof'=>'180㎡',
            'saving'=>'₱3.2M'
        ],
        [
            'name'=>'Mountain View',
            'location'=>'Antipolo',
            'status'=>'Proposal',
            'score'=>88,
            'roof'=>'156㎡',
            'saving'=>'₱2.8M'
        ]
        ] as $property)

        <div
            class="group transition duration-300 hover:bg-slate-800/50">

            <div class="grid grid-cols-12 items-center gap-6 p-6">

                <!-- Image -->

                <div class="col-span-12 lg:col-span-1">

                    <div
                        class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 text-3xl shadow-lg">

                        🏡

                    </div>

                </div>

                <!-- Info -->

                <div class="col-span-12 lg:col-span-3">

                    <h3
                        class="text-lg font-semibold text-white">

                        {{ $property['name'] }}

                    </h3>

                    <p
                        class="mt-1 text-slate-400">

                        📍 {{ $property['location'] }}

                    </p>

                </div>

                <!-- Status -->

                <div class="col-span-6 lg:col-span-2">

                    @php

                        $color='bg-yellow-500';

                        $text='text-yellow-400';

                        if($property['status']=='Verified'){

                            $color='bg-green-500';

                            $text='text-green-400';

                        }

                        if($property['status']=='Inspection'){

                            $color='bg-red-500';

                            $text='text-red-400';

                        }

                        if($property['status']=='Proposal'){

                            $color='bg-blue-500';

                            $text='text-blue-400';

                        }

                    @endphp

                    <span
                        class="inline-flex items-center gap-2 rounded-full bg-slate-800 px-4 py-2">

                        <span
                            class="h-2 w-2 rounded-full {{ $color }}"></span>

                        <span
                            class="{{ $text }} font-medium">

                            {{ $property['status'] }}

                        </span>

                    </span>

                </div>

                <!-- AI Score -->

                <div class="col-span-6 lg:col-span-2">

                    <p class="text-sm text-slate-500">

                        AI Score

                    </p>

                    <div class="mt-2">

                        <div
                            class="h-2 overflow-hidden rounded-full bg-slate-700">

                            <div
                                class="h-full rounded-full bg-gradient-to-r from-green-400 to-cyan-400"
                                style="width:{{ $property['score'] }}%">

                            </div>

                        </div>

                    </div>

                    <p
                        class="mt-2 font-semibold text-green-400">

                        {{ $property['score'] }}%

                    </p>

                </div>

                <!-- Roof -->

                <div class="hidden lg:block">

                    <p
                        class="text-sm text-slate-500">

                        Roof Area

                    </p>

                    <p
                        class="mt-2 text-lg font-semibold text-white">

                        {{ $property['roof'] }}

                    </p>

                </div>

                <!-- Savings -->

                <div class="hidden lg:block">

                    <p
                        class="text-sm text-slate-500">

                        Est. Savings

                    </p>

                    <p
                        class="mt-2 text-lg font-semibold text-green-400">

                        {{ $property['saving'] }}

                    </p>

                </div>

                <!-- Actions -->

                <div
                    class="col-span-12 lg:col-span-2">

                    <div
                        class="flex justify-end gap-3">

                        <button
                            class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-2 text-white transition hover:bg-slate-700">

                            View

                        </button>

                        <button
                            class="rounded-xl bg-blue-600 px-4 py-2 font-medium text-white transition hover:bg-blue-500">

                            Analyze

                        </button>

                    </div>

                </div>

            </div>

        </div>

        @endforeach

    </div>

    <!-- Footer -->

    <div
        class="flex items-center justify-between border-t border-slate-800 px-8 py-5">

        <p
            class="text-slate-400">

            Showing

            <span class="font-semibold text-white">

                5

            </span>

            of

            <span class="font-semibold text-white">

                1,284

            </span>

            properties

        </p>

        <div class="flex gap-2">

            <button
                class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-2 text-white hover:bg-slate-700">

                Previous

            </button>

            <button
                class="rounded-xl bg-blue-600 px-4 py-2 text-white hover:bg-blue-500">

                Next

            </button>

        </div>

    </div>

</div>