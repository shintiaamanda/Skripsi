# Panduan & Konteks Agent

Panduan dan konteks konfigurasi untuk AI coding agent yang bekerja pada proyek **Sistem Informasi Bimbingan Konseling (SIBk) SMKN 3 Padang** (Skripsi Shintia).

## Konteks Proyek

- **Nama**: Sistem Informasi Bimbingan Konseling (SIBk) SMKN 3 Padang
- **Framework**: Laravel 13
- **Teknologi Frontend**: Blade + Bootstrap 5.3 + Bootstrap Icons (**bukan** React/Inertia/TypeScript)
- **Autentikasi**: Laravel Fortify v1 (login berbasis `username`)
- **Database**: MySQL (via Laragon)
- **Font**: Google Fonts — Inter
- **Dev Server**: `php artisan serve`
- **Timezone**: `Asia/Jakarta`

> **PENTING**: Proyek ini TIDAK menggunakan React, Inertia, Vite, Tailwind, atau TypeScript.
> Semua halaman adalah file `.blade.php`. Jangan buat atau edit file `.tsx`, `.ts`, `.jsx`.

## Perintah Pengembangan

```bash
php artisan serve                        # Dev server (http://127.0.0.1:8000)
php artisan migrate:fresh --seed         # Reset DB + isi data awal
vendor/bin/pint --dirty --format agent   # Format PHP setelah perubahan
php artisan test --compact               # Jalankan semua tests
```

> Tidak ada `npm run build` atau `npm run dev` — proyek ini full Blade, tidak ada asset bundler aktif.

## Autentikasi & Model Utama

- **Model Auth**: `App\Models\Register` (bukan `User`) — dikonfigurasi di `config/auth.php`
- **Model `User`**: Scaffolding default Laravel, **tidak digunakan** untuk autentikasi
- **Login**: Menggunakan `username` (bukan email), dikonfigurasi di `config/fortify.php`
- **Password**: Dihash otomatis via cast `hashed` pada model `Register`

### Model `Register`
- Table: `register`, PK: `id_register`
- Fillable: `nama`, `email`, `username`, `password`, `role`, `nip`
- Field `nip` nullable — hanya diisi untuk role `kepala_sekolah`
- Relationships:
  - `login()` → HasOne(`Login`) via `username`
  - `siswa()` → HasOne(`InputDataSiswa`) via `nama` (fragil — nama bisa duplikat)
- Custom auth: `getAuthIdentifierName()` → `id_register`, `getAuthPassword()` → `password`

## Kontrol Akses berbasis Peran (RBAC)

Dikelola oleh `App\Http\Middleware\RoleMiddleware` (alias: `role`).

| Role | Route Prefix | Keterangan |
|------|--------------|------------|
| `guru_bk` | `/admin` | Akses penuh CRUD semua data |
| `siswa` | `/siswa` | Ajukan konseling, lihat riwayat |
| `orang_tua` | `/dashboard` | Lihat monitoring & pelanggaran anak |
| `kepala_sekolah` | `/kepala-sekolah` | Laporan agregat/cetak (read-only) |

## Struktur Proyek

```
app/
├── Actions/Fortify/
│   ├── CreateNewUser.php          # Registrasi Siswa & Orang Tua + auto-buat InputDataSiswa
│   ├── PasswordValidationRules.php
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
│   │   ├── KepalaSekolahController.php
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

## Skema Database

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

## Default Accounts (Seeder)

| Role | Username | Password |
|------|----------|----------|
| Guru BK (Adittya) | `A001` | `password` |
| Guru BK (Dino) | `A002` | `password` |
| Kepala Sekolah | `kepalasekolah` | `password` |
| Siswa | `siswa` | `password` |
| Orang Tua | `orangtua` | `password` |

Siswa & Orang Tua **bisa mendaftar sendiri** via `/register`.

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
- Badge notifikasi 🔔 ditampilkan di topbar dan sidebar Guru BK berdasarkan jumlah `AjukanKonseling`.
- Tidak menggunakan tabel notifikasi terpisah — live dari query `AjukanKonseling::forGuruBk()`.

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

## Catatan Arsitektur

1. **Dual User Model**: `User` dan `Register` keduanya extends `Authenticatable`. Hanya `Register` yang digunakan untuk auth.
2. **Relasi Fragil**: `Register::siswa()` terhubung via field `nama` ke `InputDataSiswa.nama` — nama bisa duplikat.
3. **Scope `forGuruBk()`**: Di model `AjukanKonseling` — filter pengajuan berdasarkan nama guru BK yang login.

## Context7 MCP (Dokumentasi Library)
- Cari ID library: `GET https://context7.com/api/v2/libs/search?query=<query>`
- Ambil dokumentasi: `GET https://context7.com/api/v2/context?libraryId=<libId>&query=<query>`
