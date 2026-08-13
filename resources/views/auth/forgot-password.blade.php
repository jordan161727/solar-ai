<x-guest-layout
    title="Reset password"
    heading="Reset your password"
    subheading="We'll email you a link to choose a new one."
>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

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
            />

            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-full !mt-6">
            {{ __('Email reset link') }}
        </button>

    </form>

    <p class="mt-6 text-center text-sm text-content-muted">
        <a href="{{ route('login') }}"
           class="rounded font-medium text-accent transition-colors hover:text-accent-hover">
            {{ __('Back to sign in') }}
        </a>
    </p>

</x-guest-layout>
