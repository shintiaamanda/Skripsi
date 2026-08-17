@extends('layouts.app')
@section('title', 'Data Monitoring')
@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Monitoring</li>
@endsection
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4><i class="bi bi-eye me-2 text-purple"></i>Data Monitoring</h4>
        <p class="text-muted mb-0">Monitoring perkembangan siswa.</p>
    </div>
    <a href="{{ route('admin.monitoring.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
</div>
<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ route('admin.monitoring.index') }}" class="d-flex gap-2" style="max-width:400px;">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama siswa..." value="{{ $filters['search'] ?? '' }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
            @if(!empty($filters['search']))<a href="{{ route('admin.monitoring.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>@endif
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th class="ps-3">#</th><th>Siswa</th><th>Tanggal</th><th>Perkembangan</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($monitoring as $m)
                    <tr>
                        <td class="ps-3">{{ $monitoring->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $m->siswa?->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($m->tanggal_monitoring)->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $textLower = strtolower($m->perkembangan ?? '');
                                $isBuruk = \Illuminate\Support\Str::contains($textLower, ['buruk', 'kurang', 'nakal', 'bolos', 'langgar', 'lambat', 'penurunan', 'masalah', 'tidak', 'jelek', 'parah']);
                            @endphp
                            <span class="{{ $isBuruk ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                                {{ Str::limit($m->perkembangan, 60) }}
                            </span>
                            @if(! $isBuruk)
                                <span class="badge bg-success ms-1" style="font-size:0.7rem;">+10 Poin</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.monitoring.edit', $m->id_monitoring) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.monitoring.destroy', $m->id_monitoring) }}" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada data monitoring.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($monitoring->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted">{{ $monitoring->firstItem() }}–{{ $monitoring->lastItem() }} dari {{ $monitoring->total() }}</small>
        {{ $monitoring->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
