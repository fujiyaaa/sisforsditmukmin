<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HariLibur;
use Illuminate\Http\Request;

class HariLiburController extends Controller
{
    public function index()
    {
        $hariLiburs = HariLibur::orderBy('tanggal', 'desc')->get();

        return view('admin.hari-libur.index', compact('hariLiburs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:hari_liburs,tanggal',
            'nama_libur' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'tanggal.required' => 'Tanggal libur wajib diisi.',
            'tanggal.unique' => 'Tanggal libur ini sudah ada.',
            'nama_libur.required' => 'Nama libur wajib diisi.',
        ]);

        HariLibur::create([
            'tanggal' => $request->tanggal,
            'nama_libur' => $request->nama_libur,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Hari libur berhasil ditambahkan.');
    }

    public function destroy(HariLibur $hariLibur)
    {
        $hariLibur->delete();

        return back()->with('success', 'Hari libur berhasil dihapus.');
    }
}
