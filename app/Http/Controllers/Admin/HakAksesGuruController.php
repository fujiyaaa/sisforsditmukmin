<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class HakAksesGuruController extends Controller
{
    public function index()
    {
        $gurus = User::with('kelasDiampu')
            ->where('role', 'guru')
            ->orderBy('name')
            ->get();

        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.hak-akses-guru.index', compact('gurus', 'kelas'));
    }

    public function update(Request $request, User $guru)
    {
        $request->validate([
            'kelas_id' => ['nullable', 'array'],
            'kelas_id.*' => ['exists:kelas,id'],
        ]);

        if ($guru->role !== 'guru') {
            return back()->withErrors([
                'guru' => 'User ini bukan guru.',
            ]);
        }

        $guru->kelasDiampu()->sync($request->kelas_id ?? []);

        return back()->with('success', 'Hak akses kelas guru berhasil diperbarui.');
    }
}
