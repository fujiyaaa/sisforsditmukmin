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
        $orangtuaId = auth()->id();

        // Ambil hanya anak yang terhubung dengan akun orang tua login
        $siswas = Siswa::with('kelas')
            ->where('orangtua_id', $orangtuaId)
            ->get();

        $siswa = $siswas->first();
        $siswaIds = $siswas->pluck('id');

        $tanggal = $request->tanggal;

        $query = Monitoring::with('siswa.kelas')
            ->whereIn('siswa_id', $siswaIds);

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        $monitorings = $query
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalSetoran = $monitorings->count();

        $totalTahfidz = $monitorings->where('jenis', 'tahfidz')->count();
        $totalMurajaah = $monitorings->where('jenis', 'murajaah')->count();
        $totalTilawah = $monitorings->where('jenis', 'tilawah')->count();

        $rataRataNilai = $monitorings->count() > 0
            ? round($monitorings->avg('nilai'))
            : 0;

        return view('orangtua.monitoring.index', compact(
            'siswas',
            'siswa',
            'monitorings',
            'tanggal',
            'totalSetoran',
            'totalTahfidz',
            'totalMurajaah',
            'totalTilawah',
            'rataRataNilai'
        ));
    }

    public function laporan(Request $request)
    {
        $orangtuaId = auth()->id();

        // Ambil hanya anak yang terhubung dengan akun orang tua login
        $siswas = Siswa::with('kelas')
            ->where('orangtua_id', $orangtuaId)
            ->get();

        $siswa = $siswas->first();
        $siswaIds = $siswas->pluck('id');

        $jenis = $request->jenis;

        $query = LaporanSiswa::with('siswa.kelas')
            ->whereIn('siswa_id', $siswaIds);

        if ($jenis && $jenis !== 'semua') {
            $query->where('jenis', $jenis);
        }

        $laporans = $query
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $semuaLaporan = LaporanSiswa::whereIn('siswa_id', $siswaIds)->get();

        $totalSemua = $semuaLaporan->count();

        $totalPrestasi = $semuaLaporan
            ->where('jenis', 'prestasi')
            ->count();

        $totalPelanggaran = $semuaLaporan
            ->where('jenis', 'pelanggaran')
            ->count();

        $totalInformasi = $semuaLaporan
            ->where('jenis', 'informasi')
            ->count();

        return view('orangtua.laporan.index', compact(
            'siswas',
            'siswa',
            'laporans',
            'jenis',
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
