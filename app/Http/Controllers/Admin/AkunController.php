<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $users = User::with('siswa')
            ->orderByRaw("FIELD(role, 'admin', 'guru', 'orangtua')")
            ->orderBy('name')
            ->get();

        $siswas = Siswa::with('kelas')
            ->orderBy('nama')
            ->get();

        return view('admin.akun.index', compact('users', 'siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,guru,orangtua',
            'password' => 'required|string|min:6',

            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'nip' => 'nullable|string|max:50|unique:users,nip',
            'siswa_id' => 'nullable|exists:siswas,id',
        ]);

        if ($request->role === 'admin' && !$request->email) {
            return back()
                ->withErrors(['email' => 'Email wajib diisi untuk akun admin.'])
                ->withInput();
        }

        if ($request->role === 'guru') {
            if (!$request->nip) {
                return back()
                    ->withErrors(['nip' => 'NIP wajib diisi untuk akun guru.'])
                    ->withInput();
            }

            if (!$request->phone) {
                return back()
                    ->withErrors(['phone' => 'Nomor telepon wajib diisi untuk akun guru.'])
                    ->withInput();
            }
        }

        if ($request->role === 'orangtua') {
            if (!$request->phone) {
                return back()
                    ->withErrors(['phone' => 'Nomor telepon wajib diisi untuk akun orang tua.'])
                    ->withInput();
            }

            if (!$request->siswa_id) {
                return back()
                    ->withErrors(['siswa_id' => 'Siswa wajib dipilih untuk akun orang tua.'])
                    ->withInput();
            }

            $siswa = Siswa::findOrFail($request->siswa_id);

            if ($siswa->orangtua_id) {
                return back()
                    ->withErrors(['siswa_id' => 'Siswa ini sudah terhubung dengan akun orang tua.'])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($request) {
            if ($request->role === 'admin') {
                $email = $request->email;
            } elseif ($request->role === 'guru') {
                $email = 'guru_' . $request->nip . '@simukmin.local';
            } else {
                $phoneClean = preg_replace('/[^0-9]/', '', $request->phone);
                $email = 'ortu_' . $phoneClean . '@simukmin.local';
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $email,
                'phone' => $request->role === 'admin' ? null : $request->phone,
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
        });

        return redirect()
            ->back()
            ->with('success', 'Akun berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
{
    $user = User::with('siswa')->findOrFail($id);

    if ($user->role === 'admin') {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

    } elseif ($user->role === 'guru') {

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'nip' => 'required|string|max:50|unique:users,nip,' . $user->id,
        ]);

        $emailOtomatis = 'guru_' . $request->nip . '@simukmin.local';

        $user->update([
            'name' => $request->name,
            'email' => $emailOtomatis,
            'phone' => $request->phone,
            'nip' => $request->nip,
        ]);

    } elseif ($user->role === 'orangtua') {

    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
        'siswa_id' => 'required|exists:siswas,id',
    ]);

    $siswaBaru = Siswa::findOrFail($request->siswa_id);

    if ($siswaBaru->orangtua_id && $siswaBaru->orangtua_id != $user->id) {
        return back()
            ->withErrors([
                'siswa_id' => 'Siswa ini sudah terhubung dengan akun orang tua lain.',
            ])
            ->withInput();
    }

    DB::transaction(function () use ($user, $request, $siswaBaru) {

        $phoneClean = preg_replace('/[^0-9]/', '', $request->phone);
        $emailOtomatis = 'ortu_' . $phoneClean . '@simukmin.local';

        $user->update([
            'name' => $request->name,
            'email' => $emailOtomatis,
            'phone' => $request->phone,
        ]);

        Siswa::where('orangtua_id', $user->id)
            ->where('id', '!=', $siswaBaru->id)
            ->update([
                'orangtua_id' => null,
            ]);

        $siswaBaru->update([
            'orangtua_id' => $user->id,
        ]);

    });
}

    return redirect()
        ->back()
        ->with('success', 'Data akun berhasil diperbarui.');
}

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->withErrors([
                'akun' => 'Akun yang sedang digunakan tidak bisa dihapus.',
            ]);
        }

        DB::transaction(function () use ($user) {
            if ($user->role === 'orangtua') {
                Siswa::where('orangtua_id', $user->id)->update([
                    'orangtua_id' => null,
                ]);
            }

            if ($user->role === 'guru') {
                $user->kelasDiampu()->detach();
            }

            $user->delete();
        });

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
