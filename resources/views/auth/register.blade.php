<x-guest-layout
    title="Create account"
    heading="Create your account"
    subheading="Start assessing rooftops in a few minutes."
>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Full name')" />

            <x-text-input
                id="name"
                type="text"
                name="name"
                :value="old('name')"
                placeholder="Juan Dela Cruz"
                class="mt-1.5"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

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
                autocomplete="username"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        {{-- Password --}}
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input
                id="password"
                type="password"
                name="password"
                placeholder="At least 8 characters"
                class="mt-1.5"
                required
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        {{-- Confirm --}}
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm password')" />

            <x-text-input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                placeholder="Re-enter your password"
                class="mt-1.5"
                required
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-full !mt-6">
            {{ __('Create account') }}
        </button>

    </form>

    <p class="mt-6 text-center text-sm text-content-muted">
        {{ __('Already have an account?') }}
        <a href="{{ route('login') }}"
           class="rounded font-medium text-accent transition-colors hover:text-accent-hover">
            {{ __('Sign in') }}
        </a>
    </p>

</x-guest-layout>
