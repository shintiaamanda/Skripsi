<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AjukanKonseling;
use App\Models\InputDataKonseling;
use App\Models\InputDataMonitoring;
use App\Models\InputDataSiswa;
use App\Models\JadwalLayananBk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InputDataKonselingController extends Controller
{
    public function index(Request $request): View
    {
        $guruBkNama = $request->user()->nama;
        $query = InputDataKonseling::with('siswa')->forGuruBk($guruBkNama);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa', function ($sq) use ($search) {
                    $sq->where('nama', 'like', "%{$search}%");
                })->orWhere('masalah', 'like', "%{$search}%");
            });
        }

        $pengajuanTerlewat = AjukanKonseling::with(['siswa', 'jadwal'])
            ->forGuruBk($guruBkNama)
            ->get()
            ->filter(fn ($p) => $p->isExpired());

        return view('admin.konseling.index', [
            'konseling' => $query->latest()->paginate(10)->withQueryString(),
            'pengajuanTerlewat' => $pengajuanTerlewat,
            'filters' => $request->only('search'),
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.konseling.create', [
            'siswa' => InputDataSiswa::all(),
            'jadwal' => $this->getAvailableJadwal(),
            'guruBkNama' => $request->user()->nama,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_siswa' => 'required|exists:input_data_siswa,id_siswa',
            'tanggal' => 'required|date',
            'masalah' => 'required|string',
            'solusi' => 'required|string',
            'guru_bk' => 'nullable|string|max:255',
        ]);

        $validated['guru_bk'] = $request->input('guru_bk') ?: $request->user()->nama;

        InputDataKonseling::create($validated);

        return redirect()->route('admin.konseling.index')->with('toast', [
            'type' => 'success',
            'message' => 'Data konseling berhasil ditambahkan.',
        ]);
    }

    public function edit(Request $request, InputDataKonseling $konseling): View
    {
        return view('admin.konseling.edit', [
            'konseling' => $konseling,
            'siswa' => InputDataSiswa::all(),
            'jadwal' => $this->getAvailableJadwal(),
            'guruBkNama' => $request->user()->nama,
        ]);
    }

    public function update(Request $request, InputDataKonseling $konseling): RedirectResponse
    {
        $validated = $request->validate([
            'id_siswa' => 'required|exists:input_data_siswa,id_siswa',
            'tanggal' => 'required|date',
            'masalah' => 'required|string',
            'solusi' => 'required|string',
            'guru_bk' => 'nullable|string|max:255',
        ]);

        $validated['guru_bk'] = $request->input('guru_bk') ?: $konseling->guru_bk;

        $konseling->update($validated);

        return redirect()->route('admin.konseling.index')->with('toast', [
            'type' => 'success',
            'message' => 'Data konseling berhasil diperbarui.',
        ]);
    }

    public function destroy(InputDataKonseling $konseling): RedirectResponse
    {
        $konseling->delete();

        return redirect()->route('admin.konseling.index')->with('toast', [
            'type' => 'success',
            'message' => 'Data konseling berhasil dihapus.',
        ]);
    }

    public function kirimPesanTidakHadir(InputDataKonseling $konseling): RedirectResponse
    {
        $konseling->update([
            'solusi' => 'Siswa tidak hadir sesuai jadwal konseling.',
        ]);

        InputDataMonitoring::create([
            'id_siswa' => $konseling->id_siswa,
            'tanggal_monitoring' => now()->toDateString(),
            'perkembangan' => 'Tidak hadir konseling (-10 Poin)',
        ]);

        return redirect()->route('admin.konseling.index')->with('toast', [
            'type' => 'success',
            'message' => 'Pesan tidak hadir dikirim & otomatis dicatat di Data Monitoring (-10 Poin).',
        ]);
    }

    private function getAvailableJadwal()
    {
        // Jadwal hanya disembunyikan JIKA SUDAH DIPROSES oleh Guru BK ke InputDataKonseling
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
