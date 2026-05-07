<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\Siswa;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
   public function store(Request $request, $nis)
{
    $siswa = Siswa::where('nis', $nis)->firstOrFail();

    $validated = $request->validate([
        'surah'      => 'required|string|max:100',
        'juz'        => 'required|integer|min:1|max:30',
        'jenis'      => 'required|in:tahfidz,murajaah,tilawah',
        'nilai'      => 'nullable|integer|min:0|max:100',
        'keterangan' => 'nullable|string|max:255',
    ], [
        'surah.required' => 'Surah wajib diisi',
        'juz.required' => 'Juz wajib diisi',
        'jenis.required' => 'Pilih jenis setoran',
        'nilai.max' => 'Nilai maksimal 100',
    ]);

    Monitoring::create([
        'siswa_id'   => $siswa->id,
        'surah'      => $validated['surah'],
        'juz'        => $validated['juz'],
        'jenis'      => $validated['jenis'],
        'nilai'      => $validated['nilai'] ?? null,
        'keterangan' => $validated['keterangan'] ?? null,
        'tanggal'    => now()
    ]);

    return redirect('/guru/siswa')
        ->with('success', 'Data berhasil disimpan');
}

    public function create($nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();

        return view('guru.monitoring.create', compact('siswa'));
    }

    public function index()
        {
            $siswas = Siswa::all();

            return view('guru.monitoring.index', compact('siswas'));
        }
}
