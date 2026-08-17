@extends('layouts.app')
@section('title', 'Edit Jadwal')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.jadwal.index') }}">Jadwal</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<div class="page-header"><h4><i class="bi bi-pencil me-2 text-warning"></i>Edit Jadwal Layanan BK</h4></div>
<div class="card" style="max-width:600px;"><div class="card-body">
    <form method="POST" action="{{ route('admin.jadwal.update', $jadwal->id_jadwal) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label for="hari" class="form-label">Hari <span class="text-danger">*</span></label>
                <select id="hari" name="hari" class="form-select @error('hari') is-invalid @enderror" required>
                    <option value="">-- Pilih Hari --</option>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                    <option value="{{ $h }}" {{ old('hari', $jadwal->hari) === $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
                @error('hari')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="tanggal_layanan" class="form-label">Tanggal <span class="text-danger">*</span></label>
                <input type="date" id="tanggal_layanan" name="tanggal_layanan" class="form-control @error('tanggal_layanan') is-invalid @enderror" value="{{ old('tanggal_layanan', \Carbon\Carbon::parse($jadwal->tanggal_layanan)->format('Y-m-d')) }}" required>
                @error('tanggal_layanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="jam" class="form-label">Jam <span class="text-danger">*</span></label>
                <input type="text" id="jam" name="jam" class="form-control @error('jam') is-invalid @enderror" value="{{ old('jam', $jadwal->jam) }}" required>
                @error('jam')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="guru" class="form-label">Nama Guru BK <span class="text-danger">*</span></label>
                <input type="text" id="guru" name="guru" class="form-control @error('guru') is-invalid @enderror" value="{{ old('guru', $jadwal->guru ?: auth()->user()?->nama) }}" required readonly>
                <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-info-circle me-1"></i>Terisi otomatis sesuai akun Guru BK.</small>
                @error('guru')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-floppy me-1"></i>Perbarui</button>
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div></div>
@endsection
