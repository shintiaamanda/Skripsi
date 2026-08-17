<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InputDataSiswa;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InputDataSiswaController extends Controller
{
    public function index(Request $request): View
    {
        $query = InputDataSiswa::query();

        if ($search = $request->input('search')) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('nisn', 'like', "%{$search}%")
                ->orWhere('kelas', 'like', "%{$search}%");
        }

        return view('admin.siswa.index', [
            'siswa' => $query->latest()->paginate(10)->withQueryString(),
            'filters' => $request->only('search'),
        ]);
    }

    public function create(): View
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nisn' => 'required|string|max:20|unique:input_data_siswa,nisn',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'kelas' => 'required|string|max:50',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
        ]);

        InputDataSiswa::create($validated);

        return redirect()->route('admin.siswa.index')->with('toast', [
            'type' => 'success',
            'message' => 'Data siswa berhasil ditambahkan.',
        ]);
    }

    public function edit(InputDataSiswa $siswa): View
    {
        return view('admin.siswa.edit', [
            'siswa' => $siswa,
        ]);
    }

    public function update(Request $request, InputDataSiswa $siswa): RedirectResponse
    {
        $validated = $request->validate([
            'nisn' => 'required|string|max:20|unique:input_data_siswa,nisn,' . $siswa->id_siswa . ',id_siswa',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'kelas' => 'required|string|max:50',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
        ]);

        $siswa->update($validated);

        return redirect()->route('admin.siswa.index')->with('toast', [
            'type' => 'success',
            'message' => 'Data siswa berhasil diperbarui.',
        ]);
    }

    public function destroy(InputDataSiswa $siswa): RedirectResponse
    {
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('toast', [
            'type' => 'success',
            'message' => 'Data siswa berhasil dihapus.',
        ]);
    }
}
