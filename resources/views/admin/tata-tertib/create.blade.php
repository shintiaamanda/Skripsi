@extends('layouts.app')
@section('title', 'Tambah Tata Tertib')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.tata-tertib.index') }}">Tata Tertib</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection
@section('content')
<div class="page-header"><h4><i class="bi bi-book me-2 text-primary"></i>Tambah Tata Tertib</h4></div>
<div class="card" style="max-width:600px;"><div class="card-body">
    <form method="POST" action="{{ route('admin.tata-tertib.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <label for="tanggal_konseling" class="form-label">Tanggal <span class="text-danger">*</span></label>
                <input type="date" id="tanggal_konseling" name="tanggal_konseling" class="form-control @error('tanggal_konseling') is-invalid @enderror" value="{{ old('tanggal_konseling') }}" required>
                @error('tanggal_konseling')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="tata_tertib" class="form-label">Peraturan / Tata Tertib <span class="text-danger">*</span></label>
                <textarea id="tata_tertib" name="tata_tertib" rows="4" class="form-control @error('tata_tertib') is-invalid @enderror" required>{{ old('tata_tertib') }}</textarea>
                @error('tata_tertib')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-floppy me-1"></i>Simpan</button>
                <a href="{{ route('admin.tata-tertib.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div></div>
@endsection
