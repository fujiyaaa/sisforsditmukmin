<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Monitoring;
use Illuminate\Support\Facades\Auth;

class OrangTuaController extends Controller
{
    public function monitoring()
    {
       $siswa = Siswa::first();

        if (!$siswa) {
            return back()->with('error', 'Data siswa tidak ditemukan');
        }

        $monitorings = Monitoring::where('siswa_id', $siswa->id)
                        ->latest()
                        ->take(10)
                        ->get();

        $totalSetoran = Monitoring::where('siswa_id', $siswa->id)->count();

        $totalTahfidz = Monitoring::where('siswa_id', $siswa->id)
                        ->where('jenis', 'tahfidz')
                        ->count();

        $totalTilawah = Monitoring::where('siswa_id', $siswa->id)
                        ->where('jenis', 'tilawah')
                        ->count();

        $rataNilai = Monitoring::where('siswa_id', $siswa->id)
                        ->avg('nilai');

        return view('orangtua.monitoring', compact(
            'siswa',
            'monitorings',
            'totalSetoran',
            'totalTahfidz',
            'totalTilawah',
            'rataNilai'
        ));
    }
}