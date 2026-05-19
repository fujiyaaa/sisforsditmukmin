<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\MonitoringSholat;
use Illuminate\Http\Request;

class MonitoringSholatController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::all();

        $kelas_id = $request->kelas_id;
        $tanggal = $request->tanggal ?? now()->toDateString();

        $siswas = collect();
        $monitoring = collect();

        if ($kelas_id) {
            $siswas = Siswa::with('kelas')
                ->where('kelas_id', $kelas_id)
                ->orderBy('nama')
                ->get();

            $monitoring = MonitoringSholat::where('tanggal', $tanggal)
                ->whereIn('siswa_id', $siswas->pluck('id'))
                ->get()
                ->keyBy('siswa_id');
        }

        return view('guru.monitoring-sholat.index', compact(
            'kelas',
            'kelas_id',
            'tanggal',
            'siswas',
            'monitoring'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'sholat'  => 'required|array',
        ]);

        foreach ($request->sholat as $siswa_id => $data) {
            MonitoringSholat::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'tanggal'  => $request->tanggal,
                ],
                [
                    'subuh'      => isset($data['subuh']) ? 1 : 0,
                    'dzuhur'     => isset($data['dzuhur']) ? 1 : 0,
                    'ashar'      => isset($data['ashar']) ? 1 : 0,
                    'maghrib'    => isset($data['maghrib']) ? 1 : 0,
                    'isya'       => isset($data['isya']) ? 1 : 0,
                    'keterangan' => $data['keterangan'] ?? null,
                ]
            );
        }

        return redirect()
            ->route('monitoring-sholat.index', [
                'kelas_id' => $request->kelas_id,
                'tanggal' => $request->tanggal,
            ])
            ->with('success', 'Monitoring sholat berhasil disimpan!');
    }
}