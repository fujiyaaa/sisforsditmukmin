<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Monitoring;
use App\Models\MonitoringSholat;
use App\Models\Absensi;
use App\Models\LaporanSiswa;
use Carbon\Carbon;
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
    public function dashboard()
    {
        $orangtuaId = auth()->id();

        $siswas = \App\Models\Siswa::with('kelas')
            ->where('orangtua_id', $orangtuaId)
            ->get();

        $siswaIds = $siswas->pluck('id');

        $totalSetoran = \App\Models\Monitoring::whereIn('siswa_id', $siswaIds)->count();

        $totalSholat = \App\Models\MonitoringSholat::whereIn('siswa_id', $siswaIds)
            ->selectRaw('SUM(subuh + dzuhur + ashar + maghrib + isya) as total')
            ->value('total') ?? 0;

        $totalAbsensiBulanIni = \App\Models\Absensi::whereIn('siswa_id', $siswaIds)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        $totalHadirBulanIni = \App\Models\Absensi::whereIn('siswa_id', $siswaIds)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->where('status', 'hadir')
            ->count();

        $persentaseAbsensi = $totalAbsensiBulanIni > 0
            ? round(($totalHadirBulanIni / $totalAbsensiBulanIni) * 100)
            : 0;

        $totalLaporan = \App\Models\LaporanSiswa::whereIn('siswa_id', $siswaIds)->count();

        $totalPrestasi = \App\Models\LaporanSiswa::whereIn('siswa_id', $siswaIds)
            ->where('jenis', 'prestasi')
            ->count();

        $totalPelanggaran = \App\Models\LaporanSiswa::whereIn('siswa_id', $siswaIds)
            ->where('jenis', 'pelanggaran')
            ->count();

        $totalInformasi = \App\Models\LaporanSiswa::whereIn('siswa_id', $siswaIds)
            ->where('jenis', 'informasi')
            ->count();

        $setoranTerbaru = \App\Models\Monitoring::with('siswa.kelas')
            ->whereIn('siswa_id', $siswaIds)
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $laporanTerbaru = \App\Models\LaporanSiswa::with('siswa.kelas')
            ->whereIn('siswa_id', $siswaIds)
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('orangtua.dashboard', compact(
            'siswas',
            'totalSetoran',
            'totalSholat',
            'persentaseAbsensi',
            'totalAbsensiBulanIni',
            'totalHadirBulanIni',
            'totalLaporan',
            'totalPrestasi',
            'totalPelanggaran',
            'totalInformasi',
            'setoranTerbaru',
            'laporanTerbaru'
        ));
    }
}
