<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MonitoringSholatController;
use App\Http\Controllers\LaporanSiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;

use App\Models\Siswa;
use App\Models\Monitoring;


Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(function () {

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

    Route::get('/laporan-prestasi-pelanggaran', [LaporanSiswaController::class, 'adminIndex'])->name('admin.laporan.index');
    Route::get('/laporan-prestasi-pelanggaran/{nis}', [LaporanSiswaController::class, 'adminCreate'])->name('admin.laporan.create');
    Route::post('/laporan-prestasi-pelanggaran/{nis}', [LaporanSiswaController::class, 'adminStore'])->name('admin.laporan.store');

});



Route::prefix('guru')->group(function () {
    Route::get('/guru', function () {
        return redirect()->route('guru.dashboard');
    });

    Route::get('/siswa', [SiswaController::class, 'listGuru']);
    Route::get('/setoran', [MonitoringController::class, 'index'])
        ->name('setoran.index');
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


Route::prefix('orangtua')->group(function () {

    Route::get('/monitoring', [OrangTuaController::class, 'monitoring'])->name('orangtua.monitoring');
    Route::get('/laporan', [OrangTuaController::class, 'laporan'])->name('laporan');
});


Route::get('/guru', function () {
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
/*
|--------------------------------------------------------------------------
| DASHBOARD ORANG TUA
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    return view('orangtua.dashboard');

});


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

//require __DIR__.'/auth.php';
