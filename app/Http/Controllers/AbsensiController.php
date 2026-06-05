<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;

class AbsensiController extends Controller
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

        $kelasList = auth()->user()
            ->kelasDiampu()
            ->orderBy('nama_kelas')
            ->get();

        $tanggal = $request->tanggal ?? date('Y-m-d');
        $kelasId = $request->kelas_id;

        if ($kelasId && !$kelasIds->contains((int) $kelasId)) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $siswas = collect();
        $absensiHariIni = collect();

        if ($kelasId) {
            $siswas = Siswa::with('kelas')
                ->where('kelas_id', $kelasId)
                ->whereIn('kelas_id', $kelasIds)
                ->orderBy('nama')
                ->get();

            $absensiHariIni = Absensi::whereDate('tanggal', $tanggal)
                ->whereIn('siswa_id', $siswas->pluck('id'))
                ->get()
                ->keyBy('siswa_id');
        }

        $totalSiswa = $siswas->count();

        $hadir = $absensiHariIni->where('status', 'hadir')->count();
        $izin = $absensiHariIni->where('status', 'izin')->count();
        $sakit = $absensiHariIni->where('status', 'sakit')->count();
        $alpha = $absensiHariIni->where('status', 'alpha')->count();

        $riwayatAbsensi = Absensi::with(['siswa.kelas'])
            ->whereHas('siswa', function ($query) use ($kelasIds, $kelasId) {
                $query->whereIn('kelas_id', $kelasIds);

                if ($kelasId) {
                    $query->where('kelas_id', $kelasId);
                }
            })
            ->latest('tanggal')
            ->latest()
            ->get();

        return view('guru.absensi.index', compact(
            'kelasList',
            'tanggal',
            'kelasId',
            'siswas',
            'absensiHariIni',
            'totalSiswa',
            'hadir',
            'izin',
            'sakit',
            'alpha',
            'riwayatAbsensi'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'siswa_id' => 'required|array',
            'siswa_id.*' => 'required|exists:siswas,id',
            'status' => 'required|array',
            'waktu_absen' => 'nullable|array',
            'keterlambatan' => 'nullable|array',
            'keterangan' => 'nullable|array',
        ]);

        $kelasIds = $this->kelasIdsGuru();

        $jumlahSiswaValid = Siswa::whereIn('id', $request->siswa_id)
            ->whereIn('kelas_id', $kelasIds)
            ->count();

        if ($jumlahSiswaValid !== count($request->siswa_id)) {
            abort(403, 'Anda tidak memiliki akses untuk menyimpan absensi siswa ini.');
        }

        foreach ($request->siswa_id as $siswaId) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'status' => $request->status[$siswaId] ?? 'hadir',
                    'waktu_absen' => $request->waktu_absen[$siswaId] ?? null,
                    'keterlambatan' => $request->keterlambatan[$siswaId] ?? 0,
                    'keterangan' => $request->keterangan[$siswaId] ?? null,
                ]
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Data absensi berhasil disimpan.');
    }
}
