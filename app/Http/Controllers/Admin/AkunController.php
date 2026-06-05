<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index()
    {
        $users = User::with('siswa')
            ->whereIn('role', ['admin', 'guru', 'orangtua'])
            ->orderBy('role')
            ->orderBy('name')
            ->get();

        $siswas = Siswa::orderBy('nama')->get();

        return view('admin.akun.index', compact('users', 'siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'in:admin,guru,orangtua'],
            'password' => ['required', 'string', 'min:6'],
            'siswa_id' => ['nullable', 'exists:siswas,id'],
        ]);

        if ($request->role === 'orangtua' && !$request->siswa_id) {
            return back()
                ->withErrors(['siswa_id' => 'Akun orang tua wajib dihubungkan dengan siswa.'])
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'must_change_password' => $request->role === 'admin' ? false : true,
            'siswa_id' => $request->role === 'orangtua' ? $request->siswa_id : null,
        ]);

        return back()->with('success', 'Akun berhasil dibuat.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->withErrors([
                'akun' => 'Akun yang sedang digunakan tidak bisa dihapus.',
            ]);
        }

        $user->delete();

        return back()->with('success', 'Akun berhasil dihapus.');
    }
}
