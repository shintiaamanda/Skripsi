@extends('layouts.auth')

@section('title', 'Verifikasi Email')

@section('content')
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-3">Link verifikasi baru telah dikirim ke email Anda.</div>
    @endif

    <p class="text-center text-muted mb-4" style="font-size:0.875rem;">
        Terima kasih sudah mendaftar! Sebelum memulai, verifikasi email Anda dengan klik link yang kami kirim.
    </p>

    <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
        @csrf
        <button type="submit" class="btn btn-auth">
            <i class="bi bi-envelope-check me-2"></i>Kirim Ulang Email Verifikasi
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="text-center">
        @csrf
        <button type="submit" class="btn btn-link text-secondary" style="font-size:0.875rem;">
            <i class="bi bi-box-arrow-right me-1"></i>Logout
        </button>
    </form>
@endsection
