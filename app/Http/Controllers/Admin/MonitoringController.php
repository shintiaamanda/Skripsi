<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InputDataMonitoring;
use App\Models\InputDataSiswa;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index(Request $request): View
    {
        $query = InputDataMonitoring::with('siswa');

        if ($search = $request->input('search')) {
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        return view('admin.monitoring.index', [
            'monitoring' => $query->latest()->paginate(10)->withQueryString(),
            'filters' => $request->only('search'),
        ]);
    }

    public function create(): View
    {
        return view('admin.monitoring.create', [
            'siswa' => InputDataSiswa::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_siswa' => 'required|exists:input_data_siswa,id_siswa',
            'tanggal_monitoring' => 'required|date',
            'perkembangan' => 'required|string',
        ]);

        InputDataMonitoring::create($validated);

        return redirect()->route('admin.monitoring.index')->with('toast', [
            'type' => 'success',
            'message' => 'Data monitoring berhasil ditambahkan.',
        ]);
    }

    public function edit(InputDataMonitoring $monitoring): View
    {
        return view('admin.monitoring.edit', [
            'monitoring' => $monitoring,
            'siswa' => InputDataSiswa::all(),
        ]);
    }

    public function update(Request $request, InputDataMonitoring $monitoring): RedirectResponse
    {
        $validated = $request->validate([
            'id_siswa' => 'required|exists:input_data_siswa,id_siswa',
            'tanggal_monitoring' => 'required|date',
            'perkembangan' => 'required|string',
        ]);

        $monitoring->update($validated);

        return redirect()->route('admin.monitoring.index')->with('toast', [
            'type' => 'success',
            'message' => 'Data monitoring berhasil diperbarui.',
        ]);
    }

    public function destroy(InputDataMonitoring $monitoring): RedirectResponse
    {
        $monitoring->delete();

        return redirect()->route('admin.monitoring.index')->with('toast', [
            'type' => 'success',
            'message' => 'Data monitoring berhasil dihapus.',
        ]);
    }
}
