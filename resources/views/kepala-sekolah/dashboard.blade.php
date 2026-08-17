@extends('layouts.app')

@section('title', 'Laporan BK — Kepala Sekolah')

@section('breadcrumb')
    <li class="breadcrumb-item active">Laporan BK</li>
@endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-file-earmark-bar-graph me-2 text-primary"></i>Laporan Bimbingan Konseling</h4>
    <p class="text-muted mb-0">Selamat datang, Kepala Sekolah. Anda dapat melihat statistik dan mencetak laporan resmi BK di sini.</p>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-white h-100 shadow-sm" style="background:linear-gradient(135deg,#1e40af,#3b82f6);">
            <div class="card-body text-center py-4">
                <i class="bi bi-people fs-1 opacity-75"></i>
                <div class="display-6 fw-bold mt-2">{{ $stats['totalSiswa'] }}</div>
                <div class="text-white-50 small">Total Siswa</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white h-100 shadow-sm" style="background:linear-gradient(135deg,#065f46,#10b981);">
            <div class="card-body text-center py-4">
                <i class="bi bi-chat-dots fs-1 opacity-75"></i>
                <div class="display-6 fw-bold mt-2">{{ $stats['totalKonseling'] }}</div>
                <div class="text-white-50 small">Total Sesi Konseling</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white h-100 shadow-sm" style="background:linear-gradient(135deg,#7c3aed,#a78bfa);">
            <div class="card-body text-center py-4">
                <i class="bi bi-eye fs-1 opacity-75"></i>
                <div class="display-6 fw-bold mt-2">{{ $stats['totalMonitoring'] }}</div>
                <div class="text-white-50 small">Total Monitoring</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white h-100 shadow-sm" style="background:linear-gradient(135deg,#b45309,#f59e0b);">
            <div class="card-body text-center py-4">
                <i class="bi bi-exclamation-triangle fs-1 opacity-75"></i>
                <div class="display-6 fw-bold mt-2">{{ $stats['totalPelanggaran'] }}</div>
                <div class="text-white-50 small">Total Pelanggaran</div>
            </div>
        </div>
    </div>
</div>

<!-- Pilihan Jenis Laporan (Interactive Cards) -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-collection me-2 text-primary"></i>Pilih Jenis Laporan yang Ingin Ditinjau / Dicetak</h5>
    </div>

    {{-- 1. Siswa --}}
    <div class="col-md-4 col-lg">
        <div class="card h-100 border-0 shadow-sm" style="border-top: 4px solid #1e40af !important;">
            <div class="card-body p-3 text-center">
                <div style="width:42px;height:42px;background:#eff6ff;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;">
                    <i class="bi bi-people-fill text-primary fs-5"></i>
                </div>
                <h6 class="fw-bold mb-1 text-dark" style="font-size:0.88rem;">Data Siswa</h6>
                <small class="text-muted d-block mb-3" style="font-size:0.75rem;">Seluruh Data Siswa</small>
                <a href="{{ route('kepala-sekolah.laporan.siswa') }}" class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-eye me-1"></i>Buka</a>
            </div>
        </div>
    </div>

    {{-- 2. Ajukan Konseling --}}
    <div class="col-md-4 col-lg">
        <div class="card h-100 border-0 shadow-sm" style="border-top: 4px solid #0284c7 !important;">
            <div class="card-body p-3 text-center">
                <div style="width:42px;height:42px;background:#e0f2fe;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;">
                    <i class="bi bi-envelope-paper-fill text-info fs-5"></i>
                </div>
                <h6 class="fw-bold mb-1 text-dark" style="font-size:0.88rem;">Ajukan Konseling</h6>
                <small class="text-muted d-block mb-3" style="font-size:0.75rem;">Pengajuan Siswa</small>
                <a href="{{ route('kepala-sekolah.laporan.ajukan-konseling') }}" class="btn btn-sm btn-outline-info w-100"><i class="bi bi-eye me-1"></i>Buka</a>
            </div>
        </div>
    </div>

    {{-- 3. Data Konseling --}}
    <div class="col-md-4 col-lg">
        <div class="card h-100 border-0 shadow-sm" style="border-top: 4px solid #059669 !important;">
            <div class="card-body p-3 text-center">
                <div style="width:42px;height:42px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;">
                    <i class="bi bi-chat-left-text-fill text-success fs-5"></i>
                </div>
                <h6 class="fw-bold mb-1 text-dark" style="font-size:0.88rem;">Data Konseling</h6>
                <small class="text-muted d-block mb-3" style="font-size:0.75rem;">Hasil Konseling</small>
                <a href="{{ route('kepala-sekolah.laporan.konseling') }}" class="btn btn-sm btn-outline-success w-100"><i class="bi bi-eye me-1"></i>Buka</a>
            </div>
        </div>
    </div>

    {{-- 4. Monitoring --}}
    <div class="col-md-4 col-lg">
        <div class="card h-100 border-0 shadow-sm" style="border-top: 4px solid #7c3aed !important;">
            <div class="card-body p-3 text-center">
                <div style="width:42px;height:42px;background:#f3e8ff;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;">
                    <i class="bi bi-eye-fill text-purple fs-5"></i>
                </div>
                <h6 class="fw-bold mb-1 text-dark" style="font-size:0.88rem;">Monitoring</h6>
                <small class="text-muted d-block mb-3" style="font-size:0.75rem;">Perkembangan</small>
                <a href="{{ route('kepala-sekolah.laporan.monitoring') }}" class="btn btn-sm btn-outline-purple w-100" style="color:#7c3aed;border-color:#7c3aed;"><i class="bi bi-eye me-1"></i>Buka</a>
            </div>
        </div>
    </div>

    {{-- 5. Pelanggaran --}}
    <div class="col-md-4 col-lg">
        <div class="card h-100 border-0 shadow-sm" style="border-top: 4px solid #d97706 !important;">
            <div class="card-body p-3 text-center">
                <div style="width:42px;height:42px;background:#fef3c7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;">
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-5"></i>
                </div>
                <h6 class="fw-bold mb-1 text-dark" style="font-size:0.88rem;">Pelanggaran</h6>
                <small class="text-muted d-block mb-3" style="font-size:0.75rem;">Pelanggaran Siswa</small>
                <a href="{{ route('kepala-sekolah.laporan.pelanggaran') }}" class="btn btn-sm btn-outline-warning w-100"><i class="bi bi-eye me-1"></i>Buka</a>
            </div>
        </div>
    </div>
</div>

<!-- Cetak & Filter Laporan Form -->
<div class="row g-4">
    <div class="col-md-6 col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="card-title fw-bold text-primary mb-0"><i class="bi bi-file-earmark-text me-2"></i>Form Tinjau Laporan</h5>
            </div>
            <div class="card-body p-4">
                <form id="formLaporanKepala" method="GET" action="{{ route('kepala-sekolah.laporan.index') }}">
                    <div class="mb-3">
                        <label for="jenis" class="form-label fw-semibold">Pilih Jenis Laporan <span class="text-danger">*</span></label>
                        <select name="jenis" id="jenis" class="form-select form-select-lg" required>
                            <option value="siswa">Input Data Siswa</option>
                            <option value="ajukan-konseling">Laporan Ajukan Konseling</option>
                            <option value="konseling">Laporan Data Konseling</option>
                            <option value="monitoring">Laporan Data Monitoring</option>
                            <option value="pelanggaran">Laporan Data Pelanggaran</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="periode" class="form-label fw-semibold">Pilih Periode Laporan <span class="text-danger">*</span></label>
                        <select name="periode" id="periode" class="form-select form-select-lg" required>
                            <option value="semua">Semua Periode</option>
                            <option value="bulanan">Bulan Ini</option>
                            <option value="tahunan">Tahun Ini</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1"><i class="bi bi-eye me-2"></i>Buka Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="card-title fw-bold mb-0"><i class="bi bi-info-circle me-2 text-info"></i>Petunjuk Akses Laporan</h5>
            </div>
            <div class="card-body p-4 text-muted">
                <p>Sebagai Kepala Sekolah, Anda memiliki wewenang penuh untuk meninjau seluruh data dan mencetak laporan resmi Bimbingan Konseling SMKN 3 Padang.</p>
                <ul class="ps-3 mb-0" style="line-height:1.8;">
                    <li><strong>Input Data Siswa</strong>: Berisi seluruh data profil siswa terdaftar.</li>
                    <li><strong>Laporan Ajukan Konseling</strong>: Berisi daftar pengajuan sesi konseling dari siswa.</li>
                    <li><strong>Laporan Konseling</strong>: Berisi rekapitulasi data konseling siswa beserta pembahasan & solusi.</li>
                    <li><strong>Laporan Monitoring</strong>: Berisi catatan perkembangan perilaku siswa (perilaku baik/buruk).</li>
                    <li><strong>Laporan Pelanggaran</strong>: Berisi catatan pelanggaran dan pemotongan poin siswa.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function tinjauLaporan() {
        const jenis = document.getElementById('jenis').value;
        const periode = document.getElementById('periode').value;
        window.location.href = "{{ url('/kepala-sekolah/laporan') }}/" + jenis + "?periode=" + periode;
    }
</script>

@endsection
