<x-guest-layout>
    <h4 class="fw-bold mb-3 text-center">Sign In</h4>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="mb-3 form-check d-flex justify-content-between align-items-center">
            <div>
                <x-checkbox id="remember_me" name="remember" />
                <label class="form-check-label ms-1" for="remember_me">{{ __('Remember me') }}</label>
            </div>

            @if (Route::has('password.request'))
                <a class="small text-decoration-none" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <x-primary-button>
            {{ __('Log in') }}
        </x-primary-button>

        @if (Route::has('register'))
            <p class="text-center text-muted small mt-3 mb-0">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Register</a>
            </p>
        @endif
    </form>
</x-guest-layout>
