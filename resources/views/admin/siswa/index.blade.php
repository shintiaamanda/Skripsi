@extends('layouts.app')

@section('title', 'Data Siswa')

@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Data Siswa</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4><i class="bi bi-people me-2 text-primary"></i>Data Siswa</h4>
        <p class="text-muted mb-0">Kelola data siswa SMKN 3 Padang.</p>
    </div>
    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Siswa
    </a>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ route('admin.siswa.index') }}" class="d-flex gap-2" style="max-width:400px;">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama, NISN, kelas..." value="{{ $filters['search'] ?? '' }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
            @if(!empty($filters['search']))
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            @endif
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">#</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                        <th>No HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $s)
                    <tr>
                        <td class="ps-3">{{ $siswa->firstItem() + $loop->index }}</td>
                        <td>{{ $s->nisn }}</td>
                        <td class="fw-semibold">{{ $s->nama }}</td>
                        <td>{{ $s->kelas }}</td>
                        <td>
                            <span class="badge {{ $s->jenis_kelamin === 'Laki-laki' ? 'bg-primary' : 'bg-pink' }}" style="{{ $s->jenis_kelamin === 'Perempuan' ? 'background:#db2777 !important;' : '' }}">
                                {{ $s->jenis_kelamin }}
                            </span>
                        </td>
                        <td>{{ $s->no_hp }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.siswa.edit', $s->id_siswa) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.siswa.destroy', $s->id_siswa) }}" onsubmit="return confirm('Hapus data siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size:2rem;opacity:0.3;"></i>
                            <p class="mt-2 mb-0">Tidak ada data siswa.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($siswa->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted">Menampilkan {{ $siswa->firstItem() }}–{{ $siswa->lastItem() }} dari {{ $siswa->total() }} data</small>
        {{ $siswa->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
