<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::all();

        $query = Siswa::with('kelas');

        // FILTER KELAS
        if ($request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswas = $query->get()
            ->groupBy('kelas.nama_kelas');

        return view('guru.setoran.index', compact(
            'siswas',
            'kelas'
        ));
    }

    public function create($nis)
    {
        $siswa = Siswa::with('kelas')
            ->where('nis', $nis)
            ->firstOrFail();

        return view('guru.setoran.create', compact('siswa'));
    }

    public function store(Request $request, $nis)
{
    $siswa = Siswa::where('nis', $nis)->firstOrFail();

    $validated = $request->validate([
        'surah'      => 'required|string|max:100',
        'juz'        => 'required|integer|min:1|max:30',
        'jenis'      => 'required|in:tahfidz,murajaah,tilawah',
        'nilai'      => 'nullable|integer|min:0|max:100',
        'keterangan' => 'nullable|string|max:500',   // diperbesar sedikit
    ], [
        'surah.required' => 'Surah wajib diisi',
        'juz.required'   => 'Juz wajib diisi',
        'jenis.required' => 'Pilih jenis setoran',
        'nilai.max'      => 'Nilai maksimal 100',
    ]);

    Monitoring::create([
        'siswa_id'   => $siswa->id,
        'surah'      => $validated['surah'],
        'juz'        => $validated['juz'],
        'jenis'      => $validated['jenis'],
        'nilai'      => $validated['nilai'] ?? null,
        'keterangan' => $validated['keterangan'] ?? null,
        'tanggal'    => now()->toDateString(),
    ]);

    return back()->with('success', 'Setoran berhasil disimpan! ✅');
    }
    public function riwayat(Request $request)
{
    $kelas = Kelas::all();

    $query = Monitoring::with('siswa.kelas')
        ->latest('tanggal')
        ->latest();

    if ($request->kelas_id) {
        $query->whereHas('siswa', function ($q) use ($request) {
            $q->where('kelas_id', $request->kelas_id);
        });
    }

    if ($request->tanggal) {
        $query->whereDate('tanggal', $request->tanggal);
    }

    if ($request->jenis) {
        $query->where('jenis', $request->jenis);
    }

    $riwayat = $query->get();

    return view('guru.setoran.riwayat', compact('riwayat', 'kelas'));
}
}
