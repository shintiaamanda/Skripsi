@extends('layouts.app')
@section('title', 'Pengajuan Konseling')
@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Pengajuan Konseling</li>
@endsection
@section('content')
<div class="page-header"><h4><i class="bi bi-inbox me-2 text-primary"></i>Pengajuan Konseling</h4><p class="text-muted mb-0">Pengajuan konseling dari siswa.</p></div>
<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ route('admin.pengajuan.index') }}" class="d-flex gap-2" style="max-width:400px;">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama siswa..." value="{{ $filters['search'] ?? '' }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
            @if(!empty($filters['search']))<a href="{{ route('admin.pengajuan.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>@endif
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th class="ps-3">#</th><th>Siswa</th><th>Tanggal</th><th>Keluhan</th><th>Guru BK</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($pengajuan as $p)
                    <tr>
                        <td class="ps-3">{{ $pengajuan->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $p->siswa?->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_konseling)->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($p->keluhan, 50) }}</td>
                        <td>{{ $p->guru_bk ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.pengajuan.show', $p->id_konseling) }}" class="btn btn-sm btn-outline-success" title="Proses"><i class="bi bi-check-circle"></i> Proses</a>
                                <form method="POST" action="{{ route('admin.pengajuan.destroy', $p->id_konseling) }}" onsubmit="return confirm('Hapus pengajuan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada pengajuan konseling.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($pengajuan->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted">{{ $pengajuan->firstItem() }}–{{ $pengajuan->lastItem() }} dari {{ $pengajuan->total() }}</small>
        {{ $pengajuan->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
