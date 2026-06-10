<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class MonitoringController extends Controller
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

    $siswas = Siswa::with('kelas')
        ->whereIn('kelas_id', $kelasIds)
        ->when($kelas_id, function ($query) use ($kelas_id) {
            $query->where('kelas_id', $kelas_id);
        })
        ->orderBy('kelas_id')
        ->orderBy('nama')
        ->get();

    $monitoringMentah = MonitoringSholat::whereDate('tanggal', $tanggal)
    ->whereIn('siswa_id', $siswas->pluck('id'))
    ->get()
    ->groupBy('siswa_id');

$monitoring = $monitoringMentah->map(function ($items) {
    return (object) [
        'subuh' => $items->contains(fn ($item) => (int) $item->subuh === 1),
        'dzuhur' => $items->contains(fn ($item) => (int) $item->dzuhur === 1),
        'ashar' => $items->contains(fn ($item) => (int) $item->ashar === 1),
        'maghrib' => $items->contains(fn ($item) => (int) $item->maghrib === 1),
        'isya' => $items->contains(fn ($item) => (int) $item->isya === 1),

        'keterangan' => $items
            ->pluck('keterangan')
            ->filter()
            ->unique()
            ->implode(', '),
    ];
});

    $siswasByKelas = $siswas->groupBy(function ($siswa) {
        return $siswa->kelas->nama_kelas ?? 'Tanpa Kelas';
    });

    return view('guru.monitoring-sholat.index', compact(
        'kelas',
        'kelas_id',
        'tanggal',
        'siswas',
        'siswasByKelas',
        'monitoring'
    ));
}

    public function create($nis)
{
    $kelasIds = $this->kelasIdsGuru();

    $siswa = Siswa::with('kelas')
        ->where('nis', $nis)
        ->whereIn('kelas_id', $kelasIds)
        ->firstOrFail();

    return view('guru.setoran.create', compact('siswa'));
}

   public function store(Request $request)
{
    $request->validate([
        'kelas_id' => 'nullable|exists:kelas,id',
        'tanggal' => 'required|date',
        'sholat'  => 'required|array',
    ]);

    $kelasIds = $this->kelasIdsGuru();

    if ($request->kelas_id && !$kelasIds->contains((int) $request->kelas_id)) {
        abort(403, 'Anda tidak memiliki akses ke kelas ini.');
    }

    $siswaIdsAkses = Siswa::whereIn('kelas_id', $kelasIds)
        ->when($request->kelas_id, function ($query) use ($request) {
            $query->where('kelas_id', $request->kelas_id);
        })
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

    if ($request->kelas_id && !$kelasIds->contains((int) $request->kelas_id)) {
        abort(403, 'Anda tidak memiliki akses ke kelas ini.');
    }

    $riwayat = Monitoring::with(['siswa.kelas'])
        ->whereHas('siswa', function ($query) use ($kelasIds, $request) {
            $query->whereIn('kelas_id', $kelasIds);

            if ($request->kelas_id) {
                $query->where('kelas_id', $request->kelas_id);
            }
        })
        ->latest()
        ->get();

    return view('guru.setoran.riwayat', compact('riwayat', 'kelas'));
}

}
