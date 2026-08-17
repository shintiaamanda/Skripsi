# SIBk - Sistem Informasi Bimbingan Konseling

**SMKN 3 Padang** — Aplikasi web berbasis **Laravel 13 + Blade + Bootstrap 5** (bukan React/Inertia).
Stack ini sudah berubah dari React/Inertia ke full-stack Blade PHP murni.

---

## Tech Stack (Aktual)

| Layer | Teknologi |
|-------|-----------|
| Backend | PHP 8.4 + Laravel 13 |
| Auth | Laravel Fortify v1 (username-based) |
| Frontend | Blade + Bootstrap 5.3 + Bootstrap Icons |
| Database | MySQL (via Laragon) |
| Font | Google Fonts — Inter |
| Dev Server | `php artisan serve` |

> **PENTING**: Proyek ini TIDAK menggunakan React, Inertia, Vite, Tailwind, atau TypeScript.
> Semua halaman adalah file `.blade.php`. Jangan buat atau edit file `.tsx`, `.ts`, `.jsx`.

---

## Project Structure

```
app/
├── Actions/Fortify/
│   ├── CreateNewUser.php          # Registrasi Siswa & Orang Tua + auto-buat InputDataSiswa
│   ├── PasswordValidationRules.php # Trait validasi password
│   └── ResetUserPassword.php
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── InputDataKonselingController.php   # CRUD konseling + modal jadwal
│   │   │   ├── InputDataSiswaController.php        # CRUD data siswa
│   │   │   ├── JadwalLayananBkController.php       # CRUD jadwal layanan BK
│   │   │   ├── MonitoringController.php            # CRUD monitoring siswa
│   │   │   ├── PelanggaranController.php           # CRUD pelanggaran siswa
│   │   │   ├── PengajuanKonselingController.php    # Lihat & kelola pengajuan dari siswa
│   │   │   ├── RegisterController.php              # Manajemen akun (CRUD)
│   │   │   ├── InformasiBkController.php           # CRUD informasi BK
│   │   │   ├── TataTertibSekolahController.php     # CRUD tata tertib
│   │   │   └── LaporanController.php               # Cetak laporan PDF/print
│   │   ├── DashboardController.php    # Role-based dashboard redirect (invoke)
│   │   ├── SiswaController.php        # Dashboard siswa + ajukan konseling
│   │   ├── OrangTuaController.php     # Dashboard orang tua + cari anak
│   │   ├── KepalaSekolahController.php # Dashboard kepala sekolah (statistik)
│   │   ├── HomeController.php
│   │   └── Settings/                  # Profil & password settings
│   └── Middleware/RoleMiddleware.php
├── Models/
│   ├── Register.php             # Model auth utama (bukan User)
│   ├── InputDataSiswa.php       # Data siswa (NISN, kelas, alamat, dll)
│   ├── InputDataKonseling.php   # Data konseling yang sudah diproses Guru BK
│   ├── InputDataMonitoring.php  # Data monitoring siswa
│   ├── InputDataPelanggaran.php # Data pelanggaran siswa
│   ├── AjukanKonseling.php      # Pengajuan konseling dari siswa (pending)
│   ├── JadwalLayananBk.php      # Jadwal layanan BK
│   ├── InformasiBk.php          # Informasi BK
│   ├── TataTertibSekolah.php    # Tata tertib sekolah
│   └── Login.php                # (legacy, tidak dipakai aktif)

resources/views/
├── layouts/
│   ├── app.blade.php            # Layout utama (sidebar + topbar + toast)
│   └── auth.blade.php           # Layout halaman login/register
├── auth/
│   ├── login.blade.php          # Halaman login (username + password)
│   └── register.blade.php       # Halaman daftar (Siswa / Orang Tua)
├── dashboard.blade.php          # Dashboard Guru BK (statistik + tabel terbaru)
├── siswa/
│   └── dashboard.blade.php      # Dashboard Siswa (form ajukan konseling + riwayat)
├── orang-tua/
│   └── dashboard.blade.php      # Dashboard Orang Tua (cari anak by NISN/nama/kelas)
├── kepala-sekolah/
│   └── dashboard.blade.php      # Dashboard Kepala Sekolah (statistik laporan)
├── admin/
│   ├── siswa/                   # index, create, edit
│   ├── konseling/               # index, create (+ modal jadwal), edit (+ modal jadwal)
│   ├── monitoring/              # index, create, edit
│   ├── pelanggaran/             # index, create, edit
│   ├── pengajuan/               # index (lihat pengajuan siswa)
│   ├── jadwal/                  # index, create, edit
│   ├── informasi/               # index, create, edit
│   ├── tata-tertib/             # index, create, edit
│   ├── register/                # index, create, edit (manajemen akun)
│   └── laporan/                 # index (cetak laporan)
└── settings/                    # Profil, password

routes/web.php                   # Semua route definitions
database/seeders/DatabaseSeeder.php
```

---

## Roles & Access

