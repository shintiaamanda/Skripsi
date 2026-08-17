@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Data Siswa</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-person-plus me-2 text-primary"></i>Tambah Data Siswa</h4>
</div>

<div class="card" style="max-width:640px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.siswa.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nisn" class="form-label">NISN <span class="text-danger">*</span></label>
                    <input type="text" id="nisn" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn') }}" required maxlength="20">
                    @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                    <input type="text" id="kelas" name="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas') }}" required maxlength="50" placeholder="Contoh: X TKJ 1">
                    @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                    <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" required maxlength="15" placeholder="08xxxxxxxxxx">
                    @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea id="alamat" name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat') }}</textarea>
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy me-1"></i>Simpan</button>
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
