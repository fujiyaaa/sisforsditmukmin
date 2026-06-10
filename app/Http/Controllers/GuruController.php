<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index()
    {
        $guru = User::where('role', 'guru')
            ->with('kelasDiampu')
            ->orderBy('name')
            ->get();

        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.guru.index', compact('guru', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:users,nip',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'required|string|min:6',
            'kelas_ids' => 'nullable|array',
            'kelas_ids.*' => 'exists:kelas,id',
        ]);

        DB::transaction(function () use ($request) {

            $emailOtomatis = 'guru_' . $request->nip . '@simukmin.local';

            $guru = User::create([
                'name' => $request->name,
                'email' => $emailOtomatis,
                'nip' => $request->nip,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 'guru',
                'must_change_password' => true,
            ]);

            $guru->kelasDiampu()->sync($request->kelas_ids ?? []);
        });

        return redirect('/admin/guru')
            ->with('success', 'Guru berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:users,nip,' . $guru->id,
            'phone' => 'required|string|max:20|unique:users,phone,' . $guru->id,
            'password' => 'nullable|string|min:6',
            'kelas_ids' => 'nullable|array',
            'kelas_ids.*' => 'exists:kelas,id',
        ]);

        DB::transaction(function () use ($request, $guru) {

            $emailOtomatis = 'guru_' . $request->nip . '@simukmin.local';

            $data = [
                'name' => $request->name,
                'email' => $emailOtomatis,
                'nip' => $request->nip,
                'phone' => $request->phone,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
                $data['must_change_password'] = true;
            }

            $guru->update($data);

            $guru->kelasDiampu()->sync($request->kelas_ids ?? []);
        });

        return redirect('/admin/guru')
            ->with('success', 'Guru berhasil diubah');
    }

    public function destroy($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);

        DB::transaction(function () use ($guru) {
            $guru->kelasDiampu()->detach();
            $guru->delete();
        });

        return redirect('/admin/guru')
            ->with('success', 'Guru berhasil dihapus');
    }
}
