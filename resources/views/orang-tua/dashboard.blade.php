@extends('layouts.app')

@section('title', 'Dashboard Orang Tua')

@section('breadcrumb')
    <li class="breadcrumb-item active">Monitoring Anak</li>
@endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-person-bounding-box me-2 text-primary"></i>Monitoring Perkembangan Anak</h4>
    <p class="text-muted mb-0">Silakan cari data anak Anda berdasarkan NISN atau Nama Siswa di bawah ini.</p>
</div>

<!-- Search Form Card -->
<div class="card mb-4 border-primary shadow-sm">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('dashboard') }}" class="row g-3 align-items-center">
            <div class="col-md-9 col-lg-10">
                <label for="search" class="form-label fw-bold">Cari Data Siswa / Anak</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-primary"></i></span>
                    <input type="text" id="search" name="search" class="form-control form-control-lg border-start-0" placeholder="Ketikkan NISN atau Nama Siswa (Contoh: 1234567890 / Budi)..." value="{{ $search ?? '' }}" required autofocus>
                </div>
            </div>
            <div class="col-md-3 col-lg-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-lg w-100 mt-md-4"><i class="bi bi-search me-1"></i> Cari Data</button>
            </div>
        </form>
    </div>
</div>

@if(empty($search))
    <!-- State Sebelum Mencari (Belum ada data yang muncul) -->
    <div class="card border-0 shadow-sm py-5 text-center">
        <div class="card-body">
            <div style="width:80px;height:80px;background:#eff6ff;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                <i class="bi bi-search text-primary" style="font-size:2.5rem;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2">Belum Ada Data yang Ditampilkan</h5>
            <p class="text-muted mb-0" style="max-width:500px;margin:0 auto;">
                Silakan masukkan <strong>NISN</strong> atau <strong>Nama Lengkap Siswa</strong> pada kolom pencarian di atas untuk melihat catatan perkembangan, konseling, dan riwayat pelanggaran anak Anda.
            </p>
        </div>
    </div>
@else
    <!-- Hasil Pencarian -->
    <div class="alert alert-info d-flex align-items-center justify-content-between mb-4">
        <div>
            <i class="bi bi-info-circle me-2"></i>Menampilkan hasil pencarian untuk: <strong>"{{ $search }}"</strong>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-info">Reset Pencarian</a>
    </div>

    @forelse($siswa as $s)
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3">
                <div style="width:44px;height:44px;background:#eff6ff;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-person-fill text-primary" style="font-size:1.2rem;"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">{{ $s->nama }}</h5>
                    <span class="text-muted" style="font-size:0.875rem;">NISN: <strong>{{ $s->nisn }}</strong> | Kelas: <strong>{{ $s->kelas }}</strong></span>
                </div>
            </div>
            <div>
                <span class="badge bg-primary px-3 py-2" style="font-size:0.85rem;"><i class="bi bi-telephone me-1"></i> {{ $s->no_hp }}</span>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <!-- Info Siswa -->
                <div class="col-12">
                    <div class="p-3 bg-light rounded d-flex align-items-center gap-3">
                        <i class="bi bi-geo-alt text-danger fs-4"></i>
                        <div>
                            <small class="text-muted text-uppercase d-block fw-bold" style="font-size:0.7rem;">Alamat Rumah</small>
                            <span class="text-dark">{{ $s->alamat }}</span>
                        </div>
                    </div>
                </div>

                <!-- Monitoring Perkembangan -->
                <div class="col-md-6">
                    <div class="card h-100 border">
                        <div class="card-header bg-light d-flex align-items-center gap-2">
                            <i class="bi bi-eye text-primary"></i>
                            <span class="fw-bold">Catatan Perkembangan (Monitoring)</span>
                        </div>
                        <div class="card-body">
                            @if($s->monitoring->isEmpty())
                                <p class="text-muted my-3 text-center" style="font-size:0.875rem;"><i class="bi bi-inbox me-1"></i>Belum ada catatan monitoring.</p>
                            @else
                                <div class="timeline">
                                    @foreach($s->monitoring as $m)
                                    @php
                                        $textLower = strtolower($m->perkembangan ?? '');
                                        $isBuruk = \Illuminate\Support\Str::contains($textLower, ['buruk', 'kurang', 'nakal', 'bolos', 'langgar', 'lambat', 'penurunan', 'masalah', 'tidak', 'jelek', 'parah']);
                                    @endphp
                                    <div class="mb-3 pb-2 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="badge bg-secondary"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($m->tanggal_monitoring)->format('d M Y') }}</small>
                                            @if(! $isBuruk)
                                                <small class="badge bg-success bg-opacity-10 text-success border border-success"><i class="bi bi-plus-circle me-1"></i>+10 Poin</small>
                                            @endif
                                        </div>
                                        <p class="mb-0 {{ $isBuruk ? 'text-danger fw-bold' : 'text-success fw-bold' }}" style="font-size:0.9rem;line-height:1.5;">{{ $m->perkembangan }}</p>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Riwayat Pelanggaran & Poin -->
                <div class="col-md-6">
                    <div class="card h-100 border">
                        <div class="card-header bg-light d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle text-danger"></i>
                                <span class="fw-bold">Riwayat Pelanggaran & Poin</span>
                            </div>
                            @php
                                $sisaPoin = $s->sisa_poin;
                            @endphp
                            <span class="badge {{ $sisaPoin >= 100 ? 'bg-success' : ($sisaPoin >= 70 ? 'bg-warning text-dark' : 'bg-danger') }} px-3 py-2" style="font-size:0.85rem;">
                                Total Sisa Poin: {{ $sisaPoin }} Poin
                            </span>
                        </div>
                        <div class="card-body">
                            @if($s->pelanggaran->isEmpty())
                                <div class="text-center py-4 text-success">
                                    <i class="bi bi-check-circle-fill fs-2 d-block mb-1"></i>
                                    <span class="fw-semibold">Tidak ada catatan pelanggaran.</span>
                                </div>
                            @else
                                <div class="list-group list-group-flush">
                                    @foreach($s->pelanggaran as $pl)
                                    <div class="list-group-item px-0">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($pl->tanggal_pelanggaran)->format('d M Y') }}</small>
                                            <span class="badge bg-danger">-{{ $pl->poin }} Poin</span>
                                        </div>
                                        <p class="mb-0 text-dark" style="font-size:0.875rem;"><strong>Tindakan/Catatan:</strong> {{ $pl->tindakan }}</p>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card border-0 shadow-sm py-5 text-center">
        <div class="card-body">
            <i class="bi bi-exclamation-circle text-warning" style="font-size:3rem;"></i>
            <h5 class="mt-3 fw-bold">Data Siswa Tidak Ditemukan</h5>
            <p class="text-muted mb-0">Pastikan NISN atau Nama Siswa yang Anda masukkan sudah benar.</p>
        </div>
    </div>
    @endforelse
@endif
@endsection
