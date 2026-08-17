@extends('layouts.app')
@section('title', 'Jadwal Layanan BK')
@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Jadwal Layanan BK</li>
@endsection
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div><h4><i class="bi bi-calendar3 me-2 text-primary"></i>Jadwal Layanan BK</h4><p class="text-muted mb-0">Jadwal konsultasi Guru BK.</p></div>
    <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
</div>
<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ route('admin.jadwal.index') }}" class="d-flex gap-2" style="max-width:400px;">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari hari, guru..." value="{{ $filters['search'] ?? '' }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
            @if(!empty($filters['search']))<a href="{{ route('admin.jadwal.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>@endif
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th class="ps-3">#</th><th>Hari</th><th>Tanggal</th><th>Jam</th><th>Guru</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($jadwal as $j)
                    <tr>
                        <td class="ps-3">{{ $jadwal->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $j->hari }}</td>
                        <td>{{ \Carbon\Carbon::parse($j->tanggal_layanan)->format('d/m/Y') }}</td>
                        <td><span class="badge bg-primary">{{ $j->jam }}</span></td>
                        <td>{{ $j->guru }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.jadwal.edit', $j->id_jadwal) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.jadwal.destroy', $j->id_jadwal) }}" onsubmit="return confirm('Hapus jadwal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada jadwal.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($jadwal->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted">{{ $jadwal->firstItem() }}–{{ $jadwal->lastItem() }} dari {{ $jadwal->total() }}</small>
        {{ $jadwal->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
