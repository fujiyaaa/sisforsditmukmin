<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Absensi;
use Carbon\Carbon;

class AdminAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->format('Y-m-d');
        $kelasId = $request->kelas_id;

        $kelas = Kelas::orderBy('nama_kelas')->get();

        $kelasAktif = null;
        $siswas = collect();

        if ($kelasId) {
            $kelasAktif = Kelas::find($kelasId);

            $siswas = Siswa::with('kelas')
                ->where('kelas_id', $kelasId)
                ->orderBy('nama')
                ->get();
        }

        $absensiHariIni = Absensi::where('tanggal', $tanggal)
            ->when($kelasId, function ($query) use ($kelasId) {
                $query->whereHas('siswa', function ($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId);
                });
            })
            ->get()
            ->keyBy('siswa_id');

        $totalSiswa = $siswas->count();
        $totalHadir = $absensiHariIni->where('status', 'hadir')->count();
        $totalIzin  = $absensiHariIni->where('status', 'izin')->count();
        $totalSakit = $absensiHariIni->where('status', 'sakit')->count();
        $totalAlfa  = $absensiHariIni->where('status', 'alpha')->count();

        return view('admin.absensi.index', compact(
            'kelas',
            'kelasId',
            'kelasAktif',
            'tanggal',
            'siswas',
            'absensiHariIni',
            'totalSiswa',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlfa'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kelas_id' => 'required|exists:kelas,id',
            'status' => 'required|array',
            'status.*' => 'required|in:hadir,izin,sakit,alpha',
            'waktu_absen' => 'nullable|array',
            'keterlambatan' => 'nullable|array',
            'keterangan' => 'nullable|array',
        ]);

        foreach ($request->status as $siswaId => $status) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'status' => $status,
                    'waktu_absen' => $request->waktu_absen[$siswaId] ?? null,
                    'keterlambatan' => $request->keterlambatan[$siswaId] ?? 0,
                    'keterangan' => $request->keterangan[$siswaId] ?? null,
                ]
            );
        }

        return redirect()
            ->route('admin.absensi.index', [
                'kelas_id' => $request->kelas_id,
                'tanggal' => $request->tanggal,
            ])
            ->with('success', 'Absensi berhasil disimpan.');
    }
}
