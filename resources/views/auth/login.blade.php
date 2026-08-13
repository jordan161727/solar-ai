<x-guest-layout
    title="Sign in"
    heading="Sign in to Solar AI"
    subheading="Enter your credentials to reach your dashboard."
>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input
                id="email"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="you@company.com"
                class="mt-1.5"
                required
                autofocus
                autocomplete="username"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        {{-- Password --}}
        <div x-data="{ show: false }">

            <div class="flex items-baseline justify-between">
                <x-input-label for="password" :value="__('Password')" />

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="rounded text-xs font-medium text-accent transition-colors hover:text-accent-hover">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="relative mt-1.5">
                <x-text-input
                    id="password"
                    x-bind:type="show ? 'text' : 'password'"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    class="!pr-10"
                    required
                    autocomplete="current-password"
                />

                <button
                    type="button"
                    x-on:click="show = !show"
                    x-bind:aria-label="show ? 'Hide password' : 'Show password'"
                    class="absolute right-1 top-1/2 grid h-8 w-8 -translate-y-1/2 place-items-center rounded-md text-content-subtle transition-colors hover:text-content"
                    tabindex="-1"
                >
                    <x-ui.icon name="eye" class="h-4 w-4" x-show="!show" x-cloak />
                    <x-ui.icon name="eye-off" class="h-4 w-4" x-show="show" x-cloak />
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        {{-- Remember --}}
        <label for="remember_me" class="flex cursor-pointer items-center gap-2 pt-0.5">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                class="h-4 w-4 rounded border-line-strong bg-surface text-accent focus:ring-1 focus:ring-accent focus:ring-offset-0"
            >
            <span class="text-sm text-content-muted">{{ __('Keep me signed in') }}</span>
        </label>

        <button type="submit" class="btn btn-primary btn-lg w-full !mt-6">
            {{ __('Sign in') }}
        </button>

    </form>

    @if (Route::has('register'))
        <p class="mt-6 text-center text-sm text-content-muted">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}"
               class="rounded font-medium text-accent transition-colors hover:text-accent-hover">
                {{ __('Create one') }}
            </a>
        </p>
    @endif

</x-guest-layout>
