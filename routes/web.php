<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\OrangTuaSholatController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MonitoringSholatController;
use App\Http\Controllers\LaporanSiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\OrangTuaAbsensiController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\HakAksesGuruController;
use App\Http\Controllers\Admin\RekapPersentaseController;
use App\Http\Controllers\Admin\AdminAbsensiController;
use App\Http\Controllers\Admin\AdminSetoranController;
use App\Http\Controllers\Admin\AdminMonitoringSholatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'guru') {
        return redirect()->route('guru.dashboard');
    }

    if ($user->role === 'orangtua') {
        return redirect()->route('orangtua.dashboard');
    }

    return redirect('/');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [ChangePasswordController::class, 'edit'])
        ->name('password.change');

    Route::put('/change-password', [ChangePasswordController::class, 'update'])
        ->name('password.change.update');
});

Route::middleware(['auth', 'must.change.password', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'totalSiswa' => \App\Models\Siswa::count(),
            'totalGuru' => \App\Models\User::where('role', 'guru')->count(),
            'totalKelas' => \App\Models\Kelas::count(),
            'totalLaporan' => \App\Models\LaporanSiswa::count(),

            'aktivitas' => [
                'Data siswa berhasil diperbarui',
                'Data guru berhasil ditambahkan',
                'Laporan prestasi siswa berhasil dibuat',
                'Monitoring ibadah berhasil diperbarui',
            ],
        ]);
    })->name('admin.dashboard');

    Route::get('/siswa', [SiswaController::class, 'index']);
    Route::post('/siswa', [SiswaController::class, 'store']);
    Route::put('/siswa/{id}', [SiswaController::class, 'update']);
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy']);

    Route::get('/kelas', [KelasController::class, 'index']);
    Route::post('/kelas', [KelasController::class, 'store']);
    Route::put('/kelas/{id}', [KelasController::class, 'update']);
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy']);

    Route::get('/guru', [GuruController::class, 'index']);
    Route::post('/guru', [GuruController::class, 'store']);
    Route::put('/guru/{id}', [GuruController::class, 'update']);
    Route::delete('/guru/{id}', [GuruController::class, 'destroy']);

    Route::get('/laporan-prestasi-pelanggaran', [LaporanSiswaController::class, 'adminIndex'])
        ->name('admin.laporan.index');

    Route::get('/laporan-prestasi-pelanggaran/{nis}', [LaporanSiswaController::class, 'adminCreate'])
        ->name('admin.laporan.create');

    Route::post('/laporan-prestasi-pelanggaran/{nis}', [LaporanSiswaController::class, 'adminStore'])
        ->name('admin.laporan.store');
    Route::get('/akun', [AkunController::class, 'index'])
    ->name('admin.akun.index');

    Route::post('/akun', [AkunController::class, 'store'])
        ->name('admin.akun.store');

    Route::delete('/akun/{user}', [AkunController::class, 'destroy'])
        ->name('admin.akun.destroy');

    Route::post('/akun/{id}/reset-password', [AkunController::class, 'resetPassword'])
    ->name('admin.akun.reset-password');
    
    Route::get('/hak-akses-guru', [HakAksesGuruController::class, 'index'])
    ->name('admin.hak-akses-guru.index');

    Route::put('/hak-akses-guru/{guru}', [HakAksesGuruController::class, 'update'])
    ->name('admin.hak-akses-guru.update');

    Route::get('/rekap-persentase', [RekapPersentaseController::class, 'index'])
    ->name('admin.rekap-persentase.index');

    Route::get('/absensi', [AdminAbsensiController::class, 'index'])
    ->name('admin.absensi.index');

    Route::post('/absensi', [AdminAbsensiController::class, 'store'])
    ->name('admin.absensi.store');
    Route::get('/setoran', [AdminSetoranController::class, 'index'])
    ->name('admin.setoran.index');

    Route::get('/setoran/riwayat', [AdminSetoranController::class, 'riwayat'])
        ->name('admin.setoran.riwayat');

    Route::get('/setoran/{nis}', [AdminSetoranController::class, 'create'])
        ->name('admin.setoran.create');

    Route::post('/setoran/{nis}', [AdminSetoranController::class, 'store'])
        ->name('admin.setoran.store');

    Route::get('/monitoring-sholat', [AdminMonitoringSholatController::class, 'index'])
    ->name('admin.monitoring-sholat.index');

    Route::post('/monitoring-sholat', [AdminMonitoringSholatController::class, 'store'])
        ->name('admin.monitoring-sholat.store');

    Route::get('/monitoring-sholat/riwayat', [AdminMonitoringSholatController::class, 'riwayat'])
        ->name('admin.monitoring-sholat.riwayat');

});

