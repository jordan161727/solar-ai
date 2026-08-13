@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <x-app-head :title="$title" />
</head>

<body class="h-full font-sans">

<div class="flex h-full" x-data="{ sidebarOpen: false }">

    {{-- Desktop sidebar --}}
    <x-sidebar class="hidden lg:flex" />

    {{-- Mobile drawer --}}
    <div x-show="sidebarOpen" x-cloak class="relative z-50 lg:hidden">

        <div
            x-show="sidebarOpen"
            x-transition.opacity.duration.200ms
            x-on:click="sidebarOpen = false"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-[2px]"
        ></div>

        <div
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 flex"
        >
            <x-sidebar class="flex" />

            <button
                type="button"
                x-on:click="sidebarOpen = false"
                class="btn btn-ghost btn-sm ml-1 mt-2 !px-2 text-white hover:bg-white/10"
                aria-label="Close navigation"
            >
                <x-ui.icon name="close" class="h-5 w-5" />
            </button>
        </div>

    </div>

    {{-- Main column --}}
    <div class="flex min-w-0 flex-1 flex-col">

        <x-navbar :title="$title" />

        <main class="flex-1 overflow-y-auto">
            <div class="mx-auto w-full max-w-[1400px] p-4 lg:p-6">
                {{ $slot }}
            </div>
        </main>

    </div>

</div>

@stack('scripts')

</body>

</html>
