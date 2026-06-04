<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;

class OrangTuaAbsensiController extends Controller
{
        public function index(Request $request)
    {
        // Sementara karena belum pakai login
        $siswa = Siswa::with('kelas')->firstOrFail();

        $query = Absensi::where('siswa_id', $siswa->id)
            ->orderBy('tanggal', 'desc');

        // FILTER TANGGAL
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $absensis = $query->get();

        $semuaAbsensi = Absensi::where('siswa_id', $siswa->id)->get();

        $totalAbsensi = $semuaAbsensi->count();
        $totalHadir = $semuaAbsensi->where('status', 'hadir')->count();
        $totalIzin = $semuaAbsensi->where('status', 'izin')->count();
        $totalSakit = $semuaAbsensi->where('status', 'sakit')->count();
        $totalAlpha = $semuaAbsensi->where('status', 'alpha')->count();

        $totalTerlambat = $semuaAbsensi->filter(function ($item) {
            return $item->keterlambatan > 0;
        })->count();

        $persentaseHadir = $totalAbsensi > 0
            ? round(($totalHadir / $totalAbsensi) * 100)
            : 0;

        return view('orangtua.absensi.index', compact(
            'siswa',
            'absensis',
            'totalAbsensi',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlpha',
            'totalTerlambat',
            'persentaseHadir'
        ));
    }
}
