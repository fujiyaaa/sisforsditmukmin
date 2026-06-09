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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'nullable|string|max:50|unique:users,nip',
            'role' => 'required|in:admin,guru,orangtua',
            'password' => 'required|string|min:6',
            'siswa_id' => 'nullable|exists:siswa,id',
        ]);

        if ($request->role === 'guru' && !$request->nip) {
            return back()
                ->withErrors(['nip' => 'NIP wajib diisi untuk akun guru.'])
                ->withInput();
        }

        if ($request->role === 'orangtua' && !$request->siswa_id) {
            return back()
                ->withErrors(['siswa_id' => 'Siswa wajib dipilih untuk akun orang tua.'])
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->role === 'guru' ? $request->nip : null,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'must_change_password' => true,
        ]);

        if ($request->role === 'orangtua') {
            $siswa = Siswa::findOrFail($request->siswa_id);

            $siswa->update([
                'orangtua_id' => $user->id,
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Akun berhasil dibuat. User wajib mengganti password saat login pertama.');
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
