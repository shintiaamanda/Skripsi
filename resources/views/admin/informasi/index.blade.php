@extends('layouts.app')
@section('title', 'Informasi BK')
@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Informasi BK</li>
@endsection
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div><h4><i class="bi bi-info-circle me-2 text-info"></i>Informasi BK</h4><p class="text-muted mb-0">Pengumuman & Informasi BK.</p></div>
    <a href="{{ route('admin.informasi.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th class="ps-3">#</th><th>Tanggal</th><th>Informasi</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($informasi as $i)
                    <tr>
                        <td class="ps-3">{{ $informasi->firstItem() + $loop->index }}</td>
                        <td>{{ \Carbon\Carbon::parse($i->tanggal_informasi)->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($i->informasi, 80) }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.informasi.edit', $i->id_info) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.informasi.destroy', $i->id_info) }}" onsubmit="return confirm('Hapus informasi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Tidak ada informasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($informasi->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted">{{ $informasi->firstItem() }}–{{ $informasi->lastItem() }} dari {{ $informasi->total() }}</small>
        {{ $informasi->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
