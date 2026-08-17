@extends('layouts.app')
@section('title', 'Edit Monitoring')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.monitoring.index') }}">Monitoring</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<div class="page-header"><h4><i class="bi bi-pencil me-2 text-warning"></i>Edit Data Monitoring</h4></div>
<div class="card" style="max-width:640px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.monitoring.update', $monitoring->id_monitoring) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-12">
                    <label for="id_siswa" class="form-label">Siswa <span class="text-danger">*</span></label>
                    <select id="id_siswa" name="id_siswa" class="form-select @error('id_siswa') is-invalid @enderror" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswa as $s)
                        <option value="{{ $s->id_siswa }}" {{ old('id_siswa', $monitoring->id_siswa) == $s->id_siswa ? 'selected' : '' }}>{{ $s->nama }} ({{ $s->kelas }})</option>
                        @endforeach
                    </select>
                    @error('id_siswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label for="tanggal_monitoring" class="form-label">Tanggal Monitoring <span class="text-danger">*</span></label>
                    <input type="date" id="tanggal_monitoring" name="tanggal_monitoring" class="form-control @error('tanggal_monitoring') is-invalid @enderror" value="{{ old('tanggal_monitoring', \Carbon\Carbon::parse($monitoring->tanggal_monitoring)->format('Y-m-d')) }}" required>
                    @error('tanggal_monitoring')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label for="perkembangan" class="form-label">Catatan Perkembangan <span class="text-danger">*</span></label>
                    <textarea id="perkembangan" name="perkembangan" rows="4" class="form-control @error('perkembangan') is-invalid @enderror" required>{{ old('perkembangan', $monitoring->perkembangan) }}</textarea>
                    @error('perkembangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-warning"><i class="bi bi-floppy me-1"></i>Perbarui</button>
                    <a href="{{ route('admin.monitoring.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
