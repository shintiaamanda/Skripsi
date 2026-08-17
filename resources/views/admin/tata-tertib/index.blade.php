@extends('layouts.app')
@section('title', 'Tata Tertib Sekolah')
@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Tata Tertib</li>
@endsection
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div><h4><i class="bi bi-book me-2 text-primary"></i>Tata Tertib Sekolah</h4><p class="text-muted mb-0">Kelola peraturan dan tata tertib sekolah.</p></div>
    <a href="{{ route('admin.tata-tertib.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th class="ps-3">#</th><th>Tanggal</th><th>Tata Tertib</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($tataTertib as $t)
                    <tr>
                        <td class="ps-3">{{ $tataTertib->firstItem() + $loop->index }}</td>
                        <td>{{ \Carbon\Carbon::parse($t->tanggal_konseling)->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($t->tata_tertib, 80) }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.tata-tertib.edit', $t->id_tertib) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.tata-tertib.destroy', $t->id_tertib) }}" onsubmit="return confirm('Hapus tata tertib ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Tidak ada data tata tertib.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($tataTertib->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted">{{ $tataTertib->firstItem() }}–{{ $tataTertib->lastItem() }} dari {{ $tataTertib->total() }}</small>
        {{ $tataTertib->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
