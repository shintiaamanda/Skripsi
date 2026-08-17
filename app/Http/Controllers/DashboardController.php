<?php

namespace App\Http\Controllers;

use App\Models\AjukanKonseling;
use App\Models\InputDataKonseling;
use App\Models\InputDataMonitoring;
use App\Models\InputDataPelanggaran;
use App\Models\InputDataSiswa;
use App\Models\JadwalLayananBk;
use App\Models\Register;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        $user = $request->user();

        return match ($user->role) {
            'guru_bk' => $this->guruBkDashboard($user),
            'siswa' => $this->siswaDashboard($user),
            'orang_tua' => $this->orangTuaDashboard($request),
            'kepala_sekolah' => $this->kepalaSekolahDashboard(),
            default => view('dashboard'),
        };
    }

    private function guruBkDashboard(Register $user): View
    {
        $guruBkNama = $user->nama;

        return view('dashboard', [
            'stats' => [
                'totalSiswa' => InputDataSiswa::count(),
                'totalKonseling' => InputDataKonseling::count(),
                'totalMonitoring' => InputDataMonitoring::count(),
                'totalPelanggaran' => InputDataPelanggaran::count(),
                'totalPengajuan' => AjukanKonseling::forGuruBk($guruBkNama)->count(),
                'totalAkun' => Register::count(),
            ],
            'konselingTerbaru' => InputDataKonseling::with('siswa')->latest()->take(5)->get(),
            'pelanggaranTerbaru' => InputDataPelanggaran::with('siswa')->latest()->take(5)->get(),
            'pengajuanTerbaru' => AjukanKonseling::with(['siswa', 'jadwal'])->forGuruBk($guruBkNama)->latest()->take(5)->get(),
        ]);
    }

    private function siswaDashboard(Register $user): View
    {
        $siswa = $user->siswa;

        return view('siswa.dashboard', [
            'pengajuan' => $siswa ? AjukanKonseling::where('id_siswa', $siswa->id_siswa)->latest()->get() : collect(),
            'riwayat' => $siswa ? InputDataKonseling::where('id_siswa', $siswa->id_siswa)->latest()->get() : collect(),
            'jadwal' => $this->getAvailableJadwal(),
        ]);
    }

    private function getAvailableJadwal()
    {
        $nowWib = now('Asia/Jakarta');
        $todayStr = $nowWib->toDateString();

        $takenKonselingSessions = InputDataKonseling::all()->map(function ($k) {
            $dateStr = $k->tanggal instanceof \DateTimeInterface
                ? $k->tanggal->format('Y-m-d')
                : substr((string) $k->tanggal, 0, 10);

            return [
                'date' => $dateStr,
                'guru' => trim(strtolower($k->guru_bk ?? '')),
                'solusi' => strtolower($k->solusi ?? ''),
            ];
        });

        return JadwalLayananBk::where('tanggal_layanan', '>=', $todayStr)
            ->orderBy('tanggal_layanan', 'asc')
            ->get()
            ->reject(function ($j) use ($takenKonselingSessions, $nowWib, $todayStr) {
                $jDate = $j->tanggal_layanan instanceof \DateTimeInterface
                    ? $j->tanggal_layanan->format('Y-m-d')
                    : substr((string) $j->tanggal_layanan, 0, 10);

                // 1. Filter jika tanggal sudah lewat
                if ($jDate < $todayStr) {
                    return true;
                }

                // 2. Filter jika hari ini tapi jam sudah lewat di WIB
                if ($jDate === $todayStr && ! empty($j->jam)) {
                    if (preg_match_all('/(\d{1,2})[\:\.](\d{2})/', $j->jam, $matches, PREG_SET_ORDER)) {
                        $lastMatch = end($matches);
                        $endHour = (int) $lastMatch[1];
                        $endMin = (int) $lastMatch[2];

                        try {
                            $endDateTime = \Carbon\Carbon::createFromFormat(
                                'Y-m-d H:i:s',
                                sprintf('%s %02d:%02d:00', $jDate, $endHour, $endMin),
                                'Asia/Jakarta'
                            );

                            if ($endDateTime->lessThanOrEqualTo($nowWib)) {
                                return true; // Jam selesai sudah lewat -> HILANG
                            }
                        } catch (\Throwable $e) {
                        }
                    }
                }

                // 3. Filter jika spesifik jam tersebut telah diproses ke InputDataKonseling
                $jGuru = trim(strtolower($j->guru ?? ''));
                $jJam = strtolower(trim($j->jam ?? ''));

                return $takenKonselingSessions->contains(function ($session) use ($jDate, $jGuru, $jJam) {
                    if ($session['date'] !== $jDate) {
                        return false;
                    }

                    if ($session['guru'] !== '' && $jGuru !== '' && $session['guru'] !== $jGuru) {
                        return false;
                    }

                    if ($jJam !== '' && str_contains($session['solusi'], $jJam)) {
                        return true;
                    }

                    return false;
                });
            })->values();
    }

    private function orangTuaDashboard(Request $request): View
    {
        $search = trim($request->input('search', ''));

        if ($search !== '') {
            $siswaList = InputDataSiswa::with(['monitoring', 'pelanggaran', 'konseling'])
                ->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%")
                        ->orWhere('kelas', 'like', "%{$search}%");
                })->get();
        } else {
            $siswaList = collect();
        }

        return view('orang-tua.dashboard', [
            'siswa' => $siswaList,
            'search' => $search,
        ]);
    }

    private function kepalaSekolahDashboard(): View
    {
        return view('kepala-sekolah.dashboard', [
            'stats' => [
                'totalSiswa' => InputDataSiswa::count(),
                'totalKonseling' => InputDataKonseling::count(),
                'totalMonitoring' => InputDataMonitoring::count(),
                'totalPelanggaran' => InputDataPelanggaran::count(),
            ],
        ]);
    }
}
