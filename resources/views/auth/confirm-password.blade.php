@extends('layouts.auth')

@section('title', 'Konfirmasi Password')

@section('content')
    <p class="text-center text-muted mb-4" style="font-size:0.875rem;">
        Ini adalah area aman. Konfirmasi password Anda sebelum melanjutkan.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                required
                autocomplete="current-password"
                placeholder="Masukkan password Anda"
                autofocus
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-auth">
            <i class="bi bi-shield-check me-2"></i>Konfirmasi
        </button>
    </form>
@endsection
