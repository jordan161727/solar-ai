<aside
    {{ $attributes->merge(['class' => 'flex h-full w-60 shrink-0 flex-col border-r border-line bg-surface']) }}
>

    {{-- Brand --}}
    <div class="flex h-14 shrink-0 items-center px-4">
        <a href="{{ route('dashboard') }}" class="rounded-lg">
            <x-brand />
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-4">

        @foreach(config('navigation') as $section)

            <div>

                <p class="eyebrow px-2.5 pb-1.5">
                    {{ $section['group'] }}
                </p>

                <div class="space-y-0.5">

                    @foreach($section['items'] as $item)

                        @php
                            // Routes are matched by prefix so child pages
                            // (properties.show, properties.edit…) stay highlighted.
                            $exists = Route::has($item['url']);
                            $base = explode('.', $item['url'])[0];
                            $active = $exists && (request()->routeIs($item['url']) || request()->routeIs($base.'.*'));
                        @endphp

                        <a
                            href="{{ $exists ? route($item['url']) : '#' }}"
                            @if($active) aria-current="page" @endif
                            class="group flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm transition-colors
                                   {{ $active
                                        ? 'bg-accent-soft font-medium text-accent'
                                        : 'text-content-muted hover:bg-surface-muted hover:text-content' }}"
                        >
                            <x-ui.icon
                                :name="$item['icon']"
                                class="h-[18px] w-[18px] shrink-0 {{ $active ? 'text-accent' : 'text-content-subtle group-hover:text-content-muted' }}"
                            />

                            <span class="truncate">{{ $item['title'] }}</span>
                        </a>

                    @endforeach

                </div>

            </div>

        @endforeach

    </nav>

    {{-- Footer card --}}
    <div class="shrink-0 border-t border-line p-3">

        <div class="rounded-lg border border-line bg-surface-muted p-3">

            <div class="flex items-center gap-2">
                <x-ui.icon name="bolt" class="h-4 w-4 text-accent" />
                <p class="text-xs font-medium text-content">Free plan</p>
            </div>

            <p class="mt-1.5 text-xs leading-relaxed text-content-muted">
                50 of 100 AI analyses used this month.
            </p>

            <div class="mt-2.5 h-1 overflow-hidden rounded-full bg-line">
                <div class="h-full rounded-full bg-accent" style="width:50%"></div>
            </div>

            @if(Route::has('billing'))
                <a href="{{ route('billing') }}" class="btn btn-secondary btn-sm mt-3 w-full">
                    Upgrade
                </a>
            @endif

        </div>

    </div>

</aside>
