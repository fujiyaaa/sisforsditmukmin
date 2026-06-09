<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Monitoring;

class AdminSetoranController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        $siswas = Siswa::with('kelas')
            ->when($request->kelas_id, function ($query) use ($request) {
                $query->where('kelas_id', $request->kelas_id);
            })
            ->orderBy('kelas_id')
            ->orderBy('nama')
            ->get()
            ->groupBy(function ($siswa) {
                return $siswa->kelas->nama_kelas ?? 'Tanpa Kelas';
            });

        return view('admin.setoran.index', compact('kelas', 'siswas'));
    }

    public function create($nis)
    {
        $siswa = Siswa::with('kelas')
            ->where('nis', $nis)
            ->firstOrFail();

        return view('admin.setoran.create', compact('siswa'));
    }

    public function store(Request $request, $nis)
    {
        $siswa = Siswa::where('nis', $nis)
            ->firstOrFail();

        $request->validate([
            'tanggal' => 'required|date',
            'surah' => 'required|string|max:255',
            'juz' => 'required|integer|min:1|max:30',
            'jenis' => 'required|in:tilawah,tahfidz,murajaah',
            'nilai' => 'required|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        Monitoring::create([
            'siswa_id' => $siswa->id,
            'tanggal' => $request->tanggal,
            'surah' => $request->surah,
            'juz' => $request->juz,
            'jenis' => $request->jenis,
            'nilai' => $request->nilai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('admin.setoran.index')
            ->with('success', 'Setoran Quran berhasil disimpan oleh admin.');
    }

    public function riwayat(Request $request)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        $siswas = Siswa::with('kelas')
            ->when($request->kelas_id, function ($query) use ($request) {
                $query->where('kelas_id', $request->kelas_id);
            })
            ->orderBy('nama')
            ->get();

        $setorans = Monitoring::with('siswa.kelas')
            ->when($request->kelas_id, function ($query) use ($request) {
                $query->whereHas('siswa', function ($q) use ($request) {
                    $q->where('kelas_id', $request->kelas_id);
                });
            })
            ->when($request->siswa_id, function ($query) use ($request) {
                $query->where('siswa_id', $request->siswa_id);
            })
            ->when($request->jenis, function ($query) use ($request) {
                $query->where('jenis', $request->jenis);
            })
            ->when($request->tanggal, function ($query) use ($request) {
                $query->whereDate('tanggal', $request->tanggal);
            })
            ->latest('tanggal')
            ->get();

        return view('admin.setoran.riwayat', compact(
            'kelas',
            'siswas',
            'setorans'
        ));
    }
}
