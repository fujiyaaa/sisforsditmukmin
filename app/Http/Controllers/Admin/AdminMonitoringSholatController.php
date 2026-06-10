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

        $monitoringHariIniMentah = MonitoringSholat::whereDate('tanggal', $tanggal)
            ->get()
            ->groupBy('siswa_id');

        $monitoringHariIni = [];

        foreach ($monitoringHariIniMentah as $siswaId => $items) {
            $monitoringHariIni[$siswaId] = (object) [
                'subuh' => $items->contains(fn ($item) => (int) $item->subuh === 1),
                'dzuhur' => $items->contains(fn ($item) => (int) $item->dzuhur === 1),
                'ashar' => $items->contains(fn ($item) => (int) $item->ashar === 1),
                'maghrib' => $items->contains(fn ($item) => (int) $item->maghrib === 1),
                'isya' => $items->contains(fn ($item) => (int) $item->isya === 1),
                'keterangan' => $items
                    ->pluck('keterangan')
                    ->filter()
                    ->unique()
                    ->implode(', '),
            ];
        }

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
        'sholat' => 'nullable|array',
        'keterangan' => 'nullable|array',
    ]);

    foreach ($request->siswa_ids as $siswaId) {
        $data = $request->sholat[$siswaId] ?? [];

        MonitoringSholat::updateOrCreate(
            [
                'siswa_id' => $siswaId,
                'tanggal'  => $request->tanggal,
                'sumber'   => 'admin',
            ],
            [
                'subuh'      => isset($data['subuh']) ? 1 : 0,
                'dzuhur'     => isset($data['dzuhur']) ? 1 : 0,
                'ashar'      => isset($data['ashar']) ? 1 : 0,
                'maghrib'    => isset($data['maghrib']) ? 1 : 0,
                'isya'       => isset($data['isya']) ? 1 : 0,
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

        $gabungkanMonitoring = function ($items) {
            return $items
                ->groupBy('siswa_id')
                ->map(function ($dataSiswa) {
                    $utama = $dataSiswa->first();

                    $sumber = $dataSiswa
                        ->pluck('sumber')
                        ->filter()
                        ->unique()
                        ->map(function ($item) {
                            if ($item === 'orangtua') {
                                return 'Orang Tua';
                            }

                            return ucfirst($item);
                        })
                        ->implode(', ');

                    return (object) [
                        'id' => $utama->id,
                        'siswa_id' => $utama->siswa_id,
                        'tanggal' => $utama->tanggal,
                        'siswa' => $utama->siswa,

                        'subuh' => $dataSiswa->contains(fn ($item) => (int) $item->subuh === 1),
                        'dzuhur' => $dataSiswa->contains(fn ($item) => (int) $item->dzuhur === 1),
                        'ashar' => $dataSiswa->contains(fn ($item) => (int) $item->ashar === 1),
                        'maghrib' => $dataSiswa->contains(fn ($item) => (int) $item->maghrib === 1),
                        'isya' => $dataSiswa->contains(fn ($item) => (int) $item->isya === 1),

                        'sumber' => $sumber ?: '-',

                        'keterangan' => $dataSiswa
                            ->pluck('keterangan')
                            ->filter()
                            ->unique()
                            ->implode(', '),
                    ];
                })
                ->values();
        };

        $monitoringBulanMentah = MonitoringSholat::with('siswa.kelas')
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

        $groupTanggalMentah = $monitoringBulanMentah->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('Y-m-d');
        });

        $groupTanggal = $groupTanggalMentah->map(function ($items) use ($gabungkanMonitoring) {
            return $gabungkanMonitoring($items);
        });

        if ($request->tanggal) {
            $tanggalDipilih = Carbon::parse($request->tanggal)->format('Y-m-d');
        } elseif ($monitoringBulanMentah->count() > 0) {
            $tanggalDipilih = Carbon::parse($monitoringBulanMentah->first()->tanggal)->format('Y-m-d');
        } else {
            $tanggalDipilih = $tanggalAwal->format('Y-m-d');
        }

        $detailTanggalMentah = MonitoringSholat::with('siswa.kelas')
            ->whereDate('tanggal', $tanggalDipilih)
            ->when($kelasId, function ($query) use ($kelasId) {
                $query->whereHas('siswa', function ($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId);
                });
            })
            ->orderBy('sumber')
            ->get();

        $detailTanggal = $gabungkanMonitoring($detailTanggalMentah);

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
