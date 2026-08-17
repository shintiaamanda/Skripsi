<?php

namespace App\Http\Controllers;

use App\Models\InputDataSiswa;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    public function dashboard(Request $request): View
    {
        $search = trim($request->input('search', ''));

        if ($search !== '') {
            $siswaList = InputDataSiswa::with(['monitoring', 'pelanggaran', 'konseling'])
                ->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%")
                        ->orWhere('kelas', 'like', "%{$search}%");
                })->get();
        } else {
            $siswaList = collect();
        }

        return view('orang-tua.dashboard', [
            'siswa' => $siswaList,
            'search' => $search,
        ]);
    }
}
