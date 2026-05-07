<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\Kelas;

class SiswaController extends Controller
{
    // ADMIN
    public function index()
    {
        $data = Siswa::with('kelas')->get();
        $kelas = Kelas::all();

        return view('admin.siswa.index', compact('data', 'kelas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'kelas_id' => 'required',
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect('/admin/siswa')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    // GURU
    public function listGuru()
    {
        $data = Siswa::with('kelas')->get();

        return view('guru.siswa.index', compact('data'));
    }
}
