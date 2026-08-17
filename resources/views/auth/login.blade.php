@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                class="form-control @error('username') is-invalid @enderror"
                value="{{ old('username') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="Masukkan username"
            >
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label for="password" class="form-label">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-primary" style="font-size:0.8rem;">Lupa password?</a>
                @endif
            </div>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                required
                autocomplete="current-password"
                placeholder="Masukkan password"
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me" style="font-size:0.875rem;">Ingat saya</label>
        </div>

        <button type="submit" class="btn btn-auth mb-3">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
        </button>

        <div class="text-center">
            <span class="text-muted small">Belum memiliki akun?</span>
            <a href="{{ route('register') }}" class="text-primary fw-semibold ms-1" style="font-size:0.875rem;">Daftar di sini</a>
        </div>
    </form>
@endsection
