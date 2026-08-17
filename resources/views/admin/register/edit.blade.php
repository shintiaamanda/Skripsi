@extends('layouts.app')
@section('title', 'Edit Akun')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.register.index') }}">Manajemen Akun</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<div class="page-header"><h4><i class="bi bi-pencil me-2 text-warning"></i>Edit Akun</h4></div>
<div class="card" style="max-width:640px;"><div class="card-body">
    <form method="POST" action="{{ route('admin.register.update', $user->id_register) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama) }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>
                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="guru_bk" {{ old('role', $user->role) === 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
                    <option value="siswa" {{ old('role', $user->role) === 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="orang_tua" {{ old('role', $user->role) === 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                    <option value="kepala_sekolah" {{ old('role', $user->role) === 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Password Baru (Opsional)</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak diubah">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-floppy me-1"></i>Perbarui</button>
                <a href="{{ route('admin.register.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div></div>
@endsection
