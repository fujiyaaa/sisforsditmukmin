<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\MonitoringSholat;
use Carbon\Carbon;

class AdminMonitoringSholatController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->format('Y-m-d');
        $kelasId = $request->kelas_id;

        $kelas = Kelas::orderBy('nama_kelas')->get();

        $siswas = Siswa::with('kelas')
            ->when($kelasId, function ($query) use ($kelasId) {
                $query->where('kelas_id', $kelasId);
            })
            ->orderBy('kelas_id')
            ->orderBy('nama')
            ->get()
            ->groupBy(function ($siswa) {
                return $siswa->kelas->nama_kelas ?? 'Tanpa Kelas';
            });

        $monitoringHariIni = MonitoringSholat::where('tanggal', $tanggal)
            ->where('sumber', 'admin')
            ->get()
            ->keyBy('siswa_id');

        return view('admin.monitoring-sholat.index', compact(
            'kelas',
            'siswas',
            'tanggal',
            'kelasId',
            'monitoringHariIni'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'siswa_ids' => 'required|array',
            'keterangan' => 'nullable|array',
        ]);

        foreach ($request->siswa_ids as $siswaId) {
            MonitoringSholat::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'tanggal' => $request->tanggal,
                    'sumber' => 'admin',
                ],
                [
                    'subuh' => isset($request->subuh[$siswaId]) ? 1 : 0,
                    'dzuhur' => isset($request->dzuhur[$siswaId]) ? 1 : 0,
                    'ashar' => isset($request->ashar[$siswaId]) ? 1 : 0,
                    'maghrib' => isset($request->maghrib[$siswaId]) ? 1 : 0,
                    'isya' => isset($request->isya[$siswaId]) ? 1 : 0,
                    'keterangan' => $request->keterangan[$siswaId] ?? null,
                ]
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Monitoring sholat berhasil disimpan oleh admin.');
    }

    public function riwayat(Request $request)
{
    $kelas = Kelas::orderBy('nama_kelas')->get();

    $bulanAngka = $request->bulan ?? now()->format('m');
    $tahun = $request->tahun ?? now()->format('Y');
    $kelasId = $request->kelas_id;

    $tanggalAwal = Carbon::createFromDate($tahun, $bulanAngka, 1)->startOfMonth();
    $tanggalAkhir = Carbon::createFromDate($tahun, $bulanAngka, 1)->endOfMonth();

    $monitoringBulan = MonitoringSholat::with('siswa.kelas')
        ->whereBetween('tanggal', [
            $tanggalAwal->format('Y-m-d'),
            $tanggalAkhir->format('Y-m-d'),
        ])
        ->when($kelasId, function ($query) use ($kelasId) {
            $query->whereHas('siswa', function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        })
        ->orderBy('tanggal', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

    $groupTanggal = $monitoringBulan->groupBy(function ($item) {
        return Carbon::parse($item->tanggal)->format('Y-m-d');
    });

    if ($request->tanggal) {
        $tanggalDipilih = Carbon::parse($request->tanggal)->format('Y-m-d');
    } elseif ($monitoringBulan->count() > 0) {
        $tanggalDipilih = Carbon::parse($monitoringBulan->first()->tanggal)->format('Y-m-d');
    } else {
        $tanggalDipilih = $tanggalAwal->format('Y-m-d');
    }

    $detailTanggal = MonitoringSholat::with('siswa.kelas')
        ->whereDate('tanggal', $tanggalDipilih)
        ->when($kelasId, function ($query) use ($kelasId) {
            $query->whereHas('siswa', function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        })
        ->orderBy('sumber')
        ->get();

    $kalender = [];
    $jumlahHari = $tanggalAwal->daysInMonth;

    for ($i = 1; $i <= $jumlahHari; $i++) {
        $tanggal = Carbon::createFromDate($tahun, $bulanAngka, $i);
        $tanggalFormat = $tanggal->format('Y-m-d');

        $dataTanggal = $groupTanggal->get($tanggalFormat, collect());

        $kalender[] = [
            'tanggal' => $tanggalFormat,
            'hari' => $i,
            'nama_hari' => $tanggal->translatedFormat('D'),
            'total' => $dataTanggal->count(),
            'is_selected' => $tanggalFormat === $tanggalDipilih,
            'is_today' => $tanggalFormat === now()->format('Y-m-d'),
        ];
    }

    $tanggalTerbanyak = collect($kalender)
        ->sortByDesc('total')
        ->first();

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

    $daftarTahun = range(now()->year, 2024);

    $paddingAwalKalender = $tanggalAwal->isoWeekday() - 1;

    return view('admin.monitoring-sholat.riwayat', compact(
        'kelas',
        'kelasId',
        'bulanAngka',
        'tahun',
        'tanggalAwal',
        'tanggalAkhir',
        'tanggalDipilih',
        'detailTanggal',
        'kalender',
        'paddingAwalKalender',
        'daftarBulan',
        'daftarTahun',
        'tanggalTerbanyak'
    ));
}
}
