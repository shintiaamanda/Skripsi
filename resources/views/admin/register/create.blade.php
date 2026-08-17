@extends('layouts.app')
@section('title', 'Tambah Akun')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.register.index') }}">Manajemen Akun</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection
@section('content')
<div class="page-header"><h4><i class="bi bi-person-plus me-2 text-primary"></i>Tambah Akun</h4></div>
<div class="card" style="max-width:640px;"><div class="card-body">
    <form method="POST" action="{{ route('admin.register.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="guru_bk" {{ old('role') === 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
                    <option value="siswa" {{ old('role') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="orang_tua" {{ old('role') === 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                    <option value="kepala_sekolah" {{ old('role') === 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-floppy me-1"></i>Simpan</button>
                <a href="{{ route('admin.register.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div></div>
@endsection
