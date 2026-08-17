<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AjukanKonseling;
use App\Models\InputDataKonseling;
use App\Models\InputDataMonitoring;
use App\Models\InputDataPelanggaran;
use App\Models\InputDataSiswa;
use App\Models\Register;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request, ?string $jenis = null): View|RedirectResponse
    {
        $isKepalaSekolah = auth()->user()?->role === 'kepala_sekolah';
        $routePrefix = $isKepalaSekolah ? 'kepala-sekolah' : 'admin';

        if (empty($jenis)) {
            return redirect()->route("{$routePrefix}.laporan.siswa");
        }

        $jenisKey = str_replace('-', '_', $jenis);
        $periode  = $request->input('periode', 'semua');

        $query = match ($jenisKey) {
            'siswa'            => InputDataSiswa::query(),
            'ajukan_konseling' => AjukanKonseling::with('siswa'),
            'konseling'        => InputDataKonseling::with('siswa'),
            'monitoring'       => InputDataMonitoring::with('siswa'),
            'pelanggaran'      => InputDataPelanggaran::with('siswa'),
            default            => InputDataSiswa::query(),
        };

        $dateField = match ($jenisKey) {
            'siswa'            => 'created_at',
            'ajukan_konseling' => 'tanggal_konseling',
            'konseling'        => 'tanggal',
            'monitoring'       => 'tanggal_monitoring',
            'pelanggaran'      => 'tanggal_pelanggaran',
            default            => 'created_at',
        };

        if ($periode === 'bulanan') {
            $query->whereMonth($dateField, now()->month)
                ->whereYear($dateField, now()->year);
        } elseif ($periode === 'tahunan') {
            $query->whereYear($dateField, now()->year);
        }

        $titleText = match ($jenisKey) {
            'siswa'            => 'Laporan Data Siswa',
            'ajukan_konseling' => 'Laporan Pengajuan Konseling',
            'konseling'        => 'Laporan Data Konseling',
            'monitoring'       => 'Laporan Data Monitoring',
            'pelanggaran'      => 'Laporan Data Pelanggaran',
            default            => 'Laporan',
        };

        $preview = $query->latest()->get();
        $kepalaSekolah = Register::where('role', 'kepala_sekolah')->first();

        return view('admin.laporan.index', [
            'stats' => [
                'totalSiswa'       => InputDataSiswa::count(),
                'totalKonseling'   => InputDataKonseling::count(),
                'totalMonitoring'  => InputDataMonitoring::count(),
                'totalPelanggaran' => InputDataPelanggaran::count(),
                'totalPengajuan'   => AjukanKonseling::count(),
            ],
            'preview'         => $preview,
            'selectedJenis'   => $jenisKey,
            'jenisSlug'       => $jenis,
            'selectedPeriode' => $periode,
            'kepalaSekolah'   => $kepalaSekolah,
            'isKepalaSekolah' => $isKepalaSekolah,
            'routePrefix'     => $routePrefix,
            'titleText'       => $titleText,
        ]);
    }

    public function cetak(Request $request): View
    {
        if (auth()->user()?->role === 'kepala_sekolah') {
            abort(403, 'Kepala Sekolah hanya memiliki akses melihat laporan dan tidak diizinkan mencetak laporan.');
        }

        $rawJenis = $request->input('jenis', 'siswa');
        $jenisKey = str_replace('-', '_', $rawJenis);
        $periode  = $request->input('periode', 'semua');

        $query = match ($jenisKey) {
            'siswa'            => InputDataSiswa::query(),
            'ajukan_konseling' => AjukanKonseling::with('siswa'),
            'konseling'        => InputDataKonseling::with('siswa'),
            'monitoring'       => InputDataMonitoring::with('siswa'),
            'pelanggaran'      => InputDataPelanggaran::with('siswa'),
            default            => InputDataSiswa::query(),
        };

        $dateField = match ($jenisKey) {
            'siswa'            => 'created_at',
            'ajukan_konseling' => 'tanggal_konseling',
            'konseling'        => 'tanggal',
            'monitoring'       => 'tanggal_monitoring',
            'pelanggaran'      => 'tanggal_pelanggaran',
            default            => 'created_at',
        };

        if ($periode === 'bulanan') {
            $query->whereMonth($dateField, now()->month)->whereYear($dateField, now()->year);
        } elseif ($periode === 'tahunan') {
            $query->whereYear($dateField, now()->year);
        }

        $kepalaSekolah = Register::where('role', 'kepala_sekolah')->first();

        return view('admin.laporan.cetak', [
            'data'            => $query->latest()->get(),
            'jenis'           => $jenisKey,
            'periode'         => $periode,
            'kepalaSekolah'   => $kepalaSekolah,
        ]);
    }
}
