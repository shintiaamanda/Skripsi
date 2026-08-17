<?php

namespace App\Http\Controllers;

use App\Models\AjukanKonseling;
use App\Models\InputDataKonseling;
use App\Models\JadwalLayananBk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = $request->user();
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

    public function ajukanKonseling(Request $request): RedirectResponse
    {
        $user = $request->user();
        $siswa = $user->siswa;

        if (! $siswa) {
            return back()->with('toast', [
                'type' => 'error',
                'message' => 'Data siswa tidak ditemukan.',
            ]);
        }

        $validated = $request->validate([
            'id_jadwal' => 'nullable|exists:jadwal_layanan_bk,id_jadwal',
            'tanggal_konseling' => 'required|date',
            'keluhan' => 'required|string',
        ]);

        AjukanKonseling::create([
            'id_siswa' => $siswa->id_siswa,
            'id_jadwal' => $validated['id_jadwal'] ?? null,
            'tanggal_konseling' => $validated['tanggal_konseling'],
            'keluhan' => $validated['keluhan'],
        ]);

        return back()->with('toast', [
            'type' => 'success',
            'message' => 'Pengajuan konseling berhasil dikirim.',
        ]);
    }
}
