<?php

namespace App\Http\Controllers;

use App\Models\InputDataKonseling;
use App\Models\InputDataPelanggaran;
use App\Models\InputDataSiswa;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class KepalaSekolahController extends Controller
{
    public function dashboard(Request $request): View
    {
        return view('kepala-sekolah.dashboard', [
            'stats' => [
                'totalSiswa' => InputDataSiswa::count(),
                'totalKonseling' => InputDataKonseling::count(),
                'totalPelanggaran' => InputDataPelanggaran::count(),
            ],
        ]);
    }
}
