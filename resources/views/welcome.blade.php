<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Bimbingan Konseling SMKN 3 Padang — Platform digital manajemen layanan BK siswa.">
    <title>SIBk — Sistem Informasi Bimbingan Konseling SMKN 3 Padang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: #fff; }

        /* ===== Navbar ===== */
        .main-navbar {
            background: rgba(15,23,42,0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.07);
            position: sticky;
            top: 0;
            z-index: 999;
            padding: 0.75rem 0;
            transition: background 0.3s;
        }

        .navbar-brand-text {
            font-weight: 800;
            font-size: 1.2rem;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .brand-icon {
            width: 34px;
            height: 34px;
            background: #1e40af;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-menu a {
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            padding: 0.45rem 0.9rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            color: #fff;
            background: rgba(255,255,255,0.1);
        }

        .nav-menu a.active {
            background: rgba(30,64,175,0.6);
        }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ===== Hero ===== */
        #beranda {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 55%, #1e40af 100%);
            min-height: 88vh;
            display: flex;
            align-items: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        #beranda::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 70% 50%, rgba(99,102,241,0.25) 0%, transparent 60%);
        }

        .hero-title {
            font-weight: 800;
            font-size: clamp(2rem, 5vw, 3.2rem);
            line-height: 1.15;
        }

        .hero-sub {
            font-size: 1.05rem;
            color: rgba(255,255,255,0.75);
            line-height: 1.7;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 100px;
            padding: 0.3rem 0.85rem;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.85);
            margin-bottom: 1.25rem;
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 2.5rem;
            flex-wrap: wrap;
        }

        .hero-stat-item { text-align: center; }
        .hero-stat-num { font-weight: 800; font-size: 1.75rem; color: #fff; line-height: 1; }
        .hero-stat-label { font-size: 0.75rem; color: rgba(255,255,255,0.6); margin-top: 0.2rem; }

        .hero-illustration {
            width: 100%;
            max-width: 360px;
            opacity: 0.85;
        }

        /* ===== Section Common ===== */
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.3rem 0.8rem;
            border-radius: 100px;
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-weight: 800;
            font-size: clamp(1.5rem, 3vw, 2rem);
            color: #0f172a;
            line-height: 1.2;
            margin-bottom: 0.5rem;
        }

        .section-desc {
            color: #64748b;
            font-size: 0.95rem;
            max-width: 540px;
        }

        /* ===== Jadwal Section ===== */
        #jadwal { background: #f8fafc; padding: 5rem 0; scroll-margin-top: 70px; }

        .jadwal-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.25s;
        }

        .jadwal-card:hover {
            box-shadow: 0 12px 30px rgba(30,64,175,0.12);
            border-color: #bfdbfe;
            transform: translateY(-4px);
        }

        .jadwal-day-icon {
            width: 46px;
            height: 46px;
            background: #eff6ff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #1e40af;
        }

        /* ===== Tata Tertib Section ===== */
        #tata-tertib { background: #fff; padding: 5rem 0; scroll-margin-top: 70px; }

        .tatib-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem 1.25rem;
            border: 1px solid #f1f5f9;
            border-radius: 0.75rem;
            background: #f8fafc;
            transition: all 0.2s;
        }

        .tatib-item:hover {
            background: #fff;
            border-color: #e2e8f0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .tatib-num {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: #fff7ed;
            color: #ea580c;
            font-weight: 700;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* ===== Informasi Section ===== */
        #informasi { background: #f8fafc; padding: 5rem 0; scroll-margin-top: 70px; }

        .info-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 1.5rem;
            height: 100%;
            transition: all 0.25s;
        }

        .info-card:hover {
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
            transform: translateY(-3px);
        }

        .info-date {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: #f0fdf4;
            color: #16a34a;
            border-radius: 100px;
            padding: 0.2rem 0.65rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        /* ===== Empty State ===== */
        .empty-state {
            text-align: center;
            padding: 3rem 0;
            color: #94a3b8;
        }

        .empty-state i { font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 0.75rem; }

        /* ===== CTA Section ===== */
        .cta-section {
            background: linear-gradient(135deg, #0f172a, #1e40af);
            color: #fff;
            padding: 4rem 0;
        }

        /* ===== Footer ===== */
        footer {
            background: #0f172a;
            color: rgba(255,255,255,0.5);
            padding: 1.5rem 0;
        }

        /* Mobile toggle */
        .navbar-toggler-custom {
            background: none;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            padding: 0.4rem 0.6rem;
            color: #fff;
            cursor: pointer;
        }

        @media (max-width: 991.98px) {
            .nav-collapse {
                background: rgba(15,23,42,0.98);
                margin-top: 0.5rem;
                border-radius: 12px;
                padding: 0.5rem;
            }

            .nav-menu {
                flex-direction: column;
                align-items: stretch;
            }

            .hero-stats { gap: 1.25rem; }
        }
    </style>
</head>
<body>

    <!-- ===== Navbar ===== -->
    <nav class="main-navbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Brand -->
                <a href="#beranda" class="navbar-brand-text">
                    <div class="brand-icon">
                        <i class="bi bi-heart-pulse text-white" style="font-size:1rem;"></i>
                    </div>
                    SIBk
                </a>

                <!-- Toggle Mobile -->
                <button class="navbar-toggler-custom d-lg-none" onclick="toggleMobileNav()" id="navToggle">
                    <i class="bi bi-list" style="font-size:1.2rem;"></i>
                </button>

                <!-- Nav Links (desktop) -->
                <div class="d-none d-lg-flex align-items-center gap-3">
                    <ul class="nav-menu">
                        <li><a href="#beranda"><i class="bi bi-house"></i> Beranda</a></li>
                        <li><a href="#jadwal"><i class="bi bi-calendar3"></i> Jadwal Layanan BK</a></li>
                        <li><a href="#tata-tertib"><i class="bi bi-book"></i> Tata Tertib</a></li>
                        <li><a href="#informasi"><i class="bi bi-megaphone"></i> Informasi BK</a></li>
                    </ul>

                    <div class="nav-auth ms-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm px-3">
                                <i class="bi bi-grid me-1"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-3">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3">Daftar</a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Nav Mobile (collapsible) -->
            <div id="mobileNav" class="d-lg-none nav-collapse" style="display:none!important;">
                <ul class="nav-menu mt-1">
                    <li><a href="#beranda" onclick="closeMobileNav()"><i class="bi bi-house"></i> Beranda</a></li>
                    <li><a href="#jadwal" onclick="closeMobileNav()"><i class="bi bi-calendar3"></i> Jadwal Layanan BK</a></li>
                    <li><a href="#tata-tertib" onclick="closeMobileNav()"><i class="bi bi-book"></i> Tata Tertib</a></li>
                    <li><a href="#informasi" onclick="closeMobileNav()"><i class="bi bi-megaphone"></i> Informasi BK</a></li>
                </ul>
                <div class="d-flex gap-2 p-2 mt-1">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-grid me-1"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm flex-fill">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm flex-fill">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ===== Hero / Beranda ===== -->
    <section id="beranda">
        <div class="container position-relative">
            <div class="row align-items-center g-5 py-5">
                <div class="col-lg-6">
                    <div class="hero-badge">
                        <i class="bi bi-patch-check-fill text-primary"></i>
                        SMKN 3 Padang — Layanan BK Digital
                    </div>
                    <h1 class="hero-title mb-3">Sistem Informasi<br>Bimbingan Konseling</h1>
                    <p class="hero-sub mb-4">
                        Platform digital untuk manajemen layanan bimbingan konseling siswa SMKN 3 Padang.
                        Monitoring perkembangan, pencatatan konseling, dan pengelolaan data siswa dalam satu sistem terintegrasi.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sistem
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                                <i class="bi bi-person-plus me-2"></i>Daftar Akun
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-4 fw-semibold">
                                <i class="bi bi-grid me-2"></i>Buka Dashboard
                            </a>
                        @endguest
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat-item">
                            <div class="hero-stat-num">{{ $jadwal->count() }}</div>
                            <div class="hero-stat-label">Jadwal BK</div>
                        </div>
                        <div class="hero-stat-item">
                            <div class="hero-stat-num">{{ $tataTertib->count() }}</div>
                            <div class="hero-stat-label">Tata Tertib</div>
                        </div>
                        <div class="hero-stat-item">
                            <div class="hero-stat-num">{{ $informasi->count() }}</div>
                            <div class="hero-stat-label">Informasi BK</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-flex justify-content-center">
                    <div style="position:relative;">
                        <div style="width:320px;height:320px;background:rgba(255,255,255,0.06);border-radius:50%;border:2px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;">
                            <div style="width:220px;height:220px;background:rgba(255,255,255,0.07);border-radius:50%;border:2px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-heart-pulse" style="font-size:5.5rem;opacity:0.6;color:#60a5fa;"></i>
                            </div>
                        </div>
                        <!-- Floating cards -->
                        <div style="position:absolute;top:20px;right:-20px;background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);border-radius:12px;padding:0.75rem 1rem;border:1px solid rgba(255,255,255,0.15);">
                            <div style="font-size:0.75rem;color:rgba(255,255,255,0.7);">Pengajuan Konseling</div>
                            <div style="font-weight:700;color:#fff;font-size:1rem;">Real-time</div>
                        </div>
                        <div style="position:absolute;bottom:30px;left:-30px;background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);border-radius:12px;padding:0.75rem 1rem;border:1px solid rgba(255,255,255,0.15);">
                            <div style="font-size:0.75rem;color:rgba(255,255,255,0.7);">Monitoring Siswa</div>
                            <div style="font-weight:700;color:#60a5fa;font-size:1rem;"><i class="bi bi-graph-up"></i> Terintegrasi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Jadwal Layanan BK ===== -->
    <section id="jadwal">
        <div class="container">
            <div class="row align-items-end justify-content-between mb-4">
                <div class="col-auto">
                    <div class="section-label bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-calendar3"></i> Jadwal Layanan
                    </div>
                    <h2 class="section-title">Jadwal Layanan BK</h2>
                    <p class="section-desc">Jadwal sesi konsultasi dengan Guru Bimbingan Konseling SMKN 3 Padang.</p>
                </div>
                @if($jadwal->count() > 6)
                    <div class="col-auto">
                        <span class="badge bg-primary rounded-pill">{{ $jadwal->count() }} jadwal tersedia</span>
                    </div>
                @endif
            </div>

            @if($jadwal->isNotEmpty())
            <div class="row g-3">
                @foreach($jadwal as $j)
                <div class="col-sm-6 col-lg-4">
                    <div class="jadwal-card">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="jadwal-day-icon">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div>
                                <div class="fw-bold" style="color:#0f172a;">{{ $j->hari }}</div>
                                <div class="text-muted" style="font-size:0.82rem;">{{ \Carbon\Carbon::parse($j->tanggal_layanan)->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="badge bg-primary px-3 py-2 rounded-pill">
                                <i class="bi bi-clock me-1"></i>{{ $j->jam }}
                            </span>
                            <small class="text-muted fw-semibold">{{ $j->guru }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
                <div class="empty-state"><i class="bi bi-calendar-x"></i>Belum ada jadwal layanan BK.</div>
            @endif
        </div>
    </section>

    <!-- ===== Tata Tertib Sekolah ===== -->
    <section id="tata-tertib">
        <div class="container">
            <div class="mb-4">
                <div class="section-label bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-book"></i> Peraturan
                </div>
                <h2 class="section-title">Tata Tertib Sekolah</h2>
                <p class="section-desc">Peraturan yang wajib dipatuhi oleh seluruh siswa SMKN 3 Padang.</p>
            </div>

            @if($tataTertib->isNotEmpty())
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="d-flex flex-column gap-2">
                        @foreach($tataTertib as $i => $tt)
                        <div class="tatib-item">
                            <div class="tatib-num">{{ $i + 1 }}</div>
                            <p class="mb-0" style="color:#374151;font-size:0.9rem;line-height:1.65;">{{ $tt->tata_tertib }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
                <div class="empty-state"><i class="bi bi-book"></i>Belum ada tata tertib yang dipublikasikan.</div>
            @endif
        </div>
    </section>

    <!-- ===== Informasi BK ===== -->
    <section id="informasi">
        <div class="container">
            <div class="row align-items-end justify-content-between mb-4">
                <div class="col-auto">
                    <div class="section-label bg-success bg-opacity-10 text-success">
                        <i class="bi bi-megaphone"></i> Pengumuman
                    </div>
                    <h2 class="section-title">Informasi BK</h2>
                    <p class="section-desc">Update dan pengumuman terbaru dari Bimbingan Konseling SMKN 3 Padang.</p>
                </div>
            </div>

            @if($informasi->isNotEmpty())
            <div class="row g-3">
                @foreach($informasi as $info)
                <div class="col-sm-6 col-lg-4">
                    <div class="info-card">
                        <div class="info-date">
                            <i class="bi bi-calendar-check"></i>
                            {{ \Carbon\Carbon::parse($info->tanggal_informasi)->format('d M Y') }}
                        </div>
                        <p class="mb-0" style="color:#374151;font-size:0.9rem;line-height:1.7;">{{ Str::limit($info->informasi, 180) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
                <div class="empty-state"><i class="bi bi-megaphone"></i>Belum ada informasi BK yang dipublikasikan.</div>
            @endif
        </div>
    </section>

    <!-- ===== CTA ===== -->
    @guest
    <section class="cta-section">
        <div class="container text-center">
            <h2 class="fw-800 mb-2" style="font-weight:800;font-size:1.75rem;">Belum memiliki akun?</h2>
            <p class="mb-4" style="color:rgba(255,255,255,0.75);">Daftar sekarang sebagai Siswa atau Orang Tua untuk mengakses layanan BK secara digital.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 fw-semibold">
                    <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                    Sudah punya akun? Login
                </a>
            </div>
        </div>
    </section>
    @endguest

    <!-- ===== Footer ===== -->
    <footer>
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="brand-icon" style="width:26px;height:26px;border-radius:6px;">
                        <i class="bi bi-heart-pulse text-white" style="font-size:0.7rem;"></i>
                    </div>
                    <span style="color:rgba(255,255,255,0.7);font-size:0.875rem;font-weight:600;">SIBk — SMKN 3 Padang</span>
                </div>
                <p class="mb-0" style="font-size:0.8rem;">&copy; {{ date('Y') }} Sistem Informasi Bimbingan Konseling. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile nav toggle
        function toggleMobileNav() {
            var nav = document.getElementById('mobileNav');
            var isHidden = nav.style.display === 'none' || nav.style.display === '';
            nav.style.display = isHidden ? 'block' : 'none';
        }

        function closeMobileNav() {
            document.getElementById('mobileNav').style.display = 'none';
        }

        // Active nav link on scroll
        const sections = ['beranda','jadwal','tata-tertib','informasi'];
        const navLinks = document.querySelectorAll('.nav-menu a');

        window.addEventListener('scroll', function () {
            let current = 'beranda';
            sections.forEach(function (id) {
                var el = document.getElementById(id);
                if (el && window.scrollY >= el.offsetTop - 120) {
                    current = id;
                }
            });

            navLinks.forEach(function (a) {
                a.classList.remove('active');
                if (a.getAttribute('href') === '#' + current) {
                    a.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
