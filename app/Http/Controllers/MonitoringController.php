<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\Siswa;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
   public function store(Request $request)
   {
    $validated = $request->validate([
        'siswa_id'   => 'required|exists:siswas,id',
        'surah'      => 'required|string|max:100',
        'juz'        => 'required|integer|min:1|max:30',
        'jenis'      => 'required|in:tahfidz,murajaah,tilawah',
        'nilai'      => 'nullable|integer|min:0|max:100',
        'keterangan' => 'nullable|string|max:255',
    ], [
        // custom pesan biar lebih user friendly
        'surah.required' => 'Surah wajib diisi',
        'juz.required' => 'Juz wajib diisi',
        'jenis.required' => 'Pilih jenis setoran',
        'nilai.max' => 'Nilai maksimal 100',
        'siswa_id.exists' => 'Siswa tidak valid'
    ]);

    Monitoring::create([
        ...$validated,
        'tanggal' => now()
    ]);

    return redirect('/guru/siswa')->with('success', 'Data berhasil disimpan');
    }
    
    public function create($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('guru.monitoring.create', compact('siswa'));
    }
}