| Role | Deskripsi | Route Prefix |
|------|-----------|--------------|
| `guru_bk` | Kelola seluruh data: siswa, konseling, monitoring, pelanggaran, jadwal, laporan | `/admin/*` |
| `siswa` | Dashboard siswa: ajukan konseling + riwayat konseling | `/dashboard` |
| `orang_tua` | Cari data perkembangan anak (cari by NISN / nama / kelas) | `/dashboard` |
| `kepala_sekolah` | Lihat statistik & laporan saja (read-only) | `/dashboard` |

Middleware: `role:guru_bk`, `role:siswa`, dll. (aliased di `bootstrap/app.php`).

---

## Default Accounts (Seeder)

| Role | Username | Password |
|------|----------|----------|
| Guru BK | `gurubk` | `password` |
| Kepala Sekolah | `kepalasekolah` | `password` |
| Siswa | `siswa` | `password` |
| Orang Tua | `orangtua` | `password` |

Siswa & Orang Tua **bisa mendaftar sendiri** via `/register`.

---

## Database Tables

| Tabel | Keterangan |
|-------|-----------|
| `register` | Tabel auth utama (model `Register`, bukan `User`) |
| `input_data_siswa` | Data lengkap siswa (NISN, kelas, alamat, dll) |
| `input_data_konseling` | Data konseling yang sudah diproses Guru BK |
| `input_data_monitoring` | Data monitoring perkembangan siswa |
| `input_data_pelanggaran` | Data pelanggaran siswa |
| `ajukan_konseling` | Pengajuan konseling dari siswa (status pending) |
| `jadwal_layanan_bk` | Jadwal sesi layanan BK (hari, tanggal, jam, guru) |
| `tata_tertib_sekolah` | Tata tertib sekolah |
| `informasi_bk` | Informasi BK untuk siswa |

---

## Key Patterns & Aturan Penting

### Auth
- Auth menggunakan **Fortify dengan login berbasis `username`** (`config/fortify.php` → `username`).
- Model auth adalah `Register` (bukan `User`). Selalu gunakan `Register` untuk query user.
- Registrasi hanya untuk role `siswa` dan `orang_tua`. Role `guru_bk` dan `kepala_sekolah` hanya via seeder.
- Saat mendaftar sebagai `siswa`, data siswa otomatis dibuat di tabel `input_data_siswa` (lihat `CreateNewUser.php`).

### Dashboard
- `DashboardController` menggunakan `__invoke()` dengan `match($role)` untuk redirect ke view yang benar.
- Jangan pisahkan dashboard per role ke controller berbeda — semuanya ada di `DashboardController`.

### Notifikasi Guru BK
- Badge notifikasi 🔔 ditampilkan di topbar dan sidebar Guru BK berdasarkan jumlah total `AjukanKonseling`.
- Tidak menggunakan tabel notifikasi terpisah — live dari query `AjukanKonseling::count()`.

### Logika Ketersediaan Jadwal Layanan BK
- Jadwal layanan BK dianggap **TERPAKAI** hanya setelah Guru BK memprosesnya ke `InputDataKonseling`.
- Selama masih di tahap pengajuan (`AjukanKonseling`), jadwal **TETAP TERSEDIA** untuk siswa lain.
- Filter ketersediaan jadwal: reject jadwal yang kombinasi `(tanggal + guru_bk)` sudah ada di `InputDataKonseling`.
- Fungsi `getAvailableJadwal()` dipakai di: `InputDataKonselingController`, `SiswaController`, `DashboardController`.

### Form Konseling Guru BK (create/edit)
- Tombol **"Pilih dari Jadwal Layanan BK"** ada **tepat di bawah** dropdown pemilihan siswa.
- Modal menampilkan jadwal yang tersedia (belum diproses ke `InputDataKonseling`).
- Saat jadwal dipilih di modal → field `tanggal` dan `guru_bk` terisi otomatis.

### Form Konseling Siswa (dashboard)
- Tombol **"Pilih dari Jadwal Layanan BK yang Tersedia"** membuka Modal (bukan dropdown).
- Setelah pilih jadwal dari modal: field `tanggal_konseling` terisi otomatis + info jadwal ditampilkan.
- Ada tombol ✕ untuk batalkan pilihan jadwal (kembali input manual).
- Field tersembunyi `id_jadwal` dikirim bersama form.

### Orang Tua
- Dashboard orang tua hanya menampilkan data setelah **mencari** anak (by NISN, nama, atau kelas).
- Jika belum mencari, halaman kosong/menampilkan form pencarian saja.

---

## Commands

```bash
php artisan migrate:fresh --seed   # Reset DB + isi data awal
php artisan serve                   # Dev server (http://127.0.0.1:8000)
vendor/bin/pint --dirty --format agent  # Format PHP setelah perubahan
```

> Tidak ada `npm run build` atau `npm run dev` — proyek ini full Blade, tidak ada asset bundler aktif.

---

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4
- laravel/fortify (FORTIFY) - v1
- laravel/framework (LARAVEL) - v13
- laravel/pint (PINT) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.
- **JANGAN** buat file `.tsx`, `.ts`, `.jsx`, atau file React/Inertia apapun — proyek ini full Blade.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.
- **Jangan tambahkan tabel baru** ke database tanpa persetujuan user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`).
- Inspect routes with `php artisan route:list`.

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

</laravel-boost-guidelines>
