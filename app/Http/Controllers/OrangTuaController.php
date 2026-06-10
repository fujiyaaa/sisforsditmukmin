<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Monitoring;
use App\Models\LaporanSiswa;
use Illuminate\Support\Facades\Auth;

class OrangTuaController extends Controller
{
    public function monitoring(Request $request)
    {
       $siswa = Siswa::first();

        if (!$siswa) {
            return back()->with('error', 'Data siswa tidak ditemukan');
        }

        $monitorings = Monitoring::where('siswa_id', $siswa->id)
            ->when($request->filled('tanggal'), function ($query) use ($request) {
                $query->whereDate('tanggal', $request->tanggal);
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalSetoran = Monitoring::where('siswa_id', $siswa->id)->count();

        $totalTahfidz = Monitoring::where('siswa_id', $siswa->id)
                        ->where('jenis', 'tahfidz')
                        ->count();

        $totalTilawah = Monitoring::where('siswa_id', $siswa->id)
                        ->where('jenis', 'tilawah')
                        ->count();

        $rataNilai = Monitoring::where('siswa_id', $siswa->id)
                        ->avg('nilai');

        return view('orangtua.monitoring.index', compact(
            'siswa',
            'monitorings',
            'totalSetoran',
            'totalTahfidz',
            'totalTilawah',
            'rataNilai'
        ));
    }
    public function laporan(Request $request)
    {
        // Sementara ambil siswa pertama dulu.
        // Nanti kalau sudah ada relasi orang tua-anak, bagian ini bisa disesuaikan.
        $siswa = Siswa::with('kelas')->first();

        if (!$siswa) {
            $laporans = collect();

            return view('orangtua.laporan.index', compact('siswa', 'laporans'));
        }

        $laporans = LaporanSiswa::where('siswa_id', $siswa->id)
            ->when($request->jenis, function ($query) use ($request) {
                $query->where('jenis', $request->jenis);
            })
            ->latest()
            ->get();

        $totalSemua = LaporanSiswa::where('siswa_id', $siswa->id)->count();

        $totalPrestasi = LaporanSiswa::where('siswa_id', $siswa->id)
            ->where('jenis', 'prestasi')
            ->count();

        $totalPelanggaran = LaporanSiswa::where('siswa_id', $siswa->id)
            ->where('jenis', 'pelanggaran')
            ->count();

        $totalInformasi = LaporanSiswa::where('siswa_id', $siswa->id)
            ->where('jenis', 'informasi')
            ->count();

        return view('orangtua.laporan.index', compact(
            'siswa',
            'laporans',
            'totalSemua',
            'totalPrestasi',
            'totalPelanggaran',
            'totalInformasi'
        ));
    }
}
