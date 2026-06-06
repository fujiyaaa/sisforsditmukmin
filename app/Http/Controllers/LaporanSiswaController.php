<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\LaporanSiswa;

class LaporanSiswaController extends Controller
{
    private function kelasIdsGuru()
    {
        return auth()->user()
            ->kelasDiampu()
            ->pluck('kelas.id');
    }

    public function index(Request $request)
    {
        $kelasIds = $this->kelasIdsGuru();

        $kelas = auth()->user()
            ->kelasDiampu()
            ->orderBy('nama_kelas')
            ->get();

        if ($request->kelas_id && !$kelasIds->contains((int) $request->kelas_id)) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        if ($request->filter_kelas_id && !$kelasIds->contains((int) $request->filter_kelas_id)) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $siswas = Siswa::with('kelas')
            ->whereIn('kelas_id', $kelasIds)
            ->when($request->kelas_id, function ($query) use ($request) {
                $query->where('kelas_id', $request->kelas_id);
            })
            ->orderBy('nama')
            ->get();

        $filterSiswas = Siswa::with('kelas')
            ->whereIn('kelas_id', $kelasIds)
            ->when($request->filter_kelas_id, function ($query) use ($request) {
                $query->where('kelas_id', $request->filter_kelas_id);
            })
            ->orderBy('nama')
            ->get();

        $laporans = LaporanSiswa::with(['siswa.kelas'])
            ->whereHas('siswa', function ($query) use ($kelasIds, $request) {
                $query->whereIn('kelas_id', $kelasIds);

                if ($request->filter_kelas_id) {
                    $query->where('kelas_id', $request->filter_kelas_id);
                }
            })
            ->when($request->filter_siswa_id, function ($query) use ($request, $kelasIds) {
                $siswaValid = Siswa::where('id', $request->filter_siswa_id)
                    ->whereIn('kelas_id', $kelasIds)
                    ->exists();

                if (!$siswaValid) {
                    abort(403, 'Anda tidak memiliki akses ke siswa ini.');
                }

                $query->where('siswa_id', $request->filter_siswa_id);
            })
            ->when($request->filter_jenis, function ($query) use ($request) {
                $query->where('jenis', $request->filter_jenis);
            })
            ->latest()
            ->get();

        // Untuk tombol View di tabel Daftar Siswa
        // Data ini dikelompokkan berdasarkan siswa_id
        $laporanSiswa = LaporanSiswa::with(['siswa.kelas'])
            ->whereHas('siswa', function ($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })
            ->latest()
            ->get()
            ->groupBy('siswa_id');

        return view('guru.laporan.index', compact(
            'kelas',
            'siswas',
            'laporans',
            'filterSiswas',
            'laporanSiswa'
        ));
    }

    public function create($nis)
    {
        $siswa = Siswa::with('kelas')
            ->where('nis', $nis)
            ->whereIn('kelas_id', $this->kelasIdsGuru())
            ->firstOrFail();

        return view('guru.laporan.create', compact('siswa'));
    }

    public function store(Request $request, $nis)
    {
        $siswa = Siswa::where('nis', $nis)
            ->whereIn('kelas_id', $this->kelasIdsGuru())
            ->firstOrFail();

        $request->validate([
            'jenis' => 'required|in:prestasi,pelanggaran,informasi',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'tingkat' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $sertifikatPath = null;

        if ($request->jenis === 'prestasi' && $request->hasFile('lampiran')) {
            $sertifikatPath = $request->file('lampiran')->store('lampiran-prestasi', 'public');
        }

        LaporanSiswa::create([
            'siswa_id' => $siswa->id,
            'jenis' => $request->jenis,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'tingkat' => $request->tingkat,
            'catatan' => $request->catatan,
            'sertifikat' => $sertifikatPath,
        ]);

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan prestasi/pelanggaran berhasil disimpan.');
    }

    public function adminIndex(Request $request)
    {
        $kelas = Kelas::all();

        $siswas = Siswa::with('kelas')
            ->when($request->kelas_id, function ($query) use ($request) {
                $query->where('kelas_id', $request->kelas_id);
            })
            ->orderBy('nama')
            ->get();

        $laporans = LaporanSiswa::with(['siswa.kelas'])
            ->latest()
            ->get();

        $laporanSiswa = LaporanSiswa::with(['siswa.kelas'])
            ->latest()
            ->get()
            ->groupBy('siswa_id');

        return view('admin.laporan.index', compact(
            'kelas',
            'siswas',
            'laporans',
            'laporanSiswa'
        ));
    }

    public function adminCreate($nis)
    {
        $siswa = Siswa::with('kelas')
            ->where('nis', $nis)
            ->firstOrFail();

        return view('admin.laporan.create', compact('siswa'));
    }

    public function adminStore(Request $request, $nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();

        $request->validate([
            'jenis' => 'required|in:prestasi,pelanggaran,informasi',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'tingkat' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $sertifikatPath = null;

        if ($request->jenis === 'prestasi' && $request->hasFile('lampiran')) {
            $sertifikatPath = $request->file('lampiran')->store('lampiran-prestasi', 'public');
        }

        LaporanSiswa::create([
            'siswa_id' => $siswa->id,
            'jenis' => $request->jenis,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'tingkat' => $request->tingkat,
            'catatan' => $request->catatan,
            'sertifikat' => $sertifikatPath,
        ]);

        return redirect()
            ->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil disimpan oleh admin.');
    }
}
