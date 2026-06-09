<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
{
    $siswas = \App\Models\Siswa::with('kelas')
        ->orderBy('nama')
        ->get();

    $users = \App\Models\User::with('siswa')
        ->orderBy('role')
        ->orderBy('name')
        ->get();

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

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password_baru' => 'required|string|min:6',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make($request->password_baru),
            'must_change_password' => true,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Password berhasil direset. User wajib mengganti password saat login berikutnya.');
    }
}
