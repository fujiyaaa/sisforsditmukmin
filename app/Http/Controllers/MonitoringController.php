<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\Siswa;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function create($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('guru.monitoring.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        Monitoring::create([
            'siswa_id' => $request->siswa_id,
            'surah' => $request->surah,
            'juz' => $request->juz,
            'jenis' => $request->jenis,
            'nilai' => $request->nilai,
            'keterangan' => $request->keterangan,
            'tanggal' => now()
        ]);

        return redirect('/guru/siswa');
    }
}
