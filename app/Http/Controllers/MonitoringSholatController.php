<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\MonitoringSholat;
use Illuminate\Http\Request;

class MonitoringSholatController extends Controller
{
    private function kelasIdsGuru()
    {
        return auth()->user()
            ->kelasDiampu()
            ->pluck('kelas.id');
    }

    public function index(Request $request)
    {
        $kelasIds = $this->kelasIdsGuru();

        $kelas = auth()->user()
            ->kelasDiampu()
            ->orderBy('nama_kelas')
            ->get();

        $kelas_id = $request->kelas_id;
        $tanggal = $request->tanggal ?? now()->toDateString();

        if ($kelas_id && !$kelasIds->contains((int) $kelas_id)) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $siswas = collect();
        $monitoring = collect();

        if ($kelas_id) {
            $siswas = Siswa::with('kelas')
                ->where('kelas_id', $kelas_id)
                ->whereIn('kelas_id', $kelasIds)
                ->orderBy('nama')
                ->get();

            $monitoring = MonitoringSholat::where('tanggal', $tanggal)
                ->where('sumber', 'guru')
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

        $kelasIds = $this->kelasIdsGuru();

        if (!$kelasIds->contains((int) $request->kelas_id)) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $siswaIdsAkses = Siswa::where('kelas_id', $request->kelas_id)
            ->whereIn('kelas_id', $kelasIds)
            ->pluck('id');

        foreach ($request->sholat as $siswa_id => $data) {
            if (!$siswaIdsAkses->contains((int) $siswa_id)) {
                abort(403, 'Anda tidak memiliki akses untuk menyimpan data siswa ini.');
            }

            MonitoringSholat::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'tanggal'  => $request->tanggal,
                    'sumber'   => 'guru',
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

    public function riwayat(Request $request)
    {
        $kelasIds = $this->kelasIdsGuru();

        $kelas = auth()->user()
            ->kelasDiampu()
            ->orderBy('nama_kelas')
            ->get();

        $kelas_id = $request->kelas_id;
        $tanggal = $request->tanggal;

        if ($kelas_id && !$kelasIds->contains((int) $kelas_id)) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $query = MonitoringSholat::with(['siswa.kelas'])
            ->whereHas('siswa', function ($q) use ($kelasIds, $kelas_id) {
                $q->whereIn('kelas_id', $kelasIds);

                if ($kelas_id) {
                    $q->where('kelas_id', $kelas_id);
                }
            });

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        $riwayat = $query
            ->orderBy('tanggal', 'desc')
            ->orderBy('sumber', 'asc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('tanggal');

        return view('guru.monitoring-sholat.riwayat', compact(
            'kelas',
            'kelas_id',
            'tanggal',
            'riwayat'
        ));
    }
}
