<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\MonitoringSholat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrangTuaSholatController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('kelas')
            ->where('orangtua_id', Auth::id())
            ->firstOrFail();

        $monitoringSholats = MonitoringSholat::where('siswa_id', $siswa->id)
            ->with(['siswa.kelas'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('sumber', 'asc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('tanggal');

        return view('orangtua.ibadah-sholat.index', compact(
            'siswa',
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
            ->firstOrFail();

        MonitoringSholat::updateOrCreate(
            [
                'siswa_id' => $siswa->id,
                'tanggal'  => $request->tanggal,
                'sumber'   => 'orangtua',
            ],
            [
                'subuh'      => $request->has('subuh') ? 1 : 0,
                'dzuhur'     => $request->has('dzuhur') ? 1 : 0,
                'ashar'      => $request->has('ashar') ? 1 : 0,
                'maghrib'    => $request->has('maghrib') ? 1 : 0,
                'isya'       => $request->has('isya') ? 1 : 0,
                'keterangan' => $request->keterangan,
            ]
        );

        return back()->with('success', 'Monitoring sholat berhasil disimpan');
    }
    public function riwayatKalender(Request $request)
{
    $siswa = Siswa::with('kelas')
        ->where('orangtua_id', Auth::id())
        ->firstOrFail();

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
                'subuh' => $dataTanggal->contains(fn ($item) => $item->subuh == 1),
                'dzuhur' => $dataTanggal->contains(fn ($item) => $item->dzuhur == 1),
                'ashar' => $dataTanggal->contains(fn ($item) => $item->ashar == 1),
                'maghrib' => $dataTanggal->contains(fn ($item) => $item->maghrib == 1),
                'isya' => $dataTanggal->contains(fn ($item) => $item->isya == 1),
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
