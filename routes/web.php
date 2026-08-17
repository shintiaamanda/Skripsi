<?php

use App\Http\Controllers\Admin\InformasiBkController;
use App\Http\Controllers\Admin\InputDataKonselingController;
use App\Http\Controllers\Admin\InputDataSiswaController;
use App\Http\Controllers\Admin\JadwalLayananBkController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\PelanggaranController;
use App\Http\Controllers\Admin\PengajuanKonselingController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\TataTertibSekolahController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Admin routes (guru_bk)
    Route::middleware(['role:guru_bk'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('register', RegisterController::class);
        Route::resource('siswa', InputDataSiswaController::class);
        Route::resource('konseling', InputDataKonselingController::class);
        Route::post('konseling/{konseling}/tidak-hadir', [InputDataKonselingController::class, 'kirimPesanTidakHadir'])->name('konseling.tidak-hadir');
        Route::resource('monitoring', MonitoringController::class);
        Route::resource('pelanggaran', PelanggaranController::class);
        Route::resource('jadwal', JadwalLayananBkController::class);
        Route::resource('tata-tertib', TataTertibSekolahController::class);
        Route::resource('informasi', InformasiBkController::class);
        Route::get('pengajuan', [PengajuanKonselingController::class, 'index'])->name('pengajuan.index');
        Route::get('pengajuan/{pengajuan}', [PengajuanKonselingController::class, 'show'])->name('pengajuan.show');
        Route::post('pengajuan/{pengajuan}/proses', [PengajuanKonselingController::class, 'proses'])->name('pengajuan.proses');
        Route::post('pengajuan/{pengajuan}/tidak-hadir', [PengajuanKonselingController::class, 'tidakHadir'])->name('pengajuan.tidak-hadir');
        Route::delete('pengajuan/{pengajuan}', [PengajuanKonselingController::class, 'destroy'])->name('pengajuan.destroy');
        // Laporan routes
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
        Route::get('laporan/siswa', [LaporanController::class, 'index'])->defaults('jenis', 'siswa')->name('laporan.siswa');
        Route::get('laporan/ajukan-konseling', [LaporanController::class, 'index'])->defaults('jenis', 'ajukan-konseling')->name('laporan.ajukan-konseling');
        Route::get('laporan/konseling', [LaporanController::class, 'index'])->defaults('jenis', 'konseling')->name('laporan.konseling');
        Route::get('laporan/monitoring', [LaporanController::class, 'index'])->defaults('jenis', 'monitoring')->name('laporan.monitoring');
        Route::get('laporan/pelanggaran', [LaporanController::class, 'index'])->defaults('jenis', 'pelanggaran')->name('laporan.pelanggaran');
    });

    // Siswa routes
    Route::middleware(['role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::post('ajukan-konseling', [SiswaController::class, 'ajukanKonseling'])->name('ajukan-konseling');
    });

    // Kepala Sekolah routes
    Route::middleware(['role:kepala_sekolah'])->prefix('kepala-sekolah')->name('kepala-sekolah.')->group(function () {
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/siswa', [LaporanController::class, 'index'])->defaults('jenis', 'siswa')->name('laporan.siswa');
        Route::get('laporan/ajukan-konseling', [LaporanController::class, 'index'])->defaults('jenis', 'ajukan-konseling')->name('laporan.ajukan-konseling');
        Route::get('laporan/konseling', [LaporanController::class, 'index'])->defaults('jenis', 'konseling')->name('laporan.konseling');
        Route::get('laporan/monitoring', [LaporanController::class, 'index'])->defaults('jenis', 'monitoring')->name('laporan.monitoring');
        Route::get('laporan/pelanggaran', [LaporanController::class, 'index'])->defaults('jenis', 'pelanggaran')->name('laporan.pelanggaran');
    });
});

require __DIR__.'/settings.php';
