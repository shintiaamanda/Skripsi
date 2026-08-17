<?php

namespace App\Http\Controllers;

use App\Models\InformasiBk;
use App\Models\InputDataKonseling;
use App\Models\JadwalLayananBk;
use App\Models\TataTertibSekolah;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('welcome', [
            'jadwal' => $this->getAvailableJadwal(),
            'informasi' => InformasiBk::orderByDesc('tanggal_informasi')->get(),
            'tataTertib' => TataTertibSekolah::orderByDesc('tanggal_konseling')->get(),
        ]);
    }

    private function getAvailableJadwal()
    {
        // Jadwal disembunyikan dari homepage jika sudah diproses oleh Guru BK ke InputDataKonseling
        $takenKonselingSessions = InputDataKonseling::all()->map(function ($k) {
            $dateStr = $k->tanggal instanceof \DateTimeInterface
                ? $k->tanggal->format('Y-m-d')
                : substr((string) $k->tanggal, 0, 10);

            return $dateStr . '|' . trim(strtolower($k->guru_bk));
        })->toArray();

        return JadwalLayananBk::orderBy('tanggal_layanan', 'asc')
            ->get()
            ->reject(function ($j) use ($takenKonselingSessions) {
                $dateStr = $j->tanggal_layanan instanceof \DateTimeInterface
                    ? $j->tanggal_layanan->format('Y-m-d')
                    : substr((string) $j->tanggal_layanan, 0, 10);

                $key = $dateStr . '|' . trim(strtolower($j->guru));

                return in_array($key, $takenKonselingSessions);
            })->values();
    }
}
