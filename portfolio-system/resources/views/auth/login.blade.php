<x-guest-layout>
    <div class="login-wrapper">
        <div class="login-card">
            <h1 class="login-title">Welcome Back</h1>
            <p class="login-sub">Sign in to view resume</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="session-status">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="validation-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <!-- Username / Email -->
                <label class="field-label" for="email">Username</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="field-input" />

                <!-- Password -->
                <label class="field-label" for="password">Password</label>
                <input id="password" type="password" name="password" required class="field-input" />

                <!-- Remember -->
                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="remember-label">Remember Me</label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit">Sign In</button>

                <div class="register-link">
                    <a href="{{ route('register') }}">Don’t have an account? Register</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
