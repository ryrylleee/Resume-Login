<x-guest-layout>
    <div class="login-wrapper">
        <div class="login-card">
            <h1 class="login-title">Create Account</h1>
            <p class="login-sub">Register to continue</p>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="validation-errors mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('register') }}" class="login-form">
                @csrf

                <!-- Name -->
                <label class="field-label" for="name">Name</label>
                <x-text-input id="name" class="field-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />

                <!-- Email -->
                <label class="field-label" for="email">Email</label>
                <x-text-input id="email" class="field-input" type="email" name="email" :value="old('email')" required autocomplete="username" />

                <!-- Password -->
                <label class="field-label" for="password">Password</label>
                <x-text-input id="password" class="field-input"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />

                <!-- Confirm Password -->
                <label class="field-label" for="password_confirmation">Confirm Password</label>
                <x-text-input id="password_confirmation" class="field-input"
                    type="password"
                    name="password_confirmation" required autocomplete="new-password" />

                <div class="remember-row">
                    <p class="remember-label">Already registered?</p>
                    <a href="{{ route('login') }}" class="register-link">
                        Sign in
                    </a>
                </div>

                <button type="submit" class="btn-submit">Register</button>
            </form>
        </div>
    </div>
</x-guest-layout>
