<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\LaporanSiswa;

class LaporanSiswaController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::all();

        $siswas = Siswa::with('kelas')
            ->when($request->kelas_id, function ($query) use ($request) {
                $query->where('kelas_id', $request->kelas_id);
            })
            ->get();

        $laporans = LaporanSiswa::with(['siswa.kelas'])
            ->latest()
            ->get();

        return view('guru.laporan.index', compact('kelas', 'siswas', 'laporans'));
    }

    public function create($nis)
    {
        $siswa = Siswa::with('kelas')
            ->where('nis', $nis)
            ->firstOrFail();

        return view('guru.laporan.create', compact('siswa'));
    }

    public function store(Request $request, $nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();

        $request->validate([
            'jenis' => 'required|in:prestasi,pelanggaran,informasi',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'tingkat' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        LaporanSiswa::create([
            'siswa_id' => $siswa->id,
            'jenis' => $request->jenis,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'tingkat' => $request->tingkat,
            'catatan' => $request->catatan,
        ]);

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan prestasi/pelanggaran berhasil disimpan.');
    }
    public function adminIndex(Request $request)
{
    $kelas = Kelas::all();

    $siswas = Siswa::with('kelas')
        ->when($request->kelas_id, function ($query) use ($request) {
            $query->where('kelas_id', $request->kelas_id);
        })
        ->get();

    $laporans = LaporanSiswa::with(['siswa.kelas'])
        ->latest()
        ->get();

    return view('admin.laporan.index', compact('kelas', 'siswas', 'laporans'));
}

public function adminCreate($nis)
{
    $siswa = Siswa::with('kelas')
        ->where('nis', $nis)
        ->firstOrFail();

    return view('admin.laporan.create', compact('siswa'));
}

public function adminStore(Request $request, $nis)
{
    $siswa = Siswa::where('nis', $nis)->firstOrFail();

    $request->validate([
        'jenis' => 'required|in:prestasi,pelanggaran,informasi',
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'tanggal' => 'required|date',
        'tingkat' => 'required|string|max:255',
        'catatan' => 'nullable|string',
    ]);

    LaporanSiswa::create([
        'siswa_id' => $siswa->id,
        'jenis' => $request->jenis,
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'tanggal' => $request->tanggal,
        'tingkat' => $request->tingkat,
        'catatan' => $request->catatan,
    ]);

    return redirect()
        ->route('admin.laporan.index')
        ->with('success', 'Laporan berhasil disimpan oleh admin.');
}
}
