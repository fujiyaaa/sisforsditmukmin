<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\MonitoringSholat;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrangTuaSholatController extends Controller
{
    public function index(Request $request)
{
    $siswa = Siswa::with('kelas')
        ->where('orangtua_id', Auth::id())
        ->first();

    if (!$siswa) {
        return redirect()->route('orangtua.dashboard')
            ->with('error', 'Akun orang tua belum terhubung dengan siswa.');
    }

    $tanggal = $request->tanggal ?? now()->toDateString();

    $isWeekend = Carbon::parse($tanggal)->isWeekend();

    $isHariLibur = HariLibur::whereDate('tanggal', $tanggal)->exists();

    $isLibur = $isWeekend || $isHariLibur;

   $inputGuruHariIni = MonitoringSholat::where('siswa_id', $siswa->id)
    ->whereDate('tanggal', $tanggal)
    ->where('sumber', 'guru')
    ->where(function ($query) {
        $query->where('dzuhur', 1)
              ->orWhere('ashar', 1);
    })
    ->first();

$adaInputGuru = $inputGuruHariIni ? true : false;

    $monitoringHariIni = MonitoringSholat::where('siswa_id', $siswa->id)
        ->whereDate('tanggal', $tanggal)
        ->get();

    $rekapHariIni = (object) [
        'subuh' => $monitoringHariIni->contains(fn ($item) => (int) $item->subuh === 1),
        'dzuhur' => $monitoringHariIni->contains(fn ($item) => (int) $item->dzuhur === 1),
        'ashar' => $monitoringHariIni->contains(fn ($item) => (int) $item->ashar === 1),
        'maghrib' => $monitoringHariIni->contains(fn ($item) => (int) $item->maghrib === 1),
        'isya' => $monitoringHariIni->contains(fn ($item) => (int) $item->isya === 1),

        'keterangan' => $monitoringHariIni
            ->pluck('keterangan')
            ->filter()
            ->unique()
            ->implode(', '),
    ];

    $monitoringSholats = MonitoringSholat::where('siswa_id', $siswa->id)
        ->with(['siswa.kelas'])
        ->orderBy('tanggal', 'desc')
        ->orderBy('sumber', 'asc')
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('Y-m-d');
        });

    return view('orangtua.ibadah-sholat.index', compact(
        'siswa',
        'tanggal',
        'isLibur',
        'adaInputGuru',
        'inputGuruHariIni',
        'rekapHariIni',
        'monitoringSholats'
    ));
}
   public function store(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'keterangan' => 'nullable|string|max:255',
    ], [
        'tanggal.required' => 'Tanggal wajib diisi',
    ]);

    $siswa = Siswa::where('orangtua_id', Auth::id())
        ->first();

    if (!$siswa) {
        return redirect()->route('orangtua.dashboard')
            ->with('error', 'Akun orang tua belum terhubung dengan siswa.');
    }

    $isWeekend = Carbon::parse($request->tanggal)->isWeekend();

    $isHariLibur = HariLibur::whereDate('tanggal', $request->tanggal)->exists();

    $isLibur = $isWeekend || $isHariLibur;

    $inputGuruHariIni = MonitoringSholat::where('siswa_id', $siswa->id)
    ->whereDate('tanggal', $request->tanggal)
    ->where('sumber', 'guru')
    ->where(function ($query) {
        $query->where('dzuhur', 1)
              ->orWhere('ashar', 1);
    })
    ->first();

