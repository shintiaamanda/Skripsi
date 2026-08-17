@extends('layouts.app')
@section('title', 'Keamanan')
@section('breadcrumb')
    <li class="breadcrumb-item">Pengaturan</li>
    <li class="breadcrumb-item active">Keamanan</li>
@endsection
@section('content')
<div class="page-header"><h4><i class="bi bi-shield-lock me-2 text-primary"></i>Pengaturan Keamanan</h4></div>

<div class="row g-4" style="max-width: 600px;">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><i class="bi bi-key me-2"></i>Ubah Password</div>
            <div class="card-body">
                <form method="POST" action="{{ route('user-password.update') }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" required>
                        @error('current_password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" id="password" name="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" required>
                        @error('password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy me-1"></i>Perbarui Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
