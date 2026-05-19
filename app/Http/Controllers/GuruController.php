<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        $guru = User::where('role', 'guru')->get();

        return view('admin.guru.index', compact('guru'));
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        return redirect('/admin/guru')->with('success', 'Guru berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $guru = User::findOrFail($id);

        $guru->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->password) {
            $guru->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect('/admin/guru')->with('success', 'Guru berhasil diubah');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect('/admin/guru')->with('success', 'Guru berhasil dihapus');
    }
}
