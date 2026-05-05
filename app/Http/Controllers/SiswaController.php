<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // ADMIN
    public function index()
    {
        $data = Siswa::all();
        return view('admin.siswa.index', compact('data'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        Siswa::create($request->all());
        return redirect('/admin/siswa');
    }

    // GURU (lihat siswa)
    public function listGuru()
    {
        $data = Siswa::all();
        return view('guru.siswa.index', compact('data'));
    }
}
