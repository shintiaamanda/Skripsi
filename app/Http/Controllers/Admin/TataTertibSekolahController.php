<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TataTertibSekolah;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TataTertibSekolahController extends Controller
{
    public function index(Request $request): View
    {
        $query = TataTertibSekolah::query();

        return view('admin.tata-tertib.index', [
            'tataTertib' => $query->latest()->paginate(10)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.tata-tertib.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tata_tertib' => 'required|string',
            'tanggal_konseling' => 'required|date',
        ]);

        TataTertibSekolah::create($validated);

        return redirect()->route('admin.tata-tertib.index')->with('toast', [
            'type' => 'success',
            'message' => 'Tata tertib berhasil ditambahkan.',
        ]);
    }

    public function edit(TataTertibSekolah $tataTertib): View
    {
        return view('admin.tata-tertib.edit', [
            'tataTertib' => $tataTertib,
        ]);
    }

    public function update(Request $request, TataTertibSekolah $tataTertib): RedirectResponse
    {
        $validated = $request->validate([
            'tata_tertib' => 'required|string',
            'tanggal_konseling' => 'required|date',
        ]);

        $tataTertib->update($validated);

        return redirect()->route('admin.tata-tertib.index')->with('toast', [
            'type' => 'success',
            'message' => 'Tata tertib berhasil diperbarui.',
        ]);
    }

    public function destroy(TataTertibSekolah $tataTertib): RedirectResponse
    {
        $tataTertib->delete();

        return redirect()->route('admin.tata-tertib.index')->with('toast', [
            'type' => 'success',
            'message' => 'Tata tertib berhasil dihapus.',
        ]);
    }
}