Route::middleware(['auth', 'must.change.password', 'role:guru'])->prefix('guru')->group(function () {

    Route::get('/dashboard', function () {
        $totalSiswa = Schema::hasTable('siswas') ? DB::table('siswas')->count() : 0;
        $totalMonitoring = Schema::hasTable('monitorings') ? DB::table('monitorings')->count() : 0;
        $totalSetoran = Schema::hasTable('setorans') ? DB::table('setorans')->count() : 0;

        $aktivitas = [
            'Monitoring ibadah siswa diperbarui',
            'Setoran Quran siswa berhasil ditambahkan',
            'Data absensi siswa diperiksa',
        ];

        return view('guru.dashboard', compact(
            'totalSiswa',
            'totalMonitoring',
            'totalSetoran',
            'aktivitas'
        ));
    })->name('guru.dashboard');

    Route::get('/', function () {
        return redirect()->route('guru.dashboard');
    });

    Route::get('/siswa', [SiswaController::class, 'listGuru']);

    Route::get('/setoran', [MonitoringController::class, 'index'])
        ->name('setoran.index');

    Route::get('/setoran/riwayat', [MonitoringController::class, 'riwayat'])
        ->name('setoran.riwayat');

    Route::get('/setoran/{nis}', [MonitoringController::class, 'create'])
        ->name('setoran.create');

    Route::post('/setoran/{nis}', [MonitoringController::class, 'store'])
        ->name('setoran.store');

    Route::get('/monitoring-sholat', [MonitoringSholatController::class, 'index'])
        ->name('monitoring-sholat.index');

    Route::post('/monitoring-sholat', [MonitoringSholatController::class, 'store'])
        ->name('monitoring-sholat.store');

    Route::get('/monitoring-sholat/riwayat', [MonitoringSholatController::class, 'riwayat'])
        ->name('monitoring-sholat.riwayat');

    Route::get('/laporan-prestasi-pelanggaran', [LaporanSiswaController::class, 'index'])
        ->name('laporan.index');

    Route::get('/laporan-prestasi-pelanggaran/{nis}', [LaporanSiswaController::class, 'create'])
        ->name('laporan.create');

    Route::post('/laporan-prestasi-pelanggaran/{nis}', [LaporanSiswaController::class, 'store'])
        ->name('laporan.store');

    Route::get('/rekap-absensi', [AbsensiController::class, 'index'])
        ->name('guru.absensi.index');

    Route::post('/rekap-absensi', [AbsensiController::class, 'store'])
        ->name('guru.absensi.store');
});

Route::middleware(['auth', 'must.change.password', 'role:orangtua'])->prefix('orangtua')->group(function () {
    Route::get('/', function () {
        return view('orangtua.dashboard');
    })->name('orangtua.dashboard');

    Route::get('/dashboard', function () {
        return redirect()->route('orangtua.dashboard');
    });

    Route::get('/monitoring', [OrangTuaController::class, 'monitoring'])
        ->name('orangtua.monitoring');

    Route::get('/laporan', [OrangTuaController::class, 'laporan'])
        ->name('orangtua.laporan');

    Route::get('/ibadah-sholat', [OrangTuaSholatController::class, 'index'])
        ->name('orangtua.ibadah-sholat.index');

    Route::post('/ibadah-sholat', [OrangTuaSholatController::class, 'store'])
        ->name('orangtua.ibadah-sholat.store');

    Route::get('/ibadah-sholat/riwayat', [OrangTuaSholatController::class, 'riwayatKalender'])
        ->name('orangtua.ibadah-sholat.riwayat');

    Route::get('/absensi', [OrangTuaAbsensiController::class, 'index'])
        ->name('orangtua.absensi');
});

require __DIR__.'/auth.php';
