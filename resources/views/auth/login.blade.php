<x-guest-layout>
    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-envelope text-muted"></i>
                </span>
                <input id="email" type="email" name="email"
                       class="form-control border-start-0 @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="admin@exemple.com"
                       required autofocus autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-lock text-muted"></i>
                </span>
                <input id="password" type="password" name="password"
                       class="form-control border-start-0 @error('password') is-invalid @enderror"
                       placeholder="••••••••"
                       required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label small text-muted">Se souvenir de moi</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color:#c0392b;">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-login">
            <i class="fas fa-sign-in-alt me-2"></i> Se connecter
        </button>
    </form>
</x-guest-layout>
