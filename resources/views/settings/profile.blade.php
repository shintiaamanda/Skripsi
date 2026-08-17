@extends('layouts.app')
@section('title', 'Profil Saya')
@section('breadcrumb')
    <li class="breadcrumb-item">Pengaturan</li>
    <li class="breadcrumb-item active">Profil</li>
@endsection
@section('content')
<div class="page-header"><h4><i class="bi bi-person-circle me-2 text-primary"></i>Pengaturan Profil</h4></div>

<div class="row g-4" style="max-width: 600px;">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', auth()->user()->nama) }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', auth()->user()->username) }}" required>
                        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy me-1"></i>Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
