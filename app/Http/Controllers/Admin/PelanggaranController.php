<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InputDataPelanggaran;
use App\Models\InputDataSiswa;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function index(Request $request): View
    {
        $query = InputDataPelanggaran::with('siswa');

        if ($search = $request->input('search')) {
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        return view('admin.pelanggaran.index', [
            'pelanggaran' => $query->latest()->paginate(10)->withQueryString(),
            'filters' => $request->only('search'),
        ]);
    }

    public function create(): View
    {
        return view('admin.pelanggaran.create', [
            'siswa' => InputDataSiswa::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_siswa' => 'required|exists:input_data_siswa,id_siswa',
            'tanggal_pelanggaran' => 'required|date',
            'poin' => 'required|integer|min:0',
            'tindakan' => 'required|string',
        ]);

        InputDataPelanggaran::create($validated);

        return redirect()->route('admin.pelanggaran.index')->with('toast', [
            'type' => 'success',
            'message' => 'Data pelanggaran berhasil ditambahkan.',
        ]);
    }

    public function edit(InputDataPelanggaran $pelanggaran): View
    {
        return view('admin.pelanggaran.edit', [
            'pelanggaran' => $pelanggaran,
            'siswa' => InputDataSiswa::all(),
        ]);
    }

    public function update(Request $request, InputDataPelanggaran $pelanggaran): RedirectResponse
    {
        $validated = $request->validate([
            'id_siswa' => 'required|exists:input_data_siswa,id_siswa',
            'tanggal_pelanggaran' => 'required|date',
            'poin' => 'required|integer|min:0',
            'tindakan' => 'required|string',
        ]);

        $pelanggaran->update($validated);

        return redirect()->route('admin.pelanggaran.index')->with('toast', [
            'type' => 'success',
            'message' => 'Data pelanggaran berhasil diperbarui.',
        ]);
    }

    public function destroy(InputDataPelanggaran $pelanggaran): RedirectResponse
    {
        $pelanggaran->delete();

        return redirect()->route('admin.pelanggaran.index')->with('toast', [
            'type' => 'success',
            'message' => 'Data pelanggaran berhasil dihapus.',
        ]);
    }
}
