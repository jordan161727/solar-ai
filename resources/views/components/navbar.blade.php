@props(['title' => null])

<header class="sticky top-0 z-30 flex h-14 shrink-0 items-center gap-3 border-b border-line bg-surface/85 px-4 backdrop-blur-sm lg:px-6">

    {{-- Mobile sidebar trigger — toggles the drawer owned by the layout --}}
    <button
        type="button"
        x-on:click="sidebarOpen = true"
        class="btn btn-ghost btn-sm !px-2 lg:hidden"
        aria-label="Open navigation"
    >
        <x-ui.icon name="menu" class="h-[18px] w-[18px]" />
    </button>

    @if($title)
        <h1 class="hidden text-sm font-medium text-content sm:block">{{ $title }}</h1>
    @endif

    {{-- Search --}}
    <div class="relative ml-auto hidden w-full max-w-xs md:block">

        <x-ui.icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-content-subtle" />

        <input
            type="search"
            placeholder="Search properties…"
            class="input h-9 !pl-9 !text-sm"
            aria-label="Search properties"
        >

    </div>

    <div class="flex items-center gap-1 {{ $title ? 'md:ml-0 ml-auto' : 'ml-auto md:ml-0' }}">

        <x-theme-toggle />

        <button type="button" class="btn btn-ghost btn-sm relative !px-2" aria-label="Notifications">
            <x-ui.icon name="bell" class="h-[18px] w-[18px]" />
            <span class="absolute right-1.5 top-1.5 h-1.5 w-1.5 rounded-full bg-accent ring-2 ring-surface"></span>
        </button>

        {{-- User menu --}}
        @auth
            @php
                $user = auth()->user();
                $initials = collect(explode(' ', trim($user->name)))
                    ->filter()
                    ->take(2)
                    ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
                    ->implode('');
            @endphp

            <div class="relative ml-1" x-data="{ open: false }" x-on:keydown.escape.window="open = false">

                <button
                    type="button"
                    x-on:click="open = !open"
                    x-bind:aria-expanded="open"
                    class="flex items-center gap-2 rounded-lg p-1 pr-1.5 transition-colors hover:bg-surface-muted"
                >
                    <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-accent-soft text-[11px] font-semibold text-accent">
                        {{ $initials ?: 'U' }}
                    </span>

                    <span class="hidden text-sm font-medium text-content sm:block">{{ $user->name }}</span>

                    <x-ui.icon name="chevron-down" class="hidden h-4 w-4 text-content-subtle sm:block" />
                </button>

                <div
                    x-show="open"
                    x-cloak
                    x-on:click.outside="open = false"
                    x-transition.opacity.duration.150ms
                    class="absolute right-0 mt-1.5 w-56 overflow-hidden rounded-xl border border-line bg-surface shadow-overlay"
                >

                    <div class="border-b border-line px-3 py-2.5">
                        <p class="truncate text-sm font-medium text-content">{{ $user->name }}</p>
                        <p class="truncate text-xs text-content-muted">{{ $user->email }}</p>
                    </div>

                    <div class="p-1">

                        @if(Route::has('profile.edit'))
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm text-content-muted transition-colors hover:bg-surface-muted hover:text-content">
                                <x-ui.icon name="user" class="h-4 w-4" />
                                Profile
                            </a>
                        @endif

                        @if(Route::has('settings'))
                            <a href="{{ route('settings') }}"
                               class="flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm text-content-muted transition-colors hover:bg-surface-muted hover:text-content">
                                <x-ui.icon name="settings" class="h-4 w-4" />
                                Settings
                            </a>
                        @endif

                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="border-t border-line p-1">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm text-content-muted transition-colors hover:bg-danger-soft hover:text-danger">
                            <x-ui.icon name="logout" class="h-4 w-4" />
                            Sign out
                        </button>
                    </form>

                </div>

            </div>
        @endauth

    </div>

</header>