$adaInputGuru = $inputGuruHariIni ? true : false;

    /*
     * Dzuhur dan Ashar dikunci hanya jika:
     * - bukan hari libur
     * - guru sudah input
     *
     * Kalau guru belum input, orang tua boleh input semua.
     */
    $disableDzuhurAshar = !$isLibur && $adaInputGuru;

    MonitoringSholat::updateOrCreate(
        [
            'siswa_id' => $siswa->id,
            'tanggal'  => $request->tanggal,
            'sumber'   => 'orangtua',
        ],
        [
            'subuh'      => $request->has('subuh') ? 1 : 0,

            'dzuhur'     => $disableDzuhurAshar
                ? (int) $inputGuruHariIni->dzuhur
                : ($request->has('dzuhur') ? 1 : 0),

            'ashar'      => $disableDzuhurAshar
                ? (int) $inputGuruHariIni->ashar
                : ($request->has('ashar') ? 1 : 0),

            'maghrib'    => $request->has('maghrib') ? 1 : 0,
            'isya'       => $request->has('isya') ? 1 : 0,
            'keterangan' => $request->keterangan,
        ]
    );

    return redirect()
        ->route('orangtua.ibadah-sholat.index', [
            'tanggal' => $request->tanggal,
        ])
        ->with('success', 'Monitoring sholat berhasil disimpan.');
}

    public function riwayat()
    {
        return redirect()->route('orangtua.ibadah-sholat.riwayat-kalender');
    }

    public function riwayatKalender(Request $request)
    {
        $siswa = Siswa::with('kelas')
            ->where('orangtua_id', Auth::id())
            ->first();

        if (!$siswa) {
            return redirect()->route('orangtua.dashboard')
                ->with('error', 'Akun orang tua belum terhubung dengan siswa.');
        }

        $bulan = $request->bulan ?? now()->format('Y-m');

        $tanggalAwal = Carbon::parse($bulan . '-01')->startOfMonth();
        $tanggalAkhir = Carbon::parse($bulan . '-01')->endOfMonth();

        $monitoring = MonitoringSholat::where('siswa_id', $siswa->id)
            ->whereBetween('tanggal', [
                $tanggalAwal->toDateString(),
                $tanggalAkhir->toDateString()
            ])
            ->orderBy('tanggal', 'asc')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('Y-m-d');
            });

        $hariDalamBulan = [];

        $tanggal = $tanggalAwal->copy();

        while ($tanggal <= $tanggalAkhir) {
            $key = $tanggal->format('Y-m-d');

            $dataTanggal = $monitoring->get($key);

            $rekap = null;
            $jumlahSholat = 0;
            $status = null;

            if ($dataTanggal && $dataTanggal->count() > 0) {
                $rekap = [
                    'subuh' => $dataTanggal->contains(fn ($item) => (int) $item->subuh === 1),
                    'dzuhur' => $dataTanggal->contains(fn ($item) => (int) $item->dzuhur === 1),
                    'ashar' => $dataTanggal->contains(fn ($item) => (int) $item->ashar === 1),
                    'maghrib' => $dataTanggal->contains(fn ($item) => (int) $item->maghrib === 1),
                    'isya' => $dataTanggal->contains(fn ($item) => (int) $item->isya === 1),
                ];

                $jumlahSholat =
                    ($rekap['subuh'] ? 1 : 0) +
                    ($rekap['dzuhur'] ? 1 : 0) +
                    ($rekap['ashar'] ? 1 : 0) +
                    ($rekap['maghrib'] ? 1 : 0) +
                    ($rekap['isya'] ? 1 : 0);

                $status = $jumlahSholat == 5 ? 'lengkap' : 'belum_lengkap';
            }

            $hariDalamBulan[] = [
                'tanggal' => $tanggal->copy(),
                'key' => $key,
                'rekap' => $rekap,
                'status' => $status,
                'jumlahSholat' => $jumlahSholat,
            ];

            $tanggal->addDay();
        }

        $bulanSebelumnya = $tanggalAwal->copy()->subMonth()->format('Y-m');
        $bulanBerikutnya = $tanggalAwal->copy()->addMonth()->format('Y-m');

        return view('orangtua.ibadah-sholat.riwayat-kalender', compact(
            'siswa',
            'bulan',
            'tanggalAwal',
            'hariDalamBulan',
            'bulanSebelumnya',
            'bulanBerikutnya'
        ));
    }
}
