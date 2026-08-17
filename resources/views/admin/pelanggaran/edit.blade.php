@extends('layouts.app')
@section('title', 'Edit Pelanggaran')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pelanggaran.index') }}">Pelanggaran</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<div class="page-header"><h4><i class="bi bi-pencil me-2 text-warning"></i>Edit Data Pelanggaran</h4></div>
<div class="card" style="max-width:640px;"><div class="card-body">
    <form method="POST" action="{{ route('admin.pelanggaran.update', $pelanggaran->id_pelanggaran) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-12">
                <label for="id_siswa" class="form-label">Siswa <span class="text-danger">*</span></label>
                <select id="id_siswa" name="id_siswa" class="form-select @error('id_siswa') is-invalid @enderror" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswa as $s)<option value="{{ $s->id_siswa }}" {{ old('id_siswa', $pelanggaran->id_siswa) == $s->id_siswa ? 'selected' : '' }}>{{ $s->nama }} ({{ $s->kelas }})</option>@endforeach
                </select>
                @error('id_siswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="tanggal_pelanggaran" class="form-label">Tanggal <span class="text-danger">*</span></label>
                <input type="date" id="tanggal_pelanggaran" name="tanggal_pelanggaran" class="form-control @error('tanggal_pelanggaran') is-invalid @enderror" value="{{ old('tanggal_pelanggaran', \Carbon\Carbon::parse($pelanggaran->tanggal_pelanggaran)->format('Y-m-d')) }}" required>
                @error('tanggal_pelanggaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="poin" class="form-label">Poin <span class="text-danger">*</span></label>
                <input type="number" id="poin" name="poin" class="form-control @error('poin') is-invalid @enderror" value="{{ old('poin', $pelanggaran->poin) }}" min="0" required>
                @error('poin')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="tindakan" class="form-label">Tindakan <span class="text-danger">*</span></label>
                <textarea id="tindakan" name="tindakan" rows="4" class="form-control @error('tindakan') is-invalid @enderror" required>{{ old('tindakan', $pelanggaran->tindakan) }}</textarea>
                @error('tindakan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-floppy me-1"></i>Perbarui</button>
                <a href="{{ route('admin.pelanggaran.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div></div>
@endsection
