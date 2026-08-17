@extends('layouts.app')

@section('title', 'Dashboard Guru BK')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-grid-1x2 me-2 text-primary"></i>Dashboard Guru BK</h4>
    <p class="text-muted mb-0">Selamat datang, {{ auth()->user()->nama }}. Berikut ringkasan data hari ini.</p>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-2">
        <div class="card text-white h-100" style="background:linear-gradient(135deg,#1e40af,#3b82f6);">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span style="font-size:0.8rem;opacity:0.9;">Total Siswa</span>
                    <i class="bi bi-people" style="font-size:1.4rem;opacity:0.7;"></i>
                </div>
                <div style="font-size:2rem;font-weight:700;">{{ $stats['totalSiswa'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2">
        <div class="card text-white h-100" style="background:linear-gradient(135deg,#065f46,#10b981);">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span style="font-size:0.8rem;opacity:0.9;">Konseling</span>
                    <i class="bi bi-chat-dots" style="font-size:1.4rem;opacity:0.7;"></i>
                </div>
                <div style="font-size:2rem;font-weight:700;">{{ $stats['totalKonseling'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2">
        <div class="card text-white h-100" style="background:linear-gradient(135deg,#7c3aed,#a78bfa);">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span style="font-size:0.8rem;opacity:0.9;">Monitoring</span>
                    <i class="bi bi-eye" style="font-size:1.4rem;opacity:0.7;"></i>
                </div>
                <div style="font-size:2rem;font-weight:700;">{{ $stats['totalMonitoring'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2">
        <div class="card text-white h-100" style="background:linear-gradient(135deg,#b45309,#f59e0b);">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span style="font-size:0.8rem;opacity:0.9;">Pelanggaran</span>
                    <i class="bi bi-exclamation-triangle" style="font-size:1.4rem;opacity:0.7;"></i>
                </div>
                <div style="font-size:2rem;font-weight:700;">{{ $stats['totalPelanggaran'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2">
        <div class="card text-white h-100" style="background:linear-gradient(135deg,#be185d,#ec4899);">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span style="font-size:0.8rem;opacity:0.9;">Pengajuan</span>
                    <i class="bi bi-inbox" style="font-size:1.4rem;opacity:0.7;"></i>
                </div>
                <div style="font-size:2rem;font-weight:700;">{{ $stats['totalPengajuan'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-2">
        <div class="card text-white h-100" style="background:linear-gradient(135deg,#0f766e,#2dd4bf);">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span style="font-size:0.8rem;opacity:0.9;">Total Akun</span>
                    <i class="bi bi-person-badge" style="font-size:1.4rem;opacity:0.7;"></i>
                </div>
                <div style="font-size:2rem;font-weight:700;">{{ $stats['totalAkun'] }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Tables -->
<div class="row g-3">
    <!-- Konseling Terbaru -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-chat-dots me-2 text-success"></i>Konseling Terbaru</span>
                <a href="{{ route('admin.konseling.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Siswa</th>
                                <th>Tanggal</th>
                                <th>Guru BK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($konselingTerbaru as $k)
                            <tr>
                                <td class="ps-3">{{ $k->siswa?->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $k->guru_bk }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Belum ada data konseling.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengajuan Terbaru -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-inbox me-2 text-warning"></i>Pengajuan Terbaru</span>
                <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Siswa</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuanTerbaru as $p)
                            <tr>
                                <td class="ps-3">{{ $p->siswa?->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_konseling)->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.pengajuan.show', $p->id_konseling) }}" class="btn btn-xs btn-sm btn-outline-primary" style="font-size:0.75rem;">Proses</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Tidak ada pengajuan baru.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pelanggaran Terbaru -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Pelanggaran Terbaru</span>
                <a href="{{ route('admin.pelanggaran.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Siswa</th>
                                <th>Tanggal</th>
                                <th>Poin</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelanggaranTerbaru as $pl)
                            <tr>
                                <td class="ps-3">{{ $pl->siswa?->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($pl->tanggal_pelanggaran)->format('d/m/Y') }}</td>
                                <td><span class="badge bg-danger">{{ $pl->poin }} poin</span></td>
                                <td>{{ Str::limit($pl->tindakan, 50) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data pelanggaran.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
