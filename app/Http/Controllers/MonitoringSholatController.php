<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\MonitoringSholat;
use Illuminate\Http\Request;

class MonitoringSholatController extends Controller
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

    $kelas = auth()->user()
        ->kelasDiampu()
        ->orderBy('nama_kelas')
        ->get();

    $kelas_id = $request->kelas_id;
    $tanggal = $request->tanggal ?? now()->toDateString();

    if ($kelas_id && !$kelasIds->contains((int) $kelas_id)) {
        abort(403, 'Anda tidak memiliki akses ke kelas ini.');
    }

    $siswas = Siswa::with('kelas')
        ->whereIn('kelas_id', $kelasIds)
        ->when($kelas_id, function ($query) use ($kelas_id) {
            $query->where('kelas_id', $kelas_id);
        })
        ->orderBy('kelas_id')
        ->orderBy('nama')
        ->get();

    $monitoringMentah = MonitoringSholat::whereDate('tanggal', $tanggal)
        ->whereIn('siswa_id', $siswas->pluck('id'))
        ->get()
        ->groupBy('siswa_id');

    $monitoring = [];

    foreach ($monitoringMentah as $siswaId => $items) {
        $monitoring[$siswaId] = (object) [
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

    $siswasByKelas = $siswas->groupBy(function ($siswa) {
        return $siswa->kelas->nama_kelas ?? 'Tanpa Kelas';
    });

    return view('guru.monitoring-sholat.index', compact(
        'kelas',
        'kelas_id',
        'tanggal',
        'siswas',
        'siswasByKelas',
        'monitoring'
    ));
}

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'nullable|exists:kelas,id',
            'tanggal' => 'required|date',
            'sholat'  => 'required|array',
        ]);

        $kelasIds = $this->kelasIdsGuru();

        if ($request->kelas_id && !$kelasIds->contains((int) $request->kelas_id)) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $siswaIdsAkses = Siswa::whereIn('kelas_id', $kelasIds)
            ->when($request->kelas_id, function ($query) use ($request) {
                $query->where('kelas_id', $request->kelas_id);
            })
            ->pluck('id');

        foreach ($request->sholat as $siswa_id => $data) {
            if (!$siswaIdsAkses->contains((int) $siswa_id)) {
                abort(403, 'Anda tidak memiliki akses untuk menyimpan data siswa ini.');
            }

            MonitoringSholat::updateOrCreate(
    [
        'siswa_id' => $siswa_id,
        'tanggal'  => $request->tanggal,
        'sumber'   => 'guru',
    ],
    [
        'subuh'      => 0,
        'dzuhur'     => isset($data['dzuhur']) ? 1 : 0,
        'ashar'      => isset($data['ashar']) ? 1 : 0,
        'maghrib'    => 0,
        'isya'       => 0,
        'keterangan' => $data['keterangan'] ?? null,
    ]
);
        }

        return redirect()
            ->route('monitoring-sholat.index', [
                'kelas_id' => $request->kelas_id,
                'tanggal' => $request->tanggal,
            ])
            ->with('success', 'Monitoring sholat berhasil disimpan!');
    }

    public function riwayat(Request $request)
    {
        $kelasIds = $this->kelasIdsGuru();

        $kelas = auth()->user()
            ->kelasDiampu()
            ->orderBy('nama_kelas')
            ->get();

        $kelas_id = $request->kelas_id;
        $selectedBulan = $request->bulan ?? now()->month;
        $selectedTahun = $request->tahun ?? now()->year;
        $selectedTanggal = $request->tanggal ?? now()->toDateString();

        if ($kelas_id && !$kelasIds->contains((int) $kelas_id)) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $tanggalBulan = \Carbon\Carbon::createFromDate($selectedTahun, $selectedBulan, 1);

        $awalBulan = $tanggalBulan->copy()->startOfMonth();
        $akhirBulan = $tanggalBulan->copy()->endOfMonth();

        $queryDasar = MonitoringSholat::with(['siswa.kelas'])
            ->whereHas('siswa', function ($q) use ($kelasIds, $kelas_id) {
                $q->whereIn('kelas_id', $kelasIds);

                if ($kelas_id) {
                    $q->where('kelas_id', $kelas_id);
                }
            });

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

        $dataBulanMentah = (clone $queryDasar)
            ->whereBetween('tanggal', [
                $awalBulan->toDateString(),
                $akhirBulan->toDateString()
            ])
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d');
            });

        $dataBulan = $dataBulanMentah->map(function ($items) use ($gabungkanMonitoring) {
            return $gabungkanMonitoring($items);
        });

        $calendarDays = collect();

        for ($day = 1; $day <= $akhirBulan->day; $day++) {
            $tanggalKey = \Carbon\Carbon::createFromDate($selectedTahun, $selectedBulan, $day)->format('Y-m-d');
            $items = $dataBulan[$tanggalKey] ?? collect();

            $totalData = $items->count();

            $totalLengkap = $items->filter(function ($item) {
                return $item->subuh
                    && $item->dzuhur
                    && $item->ashar
                    && $item->maghrib
                    && $item->isya;
            })->count();

            $totalBelumLengkap = $totalData - $totalLengkap;

            $calendarDays->push([
                'tanggal' => $tanggalKey,
                'hari' => $day,
                'total_data' => $totalData,
                'total_lengkap' => $totalLengkap,
                'total_belum_lengkap' => $totalBelumLengkap,
                'is_selected' => $selectedTanggal == $tanggalKey,
                'is_today' => now()->toDateString() == $tanggalKey,
            ]);
        }

        $riwayatTanggalMentah = (clone $queryDasar)
            ->whereDate('tanggal', $selectedTanggal)
            ->orderBy('sumber', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $riwayatTanggal = $gabungkanMonitoring($riwayatTanggalMentah);

        $daftarBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $daftarTahun = range(now()->year - 2, now()->year + 1);

        return view('guru.monitoring-sholat.riwayat', compact(
            'kelas',
            'kelas_id',
            'selectedBulan',
            'selectedTahun',
            'selectedTanggal',
            'tanggalBulan',
            'calendarDays',
            'riwayatTanggal',
            'daftarBulan',
            'daftarTahun'
        ));
    }
}
