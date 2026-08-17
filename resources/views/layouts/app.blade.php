<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIBk') — SMKN 3 Padang</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --sidebar-bg: #0f172a;
            --sidebar-text: #cbd5e1;
            --sidebar-active: #1e40af;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;           /* tinggi layar penuh */
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            overflow: hidden;        /* sembunyikan overflow di luar nav */
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            text-decoration: none;
            flex-shrink: 0;          /* tidak ikut menyusut */
        }

        .sidebar-brand h5 {
            color: #fff;
            font-weight: 700;
            margin: 0;
            font-size: 1rem;
        }

        .sidebar-brand small {
            color: #64748b;
            font-size: 0.72rem;
        }

        /* Nav area scrollable */
        .sidebar-nav {
            flex: 1;
            padding: 0.75rem 0;
            overflow-y: auto;        /* scroll jika konten melebihi tinggi */
            overflow-x: hidden;
        }

        /* Custom scrollbar untuk sidebar */
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }

        .sidebar-section-title {
            padding: 0.6rem 1.5rem 0.2rem;
            font-size: 0.67rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #475569;
        }

        /* Nav link biasa */
        .sidebar-nav .nav-link {
            padding: 0.52rem 1.5rem;
            color: var(--sidebar-text);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            border-radius: 0;
            transition: all 0.15s;
            text-decoration: none;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,0.06);
            color: #fff;
        }

        .sidebar-nav .nav-link.active {
            background: var(--sidebar-active);
            color: #fff;
        }

        .sidebar-nav .nav-link i {
            font-size: 1rem;
            width: 1.2rem;
            text-align: center;
            flex-shrink: 0;
        }

        /* ===== Collapsible Group ===== */
        .sidebar-group-btn {
            padding: 0.52rem 1.5rem;
            color: var(--sidebar-text);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
            transition: all 0.15s;
            text-align: left;
        }

        .sidebar-group-btn:hover {
            background: rgba(255,255,255,0.06);
            color: #fff;
        }

        /* group aktif (salah satu child aktif) */
        .sidebar-group-btn.group-active {
            color: #fff;
        }

        .sidebar-group-btn i.group-icon {
            font-size: 1rem;
            width: 1.2rem;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-group-btn .group-label {
            flex: 1;
        }

        .sidebar-group-btn .chevron {
            font-size: 0.75rem;
            transition: transform 0.2s;
            margin-left: auto;
        }

        .sidebar-group-btn[aria-expanded="true"] .chevron {
            transform: rotate(90deg);
        }

        /* Sub-menu container */
        .sidebar-submenu {
            background: rgba(0,0,0,0.18);
        }

        .sidebar-submenu .nav-link {
            padding: 0.45rem 1.5rem 0.45rem 3.2rem;
            font-size: 0.835rem;
        }

        .sidebar-submenu .nav-link::before {
            content: '';
            display: inline-block;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            margin-right: 0.5rem;
            flex-shrink: 0;
        }

        .sidebar-submenu .nav-link.active::before {
            background: #fff;
        }

        /* ===== Footer ===== */
        .sidebar-footer {
            padding: 0.875rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.08);
            flex-shrink: 0;
        }

        .sidebar-footer .user-info {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .sidebar-footer .user-name {
            color: #fff;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* ===== Main Content ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        /* Cards */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            padding: 1rem 1.25rem;
            font-weight: 600;
        }

        /* Toast */
        .toast-container {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 9999;
        }

        /* Mobile */
        .sidebar-toggle { display: none; }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-toggle { display: inline-flex; }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.4);
                z-index: 1029;
            }

            .sidebar-overlay.show { display: block; }
        }

        .page-header { margin-bottom: 1.5rem; }
        .page-header h4 { font-weight: 700; color: #0f172a; margin-bottom: 0.25rem; }
        .page-header .breadcrumb { font-size: 0.8rem; }
    </style>

    @stack('styles')
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-brand d-flex align-items-center gap-2">
        <div style="width:36px;height:36px;background:#1e40af;border-radius:8px;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-heart-pulse text-white" style="font-size:1.1rem;"></i>
        </div>
        <div>
            <h5>SIBk</h5>
            <small>SMKN 3 Padang</small>
        </div>
    </a>

    <nav class="sidebar-nav">
        @php $role = auth()->user()?->role; @endphp

        @if ($role === 'guru_bk')
            {{-- Menu Utama --}}
            <div class="sidebar-section-title">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>

            {{-- Master Data (collapsible) --}}
            @php
                $masterDataActive = request()->routeIs('admin.siswa.*') || request()->routeIs('admin.register.*');
                $masterOpen = $masterDataActive ? 'true' : 'false';
            @endphp
            <div class="sidebar-section-title mt-2">Master Data</div>
            <button class="sidebar-group-btn {{ $masterDataActive ? 'group-active' : '' }}"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuMasterData"
                    aria-expanded="{{ $masterOpen }}">
                <i class="bi bi-database group-icon"></i>
                <span class="group-label">Master Data</span>
                <i class="bi bi-chevron-right chevron"></i>
            </button>
            <div class="collapse sidebar-submenu {{ $masterDataActive ? 'show' : '' }}" id="menuMasterData">
                <a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                    Data Siswa
                </a>
                <a href="{{ route('admin.register.index') }}" class="nav-link {{ request()->routeIs('admin.register.*') ? 'active' : '' }}">
                    Manajemen Akun
                </a>
            </div>

            {{-- Transaksi (collapsible) --}}
            @php
                $transaksiActive = request()->routeIs('admin.konseling.*')
                    || request()->routeIs('admin.monitoring.*')
                    || request()->routeIs('admin.pelanggaran.*')
                    || request()->routeIs('admin.pengajuan.*');
                $transaksiOpen = $transaksiActive ? 'true' : 'false';
            @endphp
            <div class="sidebar-section-title mt-2">Transaksi</div>
            <button class="sidebar-group-btn {{ $transaksiActive ? 'group-active' : '' }}"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuTransaksi"
                    aria-expanded="{{ $transaksiOpen }}">
                <i class="bi bi-activity group-icon"></i>
                <span class="group-label">Transaksi</span>
                <i class="bi bi-chevron-right chevron"></i>
            </button>
            <div class="collapse sidebar-submenu {{ $transaksiActive ? 'show' : '' }}" id="menuTransaksi">
                <a href="{{ route('admin.konseling.index') }}" class="nav-link {{ request()->routeIs('admin.konseling.*') ? 'active' : '' }}">
                    Data Konseling
                </a>
                <a href="{{ route('admin.monitoring.index') }}" class="nav-link {{ request()->routeIs('admin.monitoring.*') ? 'active' : '' }}">
                    Monitoring
                </a>
                <a href="{{ route('admin.pelanggaran.index') }}" class="nav-link {{ request()->routeIs('admin.pelanggaran.*') ? 'active' : '' }}">
                    Pelanggaran
                </a>
                <a href="{{ route('admin.pengajuan.index') }}" class="nav-link {{ request()->routeIs('admin.pengajuan.*') ? 'active' : '' }} d-flex align-items-center justify-content-between pe-3">
                    <span>Pengajuan Konseling</span>
                    @php $jmlPengajuan = \App\Models\AjukanKonseling::forGuruBk(auth()->user()?->nama ?? '')->count(); @endphp
                    @if ($jmlPengajuan > 0)
                        <span class="badge bg-danger rounded-pill" style="font-size:0.6rem;">{{ $jmlPengajuan > 99 ? '99+' : $jmlPengajuan }}</span>
                    @endif
                </a>
            </div>

            {{-- Layanan (collapsible) --}}
            @php
                $layananActive = request()->routeIs('admin.jadwal.*')
                    || request()->routeIs('admin.tata-tertib.*')
                    || request()->routeIs('admin.informasi.*');
                $layananOpen = $layananActive ? 'true' : 'false';
            @endphp
            <div class="sidebar-section-title mt-2">Layanan BK</div>
            <button class="sidebar-group-btn {{ $layananActive ? 'group-active' : '' }}"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuLayanan"
                    aria-expanded="{{ $layananOpen }}">
                <i class="bi bi-collection group-icon"></i>
                <span class="group-label">Layanan BK</span>
                <i class="bi bi-chevron-right chevron"></i>
            </button>
            <div class="collapse sidebar-submenu {{ $layananActive ? 'show' : '' }}" id="menuLayanan">
                <a href="{{ route('admin.jadwal.index') }}" class="nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                    Jadwal Layanan BK
                </a>
                <a href="{{ route('admin.tata-tertib.index') }}" class="nav-link {{ request()->routeIs('admin.tata-tertib.*') ? 'active' : '' }}">
                    Tata Tertib
                </a>
                <a href="{{ route('admin.informasi.index') }}" class="nav-link {{ request()->routeIs('admin.informasi.*') ? 'active' : '' }}">
                    Informasi BK
                </a>
            </div>

            {{-- Laporan (collapsible) --}}
            @php
                $laporanActive = request()->routeIs('admin.laporan.*');
                $laporanOpen = $laporanActive ? 'true' : 'false';
            @endphp
            <div class="sidebar-section-title mt-2">Laporan</div>
            <button class="sidebar-group-btn {{ $laporanActive ? 'group-active' : '' }}"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuLaporan"
                    aria-expanded="{{ $laporanOpen }}">
                <i class="bi bi-file-earmark-bar-graph group-icon"></i>
                <span class="group-label">Laporan</span>
                <i class="bi bi-chevron-right chevron"></i>
            </button>
            <div class="collapse sidebar-submenu {{ $laporanActive ? 'show' : '' }}" id="menuLaporan">
                <a href="{{ route('admin.laporan.siswa') }}" class="nav-link {{ request()->routeIs('admin.laporan.siswa') ? 'active' : '' }}">
                    Input Data Siswa
                </a>
                <a href="{{ route('admin.laporan.ajukan-konseling') }}" class="nav-link {{ request()->routeIs('admin.laporan.ajukan-konseling') ? 'active' : '' }}">
                    Laporan Ajukan Konseling
                </a>
                <a href="{{ route('admin.laporan.konseling') }}" class="nav-link {{ request()->routeIs('admin.laporan.konseling') ? 'active' : '' }}">
                    Laporan Data Konseling
                </a>
                <a href="{{ route('admin.laporan.monitoring') }}" class="nav-link {{ request()->routeIs('admin.laporan.monitoring') ? 'active' : '' }}">
                    Laporan Data Monitoring
                </a>
                <a href="{{ route('admin.laporan.pelanggaran') }}" class="nav-link {{ request()->routeIs('admin.laporan.pelanggaran') ? 'active' : '' }}">
                    Laporan Data Pelanggaran
                </a>
            </div>

        @elseif ($role === 'siswa')
            <div class="sidebar-section-title">Menu Siswa</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard Siswa
            </a>

        @elseif ($role === 'orang_tua')
            <div class="sidebar-section-title">Menu Orang Tua</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-search"></i> Monitoring Anak
            </a>

        @elseif ($role === 'kepala_sekolah')
            <div class="sidebar-section-title">Menu Kepala Sekolah</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>

            @php
                $laporanKepalaActive = request()->routeIs('kepala-sekolah.laporan.*');
                $laporanKepalaOpen = $laporanKepalaActive ? 'true' : 'false';
            @endphp
            <div class="sidebar-section-title mt-2">Laporan BK</div>
            <button class="sidebar-group-btn {{ $laporanKepalaActive ? 'group-active' : '' }}"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuLaporanKepala"
                    aria-expanded="{{ $laporanKepalaOpen }}">
                <i class="bi bi-file-earmark-bar-graph group-icon"></i>
                <span class="group-label">Laporan</span>
                <i class="bi bi-chevron-right chevron"></i>
            </button>
            <div class="collapse sidebar-submenu {{ $laporanKepalaActive ? 'show' : '' }}" id="menuLaporanKepala">
                <a href="{{ route('kepala-sekolah.laporan.siswa') }}" class="nav-link {{ request()->routeIs('kepala-sekolah.laporan.siswa') ? 'active' : '' }}">
                    Input Data Siswa
                </a>
                <a href="{{ route('kepala-sekolah.laporan.ajukan-konseling') }}" class="nav-link {{ request()->routeIs('kepala-sekolah.laporan.ajukan-konseling') ? 'active' : '' }}">
                    Laporan Ajukan Konseling
                </a>
                <a href="{{ route('kepala-sekolah.laporan.konseling') }}" class="nav-link {{ request()->routeIs('kepala-sekolah.laporan.konseling') ? 'active' : '' }}">
                    Laporan Data Konseling
                </a>
                <a href="{{ route('kepala-sekolah.laporan.monitoring') }}" class="nav-link {{ request()->routeIs('kepala-sekolah.laporan.monitoring') ? 'active' : '' }}">
                    Laporan Data Monitoring
                </a>
                <a href="{{ route('kepala-sekolah.laporan.pelanggaran') }}" class="nav-link {{ request()->routeIs('kepala-sekolah.laporan.pelanggaran') ? 'active' : '' }}">
                    Laporan Data Pelanggaran
                </a>
            </div>
        @endif

        {{-- Pengaturan --}}
        <div class="sidebar-section-title mt-2">Pengaturan</div>
        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Profil
        </a>
        <a href="{{ route('security.edit') }}" class="nav-link {{ request()->routeIs('security.edit') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i> Keamanan
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div style="width:34px;height:34px;background:#1e40af;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-person-fill text-white" style="font-size:0.9rem;"></i>
            </div>
            <div class="overflow-hidden">
                <div class="user-name text-truncate">{{ auth()->user()?->nama }}</div>
                <div class="user-info text-truncate">
                    @php
                        $roleLabels = ['guru_bk'=>'Guru BK','siswa'=>'Siswa','orang_tua'=>'Orang Tua','kepala_sekolah'=>'Kepala Sekolah'];
                    @endphp
                    {{ $roleLabels[auth()->user()?->role] ?? auth()->user()?->role }}
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="ms-auto">
                @csrf
                <button type="submit" class="btn btn-sm btn-link text-secondary p-0" title="Logout">
                    <i class="bi bi-box-arrow-right" style="font-size:1.1rem;"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Main Content -->
<div class="main-content">
    <!-- Topbar -->
    <div class="topbar d-flex align-items-center gap-3">
        <button class="btn btn-sm btn-outline-secondary sidebar-toggle" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <nav aria-label="breadcrumb" class="mb-0">
            <ol class="breadcrumb mb-0">
                @yield('breadcrumb')
            </ol>
        </nav>
        <div class="ms-auto d-flex align-items-center gap-2">
            @php
                $roleBadges = ['guru_bk'=>'bg-primary','siswa'=>'bg-success','orang_tua'=>'bg-info','kepala_sekolah'=>'bg-warning text-dark'];
                $roleLabels = ['guru_bk'=>'Guru BK','siswa'=>'Siswa','orang_tua'=>'Orang Tua','kepala_sekolah'=>'Kepala Sekolah'];
            @endphp

            {{-- Notifikasi Pengajuan Konseling (hanya Guru BK) --}}
            @if ($role === 'guru_bk')
                @php $jumlahPengajuan = \App\Models\AjukanKonseling::forGuruBk(auth()->user()?->nama ?? '')->count(); @endphp
                <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-sm btn-outline-secondary position-relative" title="Pengajuan Konseling Masuk">
                    <i class="bi bi-bell"></i>
                    @if ($jumlahPengajuan > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem;">
                            {{ $jumlahPengajuan > 99 ? '99+' : $jumlahPengajuan }}
                        </span>
                    @endif
                </a>
            @elseif ($role === 'siswa')
                @php
                    $siswaUser = auth()->user()?->siswa;
                    $notifApproved = $siswaUser
                        ? \App\Models\InputDataKonseling::where('id_siswa', $siswaUser->id_siswa)->latest()->take(5)->get()
                        : collect();
                    $jmlApproved = $notifApproved->count();
                @endphp
                <div class="dropdown" id="containerNotifSiswa">
                    <button class="btn btn-sm btn-outline-secondary position-relative dropdown-toggle-no-caret" type="button" id="notifSiswaDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Pemberitahuan Konseling">
                        <i class="bi bi-bell"></i>
                        <span id="badgeNotifSiswa" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success {{ $jmlApproved == 0 ? 'd-none' : '' }}" style="font-size:0.6rem;">
                            {{ $jmlApproved }}
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="notifSiswaDropdown" style="width: 320px; max-height: 400px; overflow-y: auto;">
                        <li class="dropdown-header fw-bold text-dark border-bottom pb-2 d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-bell-fill text-success me-1"></i> Pemberitahuan</span>
                            @if($jmlApproved > 0)
                                <button type="button" class="btn btn-link text-decoration-none p-0 text-success small" style="font-size: 0.75rem;" onclick="tandaiSemuaDibaca()">
                                    <i class="bi bi-check2-all me-1"></i>Tandai Dibaca
                                </button>
                            @endif
                        </li>
                        <div id="listNotifSiswa">
                        @forelse ($notifApproved as $notif)
                            <li class="item-notif-siswa" data-id="{{ $notif->id_data_konseling }}">
                                <a class="dropdown-item py-2 px-3 border-bottom text-wrap" href="{{ route('dashboard') }}" onclick="tandaiSatuDibaca({{ $notif->id_data_konseling }})">
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="bi bi-check-circle-fill text-success mt-1 fs-6"></i>
                                        <div>
                                            <div class="fw-semibold text-dark small d-flex align-items-center justify-content-between">
                                                <span>Konseling Disetujui</span>
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill badge-baru ms-2" style="font-size: 0.65rem;">Baru</span>
                                            </div>
                                            <div class="text-secondary" style="font-size: 0.78rem;">
                                                Tanggal: <strong>{{ \Carbon\Carbon::parse($notif->tanggal)->format('d M Y') }}</strong><br>
                                                Guru BK: <strong>{{ $notif->guru_bk }}</strong>
                                            </div>
                                            <small class="text-muted" style="font-size: 0.7rem;">Masalah: {{ Str::limit($notif->masalah, 35) }}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="py-4 text-center text-muted">
                                <i class="bi bi-bell-slash d-block fs-3 mb-1 opacity-50"></i>
                                <span class="small">Belum ada pemberitahuan konseling</span>
                            </li>
                        @endforelse
                        </div>
                    </ul>
                </div>
            @endif

            <span class="badge {{ $roleBadges[$role] ?? 'bg-secondary' }}">{{ $roleLabels[$role] ?? $role }}</span>
        </div>
    </div>

    <!-- Page Content -->
    <div class="flex-grow-1 p-4">
        {{-- Toast notifications --}}
        @if (session('toast'))
            <div class="toast-container">
                <div class="toast align-items-center text-bg-{{ session('toast.type') === 'success' ? 'success' : 'danger' }} border-0 show" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-{{ session('toast.type') === 'success' ? 'check-circle' : 'x-circle' }} me-2"></i>
                            {{ session('toast.message') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Auto-hide toast
        document.querySelectorAll('.toast').forEach(function (el) {
            setTimeout(function () { el.classList.remove('show'); }, 4000);
        });

        // Simpan state collapse ke localStorage agar tetap terbuka saat berpindah halaman
        document.querySelectorAll('.sidebar-group-btn').forEach(function (btn) {
            var target = btn.getAttribute('data-bs-target');
            var el = document.querySelector(target);
            if (!el) return;

            el.addEventListener('show.bs.collapse', function () {
                localStorage.setItem('sb_' + target, '1');
            });
            el.addEventListener('hide.bs.collapse', function () {
                localStorage.removeItem('sb_' + target);
            });
        });

        // System Notifikasi Siswa (localStorage)
        updateNotifSiswaUI();
    });

    function getReadNotifIds() {
        try {
            return JSON.parse(localStorage.getItem('read_notif_ids') || '[]');
        } catch (e) {
            return [];
        }
    }

    function saveReadNotifIds(ids) {
        localStorage.setItem('read_notif_ids', JSON.stringify(ids));
    }

    function updateNotifSiswaUI() {
        const readIds = getReadNotifIds();
        const items = document.querySelectorAll('.item-notif-siswa');
        if (!items || items.length === 0) return;

        let unreadCount = 0;
        items.forEach(function(item) {
            const id = parseInt(item.getAttribute('data-id'));
            const badgeBaru = item.querySelector('.badge-baru');
            if (readIds.includes(id)) {
                if (badgeBaru) badgeBaru.classList.add('d-none');
                item.style.opacity = '0.55';
            } else {
                unreadCount++;
                if (badgeBaru) badgeBaru.classList.remove('d-none');
                item.style.opacity = '1';
            }
        });

        const badgeEl = document.getElementById('badgeNotifSiswa');
        if (badgeEl) {
            if (unreadCount > 0) {
                badgeEl.textContent = unreadCount;
                badgeEl.classList.remove('d-none');
            } else {
                badgeEl.classList.add('d-none');
            }
        }
    }

    function tandaiSatuDibaca(id) {
        let readIds = getReadNotifIds();
        if (!readIds.includes(id)) {
            readIds.push(id);
            saveReadNotifIds(readIds);
        }
        updateNotifSiswaUI();
    }

    function tandaiSemuaDibaca() {
        const items = document.querySelectorAll('.item-notif-siswa');
        let readIds = getReadNotifIds();
        items.forEach(function(item) {
            const id = parseInt(item.getAttribute('data-id'));
            if (!readIds.includes(id)) {
                readIds.push(id);
            }
        });
        saveReadNotifIds(readIds);
        updateNotifSiswaUI();

        // Sembunyikan juga banner di dashboard jika ada
        const banner = document.getElementById('alertBannerKonseling');
        if (banner) {
            banner.classList.add('d-none');
        }
    }
</script>

@stack('scripts')
</body>
</html>
