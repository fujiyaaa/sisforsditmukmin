<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\MonitoringSholat;
use App\Models\Absensi;
use Carbon\Carbon;

class RekapPersentaseController extends Controller
{
    public function index(Request $request)
    {
        $jenisRekap = $request->jenis_rekap ?? 'sholat';

        $bulanAngka = $request->bulan ?? now()->format('m');

        /*
        |--------------------------------------------------------------------------
        | TAHUN AJARAN DEFAULT
        |--------------------------------------------------------------------------
        | Kalau bulan sekarang Juli-Desember, default tahun ajaran = tahun ini - tahun depan.
        | Kalau Januari-Juni, default tahun ajaran = tahun lalu - tahun ini.
        */

        $tahunSekarang = now()->year;
        $bulanSekarang = now()->month;

        if ($bulanSekarang >= 7) {
            $tahunAjaranDefault = $tahunSekarang . '-' . ($tahunSekarang + 1);
        } else {
            $tahunAjaranDefault = ($tahunSekarang - 1) . '-' . $tahunSekarang;
        }

        $tahunAjaran = $request->tahun_ajaran ?? $tahunAjaranDefault;

        [$tahunAwalAjaran, $tahunAkhirAjaran] = explode('-', $tahunAjaran);

        /*
        |--------------------------------------------------------------------------
        | LOGIKA TAHUN AJARAN
        |--------------------------------------------------------------------------
        | Juli-Desember pakai tahun awal ajaran.
        | Januari-Juni pakai tahun akhir ajaran.
        |
        | Contoh:
        | Tahun ajaran 2026-2027 + Agustus  = 2026-08
        | Tahun ajaran 2026-2027 + Januari  = 2027-01
        */

        if ((int) $bulanAngka >= 7) {
            $tahun = $tahunAwalAjaran;
        } else {
            $tahun = $tahunAkhirAjaran;
        }

        $bulan = $tahun . '-' . $bulanAngka;

        $tanggalAwal = Carbon::parse($bulan . '-01')->startOfMonth();
        $tanggalAkhir = Carbon::parse($bulan . '-01')->endOfMonth();

        /*
        |--------------------------------------------------------------------------
        | JUMLAH HARI SHOLAT
        |--------------------------------------------------------------------------
        | Sholat dihitung berdasarkan semua hari kalender dalam bulan.
        */

        $jumlahHariSholat = $tanggalAwal->daysInMonth;

        /*
        |--------------------------------------------------------------------------
        | JUMLAH HARI ABSENSI
        |--------------------------------------------------------------------------
        | Default otomatis menghitung Senin-Jumat.
        | Kalau admin isi manual, sistem pakai angka manual dari admin.
        */

        $jumlahHariAbsensiOtomatis = 0;
        $periode = $tanggalAwal->copy();

        while ($periode->lte($tanggalAkhir)) {
            if ($periode->isWeekday()) {
                $jumlahHariAbsensiOtomatis++;
            }

            $periode->addDay();
        }

        $hariEfektifManual = $request->hari_efektif;

        $jumlahHariAbsensi = $hariEfektifManual
            ? (int) $hariEfektifManual
            : $jumlahHariAbsensiOtomatis;

        /*
        |--------------------------------------------------------------------------
        | DROPDOWN BULAN
        |--------------------------------------------------------------------------
        */

        $daftarBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        /*
        |--------------------------------------------------------------------------
        | DROPDOWN TAHUN AJARAN
        |--------------------------------------------------------------------------
        | Dimulai dari 2024-2025.
        | Nanti otomatis bertambah mengikuti tahun sekarang.
        |
        | Contoh kalau sekarang 2026:
        | 2026-2027
        | 2025-2026
        | 2024-2025
        */

        $daftarTahunAjaran = [];

        $tahunMulai = 2024;
        $tahunSekarang = now()->year;

        for ($i = $tahunSekarang; $i >= $tahunMulai; $i--) {
            $daftarTahunAjaran[] = $i . '-' . ($i + 1);
        }

        /*
        |--------------------------------------------------------------------------
        | DATA KELAS DAN SISWA
        |--------------------------------------------------------------------------
        | Model Kelas kamu memakai relasi siswa(), bukan siswas().
        */

        $kelas = Kelas::with(['siswa' => function ($query) {
                $query->orderBy('nama');
            }])
            ->orderBy('nama_kelas')
            ->get();

        $rekapKelas = [];

        foreach ($kelas as $itemKelas) {
            $jumlahSiswa = $itemKelas->siswa->count();

            $totalSholatKelas = 0;

            $totalHadirKelas = 0;
            $totalIzinKelas = 0;
            $totalSakitKelas = 0;
            $totalAlfaKelas = 0;

            $detailSiswa = [];

            foreach ($itemKelas->siswa as $siswa) {

                /*
                |--------------------------------------------------------------------------
                | REKAP SHOLAT PER SISWA
                |--------------------------------------------------------------------------
                */

                $dataSholat = MonitoringSholat::where('siswa_id', $siswa->id)
                    ->whereBetween('tanggal', [
                        $tanggalAwal->format('Y-m-d'),
                        $tanggalAkhir->format('Y-m-d')
                    ])
                    ->get();

                $totalSholatSiswa = 0;

                foreach ($dataSholat as $sholat) {
                    $totalSholatSiswa += $sholat->subuh ? 1 : 0;
                    $totalSholatSiswa += $sholat->dzuhur ? 1 : 0;
                    $totalSholatSiswa += $sholat->ashar ? 1 : 0;
                    $totalSholatSiswa += $sholat->maghrib ? 1 : 0;
                    $totalSholatSiswa += $sholat->isya ? 1 : 0;
                }

                $targetSholatSiswa = $jumlahHariSholat * 5;

                $persentaseSholatSiswa = $targetSholatSiswa > 0
                    ? round(($totalSholatSiswa / $targetSholatSiswa) * 100, 2)
                    : 0;

                /*
                |--------------------------------------------------------------------------
                | REKAP ABSENSI PER SISWA
                |--------------------------------------------------------------------------
                */

                $dataAbsensi = Absensi::where('siswa_id', $siswa->id)
                    ->whereBetween('tanggal', [
                        $tanggalAwal->format('Y-m-d'),
                        $tanggalAkhir->format('Y-m-d')
                    ])
                    ->get();

                $hadir = $dataAbsensi->where('status', 'hadir')->count();
                $izin = $dataAbsensi->where('status', 'izin')->count();
                $sakit = $dataAbsensi->where('status', 'sakit')->count();
                $alfa = $dataAbsensi->where('status', 'alfa')->count();

                $targetAbsensiSiswa = $jumlahHariAbsensi;

                $persentaseAbsensiSiswa = $targetAbsensiSiswa > 0
                    ? round(($hadir / $targetAbsensiSiswa) * 100, 2)
                    : 0;

                /*
                |--------------------------------------------------------------------------
                | TOTAL KELAS
                |--------------------------------------------------------------------------
                */

                $totalSholatKelas += $totalSholatSiswa;

                $totalHadirKelas += $hadir;
                $totalIzinKelas += $izin;
                $totalSakitKelas += $sakit;
                $totalAlfaKelas += $alfa;

                $detailSiswa[] = [
                    'nis' => $siswa->nis,
                    'nama' => $siswa->nama,

                    'total_sholat' => $totalSholatSiswa,
                    'target_sholat' => $targetSholatSiswa,
                    'persentase_sholat' => $persentaseSholatSiswa,

                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                    'alfa' => $alfa,
                    'target_absensi' => $targetAbsensiSiswa,
                    'persentase_absensi' => $persentaseAbsensiSiswa,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | PERSENTASE PER KELAS
            |--------------------------------------------------------------------------
            */

            $targetSholatKelas = $jumlahSiswa * $jumlahHariSholat * 5;

            $persentaseSholatKelas = $targetSholatKelas > 0
                ? round(($totalSholatKelas / $targetSholatKelas) * 100, 2)
                : 0;

            $targetAbsensiKelas = $jumlahSiswa * $jumlahHariAbsensi;

            $persentaseAbsensiKelas = $targetAbsensiKelas > 0
                ? round(($totalHadirKelas / $targetAbsensiKelas) * 100, 2)
                : 0;

            $rekapKelas[] = [
                'kelas_id' => $itemKelas->id,
                'kelas' => $itemKelas->nama_kelas,
                'jumlah_siswa' => $jumlahSiswa,

                'total_sholat' => $totalSholatKelas,
                'target_sholat' => $targetSholatKelas,
                'persentase_sholat' => $persentaseSholatKelas,

                'hadir' => $totalHadirKelas,
                'izin' => $totalIzinKelas,
                'sakit' => $totalSakitKelas,
                'alfa' => $totalAlfaKelas,
                'target_absensi' => $targetAbsensiKelas,
                'persentase_absensi' => $persentaseAbsensiKelas,

                'detail_siswa' => $detailSiswa,
            ];
        }

        return view('admin.rekap-persentase.index', compact(
            'jenisRekap',
            'rekapKelas',
            'bulan',
            'bulanAngka',
            'tahun',
            'tahunAjaran',
            'daftarBulan',
            'daftarTahunAjaran',
            'tanggalAwal',
            'tanggalAkhir',
            'jumlahHariSholat',
            'jumlahHariAbsensi',
            'jumlahHariAbsensiOtomatis',
            'hariEfektifManual'
        ));
    }
}
