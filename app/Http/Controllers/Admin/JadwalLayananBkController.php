<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalLayananBk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JadwalLayananBkController extends Controller
{
    public function index(Request $request): View
    {
        $query = JadwalLayananBk::query();

        if ($search = $request->input('search')) {
            $query->where('hari', 'like', "%{$search}%")
                ->orWhere('guru', 'like', "%{$search}%");
        }

        return view('admin.jadwal.index', [
            'jadwal' => $query->latest()->paginate(10)->withQueryString(),
            'filters' => $request->only('search'),
        ]);
    }

    public function create(): View
    {
        return view('admin.jadwal.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hari' => 'required|string|max:20',
            'tanggal_layanan' => 'required|date',
            'jam' => 'required|string|max:20',
            'guru' => 'nullable|string|max:255',
        ]);

        $validated['guru'] = $request->input('guru') ?: $request->user()->nama;

        JadwalLayananBk::create($validated);

        return redirect()->route('admin.jadwal.index')->with('toast', [
            'type' => 'success',
            'message' => 'Jadwal layanan berhasil ditambahkan.',
        ]);
    }

    public function edit(JadwalLayananBk $jadwal): View
    {
        return view('admin.jadwal.edit', [
            'jadwal' => $jadwal,
        ]);
    }

    public function update(Request $request, JadwalLayananBk $jadwal): RedirectResponse
    {
        $validated = $request->validate([
            'hari' => 'required|string|max:20',
            'tanggal_layanan' => 'required|date',
            'jam' => 'required|string|max:20',
            'guru' => 'nullable|string|max:255',
        ]);

        $validated['guru'] = $request->input('guru') ?: $jadwal->guru;

        $jadwal->update($validated);

        return redirect()->route('admin.jadwal.index')->with('toast', [
            'type' => 'success',
            'message' => 'Jadwal layanan berhasil diperbarui.',
        ]);
    }

    public function destroy(JadwalLayananBk $jadwal): RedirectResponse
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('toast', [
            'type' => 'success',
            'message' => 'Jadwal layanan berhasil dihapus.',
        ]);
    }
}
