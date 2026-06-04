<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\MonitoringSholat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}