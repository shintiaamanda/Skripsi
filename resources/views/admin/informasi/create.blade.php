@extends('layouts.app')
@section('title', 'Tambah Informasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.informasi.index') }}">Informasi BK</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection
@section('content')
<div class="page-header"><h4><i class="bi bi-info-circle me-2 text-info"></i>Tambah Informasi BK</h4></div>
<div class="card" style="max-width:600px;"><div class="card-body">
    <form method="POST" action="{{ route('admin.informasi.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <label for="tanggal_informasi" class="form-label">Tanggal Informasi <span class="text-danger">*</span></label>
                <input type="date" id="tanggal_informasi" name="tanggal_informasi" class="form-control @error('tanggal_informasi') is-invalid @enderror" value="{{ old('tanggal_informasi') }}" required>
                @error('tanggal_informasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="informasi" class="form-label">Informasi / Pengumuman <span class="text-danger">*</span></label>
                <textarea id="informasi" name="informasi" rows="4" class="form-control @error('informasi') is-invalid @enderror" required>{{ old('informasi') }}</textarea>
                @error('informasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-floppy me-1"></i>Simpan</button>
                <a href="{{ route('admin.informasi.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div></div>
@endsection
