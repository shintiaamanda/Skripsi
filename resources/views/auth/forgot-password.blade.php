@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
    @if (session('status'))
        <div class="alert alert-success mb-3" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <p class="text-center text-muted mb-4" style="font-size:0.875rem;">
        Masukkan email Anda dan kami akan mengirim link reset password.
    </p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                required
                autofocus
                placeholder="email@example.com"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-auth mb-3">
            <i class="bi bi-envelope me-2"></i>Kirim Link Reset Password
        </button>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-primary" style="font-size:0.875rem;">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
            </a>
        </div>
    </form>
@endsection
