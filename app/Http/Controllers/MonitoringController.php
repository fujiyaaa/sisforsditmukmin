<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\Siswa;
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

        $siswasByKelas = $siswas->groupBy(function ($siswa) {
            return $siswa->kelas->nama_kelas ?? 'Tanpa Kelas';
        });

        return view('guru.setoran.index', compact(
            'kelas',
            'kelas_id',
            'siswas',
            'siswasByKelas'
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

    public function store(Request $request, $nis)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'surah' => 'required|string|max:255',
            'juz' => 'required|integer|min:1|max:30',
            'jenis' => 'required|in:tahfidz,murajaah,tilawah',
            'nilai' => 'required|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'surah.required' => 'Surah wajib diisi.',
            'juz.required' => 'Juz wajib diisi.',
            'jenis.required' => 'Jenis setoran wajib dipilih.',
            'nilai.required' => 'Nilai wajib diisi.',
        ]);

        $kelasIds = $this->kelasIdsGuru();

        $siswa = Siswa::where('nis', $nis)
            ->whereIn('kelas_id', $kelasIds)
            ->firstOrFail();

        Monitoring::create([
            'siswa_id' => $siswa->id,
            'tanggal' => $request->tanggal,
            'surah' => $request->surah,
            'juz' => $request->juz,
            'jenis' => $request->jenis,
            'nilai' => $request->nilai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('setoran.index')
            ->with('success', 'Setoran Quran berhasil disimpan.');
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
            ->when($request->filled('tanggal'), function ($query) use ($request) {
                $query->whereDate('tanggal', $request->tanggal);
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guru.setoran.riwayat', compact(
            'riwayat',
            'kelas'
        ));
    }
}
