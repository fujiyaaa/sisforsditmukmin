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

        // Untuk daftar siswa bagian input laporan
        $siswas = Siswa::with('kelas')
            ->when($request->kelas_id, function ($query) use ($request) {
                $query->where('kelas_id', $request->kelas_id);
            })
            ->get();

        // Untuk dropdown siswa di filter riwayat
        $filterSiswas = Siswa::with('kelas')
            ->when($request->filter_kelas_id, function ($query) use ($request) {
                $query->where('kelas_id', $request->filter_kelas_id);
            })
            ->orderBy('nama')
            ->get();

        // Untuk riwayat laporan
        $laporans = LaporanSiswa::with(['siswa.kelas'])
            ->when($request->filter_kelas_id, function ($query) use ($request) {
                $query->whereHas('siswa', function ($q) use ($request) {
                    $q->where('kelas_id', $request->filter_kelas_id);
                });
            })
            ->when($request->filter_siswa_id, function ($query) use ($request) {
                $query->where('siswa_id', $request->filter_siswa_id);
            })
            ->when($request->filter_jenis, function ($query) use ($request) {
                $query->where('jenis', $request->filter_jenis);
            })
            ->latest()
            ->get();

        return view('guru.laporan.index', compact(
            'kelas',
            'siswas',
            'laporans',
            'filterSiswas'
        ));
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
        'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $sertifikatPath = null;

    if ($request->jenis === 'prestasi' && $request->hasFile('lampiran')) {
        $sertifikatPath = $request->file('lampiran')->store('lampiran-prestasi', 'public');
    }

    LaporanSiswa::create([
        'siswa_id' => $siswa->id,
        'jenis' => $request->jenis,
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'tanggal' => $request->tanggal,
        'tingkat' => $request->tingkat,
        'catatan' => $request->catatan,
        'sertifikat' => $sertifikatPath,
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
