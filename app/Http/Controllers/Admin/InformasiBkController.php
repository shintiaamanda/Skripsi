<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiBk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InformasiBkController extends Controller
{
    public function index(Request $request): View
    {
        $query = InformasiBk::query();

        return view('admin.informasi.index', [
            'informasi' => $query->latest()->paginate(10)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.informasi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'informasi' => 'required|string',
            'tanggal_informasi' => 'required|date',
        ]);

        InformasiBk::create($validated);

        return redirect()->route('admin.informasi.index')->with('toast', [
            'type' => 'success',
            'message' => 'Informasi BK berhasil ditambahkan.',
        ]);
    }

    public function edit(InformasiBk $informasi): View
    {
        return view('admin.informasi.edit', [
            'informasi' => $informasi,
        ]);
    }

    public function update(Request $request, InformasiBk $informasi): RedirectResponse
    {
        $validated = $request->validate([
            'informasi' => 'required|string',
            'tanggal_informasi' => 'required|date',
        ]);

        $informasi->update($validated);

        return redirect()->route('admin.informasi.index')->with('toast', [
            'type' => 'success',
            'message' => 'Informasi BK berhasil diperbarui.',
        ]);
    }

    public function destroy(InformasiBk $informasi): RedirectResponse
    {
        $informasi->delete();

        return redirect()->route('admin.informasi.index')->with('toast', [
            'type' => 'success',
            'message' => 'Informasi BK berhasil dihapus.',
        ]);
    }
}
