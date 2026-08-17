@extends('layouts.app')
@section('title', 'Manajemen Akun')
@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Manajemen Akun</li>
@endsection
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div><h4><i class="bi bi-person-badge me-2 text-primary"></i>Manajemen Akun</h4><p class="text-muted mb-0">Kelola akun pengguna sistem (Register).</p></div>
    <a href="{{ route('admin.register.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah Akun</a>
</div>
<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ route('admin.register.index') }}" class="d-flex gap-2" style="max-width:400px;">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama, username, email..." value="{{ $filters['search'] ?? '' }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
            @if(!empty($filters['search']))<a href="{{ route('admin.register.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>@endif
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th class="ps-3">#</th><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($users as $u)
                    <tr>
                        <td class="ps-3">{{ $users->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $u->nama }}</td>
                        <td><code>{{ $u->username }}</code></td>
                        <td>{{ $u->email }}</td>
                        <td>
                            @php
                                $roleBadges = ['guru_bk'=>'bg-primary','siswa'=>'bg-success','orang_tua'=>'bg-info','kepala_sekolah'=>'bg-warning text-dark'];
                            @endphp
                            <span class="badge {{ $roleBadges[$u->role] ?? 'bg-secondary' }}">{{ $u->role }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.register.edit', $u->id_register) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.register.destroy', $u->id_register) }}" onsubmit="return confirm('Hapus akun ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data akun.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted">{{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }}</small>
        {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
