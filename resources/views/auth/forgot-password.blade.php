<x-guest-layout>
    <h4 class="fw-bold mb-3 text-center">Forgot Password</h4>

    <p class="text-muted small mb-4">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <x-primary-button>
            {{ __('Email Password Reset Link') }}
        </x-primary-button>

        <p class="text-center text-muted small mt-3 mb-0">
            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Back to login</a>
        </p>
    </form>
</x-guest-layout>
