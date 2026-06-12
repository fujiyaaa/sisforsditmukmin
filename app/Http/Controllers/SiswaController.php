<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    public function index()
{
    $kelas = Kelas::orderBy('nama_kelas')->get();

    $siswas = Siswa::with(['kelas', 'orangtua'])
        ->orderBy('nama', 'asc')
        ->get();

    // Untuk form tambah siswa: hanya orang tua yang belum terhubung ke siswa mana pun
    $orangtuasKosong = User::where('role', 'orangtua')
        ->whereDoesntHave('siswa')
        ->orderBy('name')
        ->get();

    // Untuk modal edit: semua orang tua, nanti di Blade difilter
    $orangtuasSemua = User::where('role', 'orangtua')
        ->with('siswa')
        ->orderBy('name')
        ->get();

    return view('admin.siswa.index', compact(
        'kelas',
        'siswas',
        'orangtuasKosong',
        'orangtuasSemua'
    ));
}

   public function store(Request $request)
{
    $request->validate([
        'nis' => 'required|int|max:50|unique:siswas,nis',
        'nama' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:L,P',
        'tempat_lahir' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'alamat' => 'required|string',
        'kelas_id' => 'required|exists:kelas,id',

        'opsi_orangtua' => 'required|in:tanpa,hubungkan,buat_baru',

        'orangtua_id' => [
            'nullable',
            Rule::exists('users', 'id')->where(function ($query) {
                $query->where('role', 'orangtua');
            }),
        ],

        'nama_orangtua' => 'nullable|string|max:255',
        'phone_orangtua' => 'nullable|string|max:20|unique:users,phone',
        'password_orangtua' => 'nullable|string|min:6',
    ]);

    // Kalau pilih hubungkan orang tua lama
    if ($request->opsi_orangtua === 'hubungkan') {
        if (!$request->orangtua_id) {
            return back()
                ->withErrors(['orangtua_id' => 'Pilih akun orang tua yang ingin dihubungkan.'])
                ->withInput();
        }

        $sudahDipakai = Siswa::where('orangtua_id', $request->orangtua_id)->exists();

        if ($sudahDipakai) {
            return back()
                ->withErrors(['orangtua_id' => 'Akun orang tua ini sudah terhubung dengan siswa lain.'])
                ->withInput();
        }
    }

    // Kalau pilih buat akun orang tua baru
    if ($request->opsi_orangtua === 'buat_baru') {
        $request->validate([
            'nama_orangtua' => 'required|string|max:255',
            'phone_orangtua' => 'required|string|max:20|unique:users,phone',
            'password_orangtua' => 'required|string|min:6',
        ]);
    }

    DB::transaction(function () use ($request) {

        $orangtuaId = null;

        // Opsi hubungkan akun orang tua yang sudah ada
        if ($request->opsi_orangtua === 'hubungkan') {
            $orangtuaId = $request->orangtua_id;
        }

        // Opsi buat akun orang tua baru
        if ($request->opsi_orangtua === 'buat_baru') {
            $emailOtomatis = 'ortu_' . $request->nis . '@simukmin.local';

            $orangtua = User::create([
                'name' => $request->nama_orangtua,
                'email' => $emailOtomatis,
                'phone' => $request->phone_orangtua,
                'password' => Hash::make($request->password_orangtua),
                'role' => 'orangtua',
                'must_change_password' => true,
            ]);

            $orangtuaId = $orangtua->id;
        }

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'kelas_id' => $request->kelas_id,
            'orangtua_id' => $orangtuaId,
        ]);
    });

    if ($request->opsi_orangtua === 'buat_baru') {
        $message = 'Data siswa berhasil ditambahkan dan akun orang tua berhasil dibuat.';
    } elseif ($request->opsi_orangtua === 'hubungkan') {
        $message = 'Data siswa berhasil ditambahkan dan berhasil dihubungkan ke akun orang tua.';
    } else {
        $message = 'Data siswa berhasil ditambahkan.';
    }

    return redirect()
        ->back()
        ->with('success', $message);
}

    public function update(Request $request, $id)
{
    $siswa = Siswa::findOrFail($id);

    $request->validate([
        'nis' => 'required|integer|max:50|unique:siswas,nis,' . $siswa->id,
        'nama' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:L,P',
        'tempat_lahir' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'alamat' => 'required|string',
        'kelas_id' => 'required|exists:kelas,id',

        'orangtua_id' => [
            'nullable',
            Rule::exists('users', 'id')->where(function ($query) {
                $query->where('role', 'orangtua');
            }),
        ],
    ]);

    // Cek supaya 1 orang tua tidak bisa dipakai lebih dari 1 siswa
    if ($request->orangtua_id) {
        $sudahDipakai = Siswa::where('orangtua_id', $request->orangtua_id)
            ->where('id', '!=', $siswa->id)
            ->exists();

        if ($sudahDipakai) {
            return back()
                ->withErrors(['orangtua_id' => 'Akun orang tua ini sudah terhubung dengan siswa lain.'])
                ->withInput();
        }
    }

    $siswa->update([
        'nis' => $request->nis,
        'nama' => $request->nama,
        'jenis_kelamin' => $request->jenis_kelamin,
        'tempat_lahir' => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'alamat' => $request->alamat,
        'kelas_id' => $request->kelas_id,
        'orangtua_id' => $request->orangtua_id,
    ]);

    return redirect()
        ->back()
        ->with('success', 'Data siswa berhasil diperbarui.');
}

public function destroy($id)
{
    $siswa = Siswa::findOrFail($id);

    $siswa->delete();

    return redirect()
        ->back()
        ->with('success', 'Data siswa berhasil dihapus.');
}
}
