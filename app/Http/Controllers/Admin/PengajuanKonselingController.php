<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AjukanKonseling;
use App\Models\InputDataKonseling;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PengajuanKonselingController extends Controller
{
    public function index(Request $request): View
    {
        $guruBkNama = $request->user()->nama;
        $query = AjukanKonseling::with(['siswa', 'jadwal'])
            ->forGuruBk($guruBkNama)
            ->latest();

        if ($search = $request->input('search')) {
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        $pengajuan = $query->paginate(10)->withQueryString();

        $pengajuan->getCollection()->transform(function ($item) use ($guruBkNama) {
            $item->guru_bk = $item->jadwal?->guru ?? $guruBkNama;

            return $item;
        });

        return view('admin.pengajuan.index', [
            'pengajuan' => $pengajuan,
            'filters' => $request->only('search'),
        ]);
    }

    public function show(Request $request, AjukanKonseling $pengajuan): View
    {
        $pengajuan->load(['siswa', 'jadwal']);
        $pengajuan->guru_bk = $pengajuan->jadwal?->guru ?? $request->user()->nama;

        return view('admin.pengajuan.proses', [
            'pengajuan' => $pengajuan,
        ]);
    }

    public function proses(Request $request, AjukanKonseling $pengajuan): RedirectResponse
    {
        $validated = $request->validate([
            'masalah' => 'required|string',
            'solusi' => 'required|string',
            'guru_bk' => 'required|string|max:255',
        ]);

        $jamStr = $pengajuan->jadwal?->jam ? ' (Jam ' . $pengajuan->jadwal->jam . ')' : '';

        InputDataKonseling::create([
            'id_siswa' => $pengajuan->id_siswa,
            'tanggal' => $pengajuan->tanggal_konseling,
            'masalah' => $validated['masalah'],
            'solusi' => $validated['solusi'] . $jamStr,
            'guru_bk' => $validated['guru_bk'],
        ]);

        $pengajuan->delete();

        return redirect()->route('admin.pengajuan.index')->with('toast', [
            'type' => 'success',
            'message' => 'Pengajuan konseling berhasil diproses dan disimpan ke data konseling.',
        ]);
    }

    public function destroy(AjukanKonseling $pengajuan): RedirectResponse
    {
        $pengajuan->delete();

        return redirect()->route('admin.pengajuan.index')->with('toast', [
            'type' => 'success',
            'message' => 'Pengajuan konseling berhasil dihapus.',
        ]);
    }

    public function tidakHadir(AjukanKonseling $pengajuan): RedirectResponse
    {
        $pengajuan->delete();

        return redirect()->route('admin.pengajuan.index')->with('toast', [
            'type' => 'success',
            'message' => 'Pengajuan konseling ditandai: Siswa tidak hadir.',
        ]);
    }
}
