@extends('layouts.app')
@section('title', 'Proses Pengajuan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pengajuan.index') }}">Pengajuan</a></li>
    <li class="breadcrumb-item active">Proses</li>
@endsection
@section('content')
<div class="page-header"><h4><i class="bi bi-check-circle me-2 text-success"></i>Proses Pengajuan Konseling</h4></div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header"><i class="bi bi-info-circle me-2"></i>Detail Pengajuan</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Siswa</dt>
                    <dd class="col-sm-8 fw-semibold">{{ $pengajuan->siswa?->nama ?? '-' }}</dd>
                    <dt class="col-sm-4">Kelas</dt>
                    <dd class="col-sm-8">{{ $pengajuan->siswa?->kelas ?? '-' }}</dd>
                    <dt class="col-sm-4">Tanggal</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($pengajuan->tanggal_konseling)->format('d M Y') }}</dd>
                    <dt class="col-sm-4">Guru BK</dt>
                    <dd class="col-sm-8">{{ $pengajuan->guru_bk ?? '-' }}</dd>
                    <dt class="col-sm-4">Keluhan</dt>
                    <dd class="col-sm-8">{{ $pengajuan->keluhan }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><i class="bi bi-journal-text me-2 text-primary"></i>Isi Data Konseling</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.pengajuan.proses', $pengajuan->id_konseling) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="guru_bk" class="form-label">Guru BK <span class="text-danger">*</span></label>
                        <input type="text" id="guru_bk" name="guru_bk" class="form-control @error('guru_bk') is-invalid @enderror" value="{{ old('guru_bk', $pengajuan->guru_bk) }}" required>
                        @error('guru_bk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="masalah" class="form-label">Masalah <span class="text-danger">*</span></label>
                        <textarea id="masalah" name="masalah" rows="3" class="form-control @error('masalah') is-invalid @enderror" required>{{ old('masalah', $pengajuan->keluhan) }}</textarea>
                        @error('masalah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="solusi" class="form-label">Solusi <span class="text-danger">*</span></label>
                        <textarea id="solusi" name="solusi" rows="3" class="form-control @error('solusi') is-invalid @enderror" required>{{ old('solusi') }}</textarea>
                        @error('solusi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Proses & Simpan</button>
                        <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
