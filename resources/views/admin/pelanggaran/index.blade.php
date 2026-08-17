@extends('layouts.app')
@section('title', 'Data Pelanggaran')
@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Pelanggaran</li>
@endsection
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div><h4><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Data Pelanggaran</h4><p class="text-muted mb-0">Riwayat pelanggaran siswa.</p></div>
    <a href="{{ route('admin.pelanggaran.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
</div>
<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ route('admin.pelanggaran.index') }}" class="d-flex gap-2" style="max-width:400px;">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama siswa..." value="{{ $filters['search'] ?? '' }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
            @if(!empty($filters['search']))<a href="{{ route('admin.pelanggaran.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>@endif
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th class="ps-3">#</th><th>Siswa</th><th>Tanggal</th><th>Potongan Poin</th><th>Tindakan</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($pelanggaran as $p)
                    <tr>
                        <td class="ps-3">{{ $pelanggaran->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $p->siswa?->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pelanggaran)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-danger">
                                -{{ $p->poin }} Poin
                            </span>
                        </td>
                        <td>{{ Str::limit($p->tindakan, 60) }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.pelanggaran.edit', $p->id_pelanggaran) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.pelanggaran.destroy', $p->id_pelanggaran) }}" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data pelanggaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($pelanggaran->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted">{{ $pelanggaran->firstItem() }}–{{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }}</small>
        {{ $pelanggaran->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
