<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;

class OrangTuaAbsensiController extends Controller
{
        public function index(Request $request)
    {
        $orangtuaId = auth()->id();

        $siswas = Siswa::with('kelas')
            ->where('orangtua_id', $orangtuaId)
            ->get();

        $siswa = $siswas->first();
        $siswaIds = $siswas->pluck('id');

        $tanggal = $request->tanggal;

        $query = Absensi::with('siswa.kelas')
            ->whereIn('siswa_id', $siswaIds);

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        $absensis = $query
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalAbsensi = $absensis->count();

        $totalHadir = $absensis->where('status', 'hadir')->count();
        $totalIzin = $absensis->where('status', 'izin')->count();
        $totalSakit = $absensis->where('status', 'sakit')->count();
        $totalAlpha = $absensis->filter(function ($item) {
                return in_array(strtolower($item->status), ['alfa', 'alpha', 'alpa']);
            })->count();

        $totalTerlambat = $absensis->filter(function ($item) {
            return !empty($item->keterlambatan) && $item->keterlambatan > 0;
        })->count();

        $persentaseKehadiran = $totalAbsensi > 0
            ? round(($totalHadir / $totalAbsensi) * 100)
            : 0;

        return view('orangtua.absensi.index', compact(
            'siswas',
            'siswa',
            'absensis',
            'tanggal',
            'totalAbsensi',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlpha',
            'totalTerlambat',
            'persentaseKehadiran'
        ));
    }
}
