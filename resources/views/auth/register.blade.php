@extends('layouts.auth')

@section('title', 'Pendaftaran Akun Baru')

@section('content')
    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        <!-- Pilih Peran / Role -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Daftar Sebagai <span class="text-danger">*</span></label>
            <div class="row g-2">
                <div class="col-6">
                    <input type="radio" class="btn-check" name="role" id="role_siswa" value="siswa" {{ old('role', 'siswa') === 'siswa' ? 'checked' : '' }} onchange="toggleSiswaFields()">
                    <label class="btn btn-outline-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2" for="role_siswa">
                        <i class="bi bi-mortarboard-fill"></i> Siswa
                    </label>
                </div>
                <div class="col-6">
                    <input type="radio" class="btn-check" name="role" id="role_orang_tua" value="orang_tua" {{ old('role') === 'orang_tua' ? 'checked' : '' }} onchange="toggleSiswaFields()">
                    <label class="btn btn-outline-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2" for="role_orang_tua">
                        <i class="bi bi-people-fill"></i> Orang Tua
                    </label>
                </div>
            </div>
            @error('role')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Nama Lengkap -->
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input
                type="text"
                id="nama"
                name="nama"
                class="form-control @error('nama') is-invalid @enderror"
                value="{{ old('nama') }}"
                required
                autofocus
                placeholder="Masukkan nama lengkap"
            >
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Username -->
        <div class="mb-3">
            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
            <input
                type="text"
                id="username"
                name="username"
                class="form-control @error('username') is-invalid @enderror"
                value="{{ old('username') }}"
                required
                placeholder="Username untuk login"
            >
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                required
                placeholder="email@example.com"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Field Khusus Siswa -->
        <div id="siswaFields" style="display: block;">
            <hr class="my-3 text-muted">
            <div class="text-primary fw-bold small mb-2"><i class="bi bi-info-circle me-1"></i> Data Siswa</div>

            <div class="mb-3">
                <label for="nisn" class="form-label">NISN <span class="text-danger">*</span></label>
                <input
                    type="text"
                    id="nisn"
                    name="nisn"
                    class="form-control @error('nisn') is-invalid @enderror"
                    value="{{ old('nisn') }}"
                    placeholder="Masukkan NISN"
                    maxlength="20"
                >
                @error('nisn')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-2 mb-3">
                <div class="col-6">
                    <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        id="kelas"
                        name="kelas"
                        class="form-control @error('kelas') is-invalid @enderror"
                        value="{{ old('kelas') }}"
                        placeholder="Contoh: X TKJ 1"
                    >
                    @error('kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                        <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label">No. HP / Whatsapp <span class="text-danger">*</span></label>
                <input
                    type="text"
                    id="no_hp"
                    name="no_hp"
                    class="form-control @error('no_hp') is-invalid @enderror"
                    value="{{ old('no_hp') }}"
                    placeholder="08xxxxxxxxxx"
                    maxlength="15"
                >
                @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                <textarea
                    id="alamat"
                    name="alamat"
                    rows="2"
                    class="form-control @error('alamat') is-invalid @enderror"
                    placeholder="Alamat rumah..."
                >{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <hr class="my-3 text-muted">
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                required
                autocomplete="new-password"
                placeholder="Min. 8 karakter"
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                required
                autocomplete="new-password"
                placeholder="Ulangi password"
            >
        </div>

        <button type="submit" class="btn btn-auth mb-3">
            <i class="bi bi-person-plus me-2"></i>Daftar Akun
        </button>

        <div class="text-center">
            <span class="text-muted small">Sudah memiliki akun?</span>
            <a href="{{ route('login') }}" class="text-primary fw-semibold ms-1" style="font-size:0.875rem;">Masuk di sini</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    function toggleSiswaFields() {
        const isSiswa = document.getElementById('role_siswa').checked;
        const siswaFields = document.getElementById('siswaFields');
        if (siswaFields) {
            siswaFields.style.display = isSiswa ? 'block' : 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleSiswaFields();
    });
</script>
@endpush
