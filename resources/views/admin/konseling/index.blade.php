@extends('layouts.app')

@section('title', 'Data Konseling')

@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Data Konseling</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4><i class="bi bi-chat-dots me-2 text-success"></i>Data Konseling</h4>
        <p class="text-muted mb-0">Riwayat sesi konseling siswa.</p>
    </div>
    <a href="{{ route('admin.konseling.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Konseling
    </a>
</div>

@if(isset($pengajuanTerlewat) && $pengajuanTerlewat->isNotEmpty())
<div class="alert alert-danger shadow-sm border-0 mb-4 p-3 p-md-4" role="alert">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
        <h6 class="alert-heading fw-bold mb-0 text-danger d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <span>Peringatan Siswa Tidak Hadir Sesuai Jadwal</span>
            <span class="badge bg-danger rounded-pill">{{ $pengajuanTerlewat->count() }} Siswa</span>
        </h6>
    </div>
    <p class="small text-secondary mb-3">Siswa berikut memiliki pengajuan konseling yang telah melewati jadwal/jam yang ditentukan:</p>
    <div class="table-responsive bg-white rounded border">
        <table class="table table-sm table-hover align-middle mb-0">
            <thead class="table-light small">
                <tr>
                    <th class="ps-3">Nama Siswa</th>
                    <th>Jadwal Konseling</th>
                    <th>Keluhan</th>
                    <th class="text-end pe-3">Aksi Guru BK</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuanTerlewat as $p)
                <tr>
                    <td class="ps-3 fw-semibold text-dark">{{ $p->siswa?->nama ?? '-' }}</td>
                    <td>
                        <span class="badge bg-danger text-white">
                            <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($p->tanggal_konseling)->format('d/m/Y') }}
                            @if($p->jadwal && $p->jadwal->jam)
                                ({{ $p->jadwal->jam }})
                            @endif
                        </span>
                    </td>
                    <td class="small">{{ Str::limit($p->keluhan, 40) }}</td>
                    <td class="text-end pe-3">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('admin.pengajuan.show', $p->id_konseling) }}" class="btn btn-sm btn-outline-success py-1 px-2" style="font-size:0.78rem;" title="Proses Ke Data Konseling">
                                <i class="bi bi-check-circle me-1"></i>Proses Konseling
                            </a>
                            <form method="POST" action="{{ route('admin.pengajuan.tidak-hadir', $p->id_konseling) }}" onsubmit="return confirm('Tandai siswa ini tidak hadir?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" style="font-size:0.78rem;" title="Tandai Tidak Hadir">
                                    <i class="bi bi-person-x me-1"></i>Tandai Tidak Hadir
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ route('admin.konseling.index') }}" class="d-flex gap-2" style="max-width:400px;">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama siswa, guru BK..." value="{{ $filters['search'] ?? '' }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">Cari</button>
            @if(!empty($filters['search']))
                <a href="{{ route('admin.konseling.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            @endif
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Siswa</th>
                        <th>Tanggal</th>
                        <th>Masalah</th>
                        <th>Guru BK</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($konseling as $k)
                    <tr>
                        <td class="ps-3">{{ $konseling->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $k->siswa?->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($k->masalah, 50) }}</td>
                        <td>{{ $k->guru_bk }}</td>
                        <td>
                            <div class="d-flex gap-1 align-items-center">
                                @php $isAbsent = \Illuminate\Support\Str::contains(strtolower($k->solusi ?? ''), 'tidak hadir'); @endphp
                                @if(! $isAbsent)
                                    <form method="POST" action="{{ route('admin.konseling.tidak-hadir', $k->id_data_konseling) }}" onsubmit="return confirm('Kirim pesan otomatis bahwa siswa ini tidak hadir saat konseling?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Kirim Pesan Tidak Hadir & Record Monitoring (-10 Poin)">
                                            <i class="bi bi-envelope-exclamation me-1"></i>Pesan Tidak Hadir
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-danger" title="Siswa dinyatakan tidak hadir"><i class="bi bi-person-x me-1"></i>Tidak Hadir</span>
                                @endif
                                <a href="{{ route('admin.konseling.edit', $k->id_data_konseling) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.konseling.destroy', $k->id_data_konseling) }}" onsubmit="return confirm('Hapus data konseling ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data konseling.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($konseling->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between">
        <small class="text-muted">{{ $konseling->firstItem() }}–{{ $konseling->lastItem() }} dari {{ $konseling->total() }}</small>
        {{ $konseling->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
