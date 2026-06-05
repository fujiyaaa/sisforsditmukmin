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

    if ($request->kelas_id && !$kelasIds->contains((int) $request->kelas_id)) {
        abort(403, 'Anda tidak memiliki akses ke kelas ini.');
    }

    $siswas = Siswa::with('kelas')
        ->whereIn('kelas_id', $kelasIds)
        ->when($request->kelas_id, function ($query) use ($request) {
            $query->where('kelas_id', $request->kelas_id);
        })
        ->orderBy('nama')
        ->get()
        ->groupBy(function ($siswa) {
            return $siswa->kelas->nama_kelas ?? 'Tanpa Kelas';
        });

    return view('guru.setoran.index', compact('siswas', 'kelas'));
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

   public function store(Request $request, $nis)
{
    $request->validate([
        'surah' => ['required', 'string', 'max:255'],
        'juz' => ['required', 'integer', 'min:1', 'max:30'],
        'jenis' => ['required', 'in:tahfidz,murajaah,tilawah'],
        'nilai' => ['required', 'integer', 'min:0', 'max:100'],
        'keterangan' => ['nullable', 'string'],
    ]);

    $siswa = Siswa::where('nis', $nis)
        ->whereIn('kelas_id', $this->kelasIdsGuru())
        ->firstOrFail();

    Monitoring::create([
        'siswa_id' => $siswa->id,
        'surah' => $request->surah,
        'juz' => $request->juz,
        'jenis' => $request->jenis,
        'nilai' => $request->nilai,
        'keterangan' => $request->keterangan,
    ]);

    return redirect()
        ->route('setoran.index')
        ->with('success', 'Data setoran berhasil disimpan.');
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

    $monitorings = Monitoring::with(['siswa.kelas'])
        ->whereHas('siswa', function ($query) use ($kelasIds, $request) {
            $query->whereIn('kelas_id', $kelasIds);

            if ($request->kelas_id) {
                $query->where('kelas_id', $request->kelas_id);
            }
        })
        ->latest()
        ->get();

    return view('guru.setoran.riwayat', compact('monitorings', 'kelas'));
}

}
