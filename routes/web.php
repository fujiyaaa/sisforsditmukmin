<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MonitoringSholatController;
use App\Http\Controllers\GuruController;
use App\Models\Siswa;
use App\Models\Monitoring;


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
});

Route::prefix('guru')->group(function () {
    Route::get('/siswa', [SiswaController::class, 'listGuru']);

    Route::get('/monitoring', [MonitoringController::class, 'index'])
        ->name('monitoring.index');

    Route::get('/monitoring/{nis}', [MonitoringController::class, 'create'])
        ->name('monitoring.create');

    Route::post('/monitoring/{nis}', [MonitoringController::class, 'store'])
        ->name('monitoring.store');

    Route::get('/monitoring-sholat', [MonitoringSholatController::class, 'index'])
        ->name('monitoring-sholat.index');

    Route::post('/monitoring-sholat', [MonitoringSholatController::class, 'store'])
        ->name('monitoring-sholat.store');
    
    Route::get('/monitoring-sholat/riwayat', [MonitoringSholatController::class, 'riwayat'])
        ->name('monitoring-sholat.riwayat');
});

Route::prefix('orangtua')->group(function () {
    Route::get('/monitoring', [OrangTuaController::class, 'monitoring'])
        ->name('orangtua.monitoring');
});

Route::get('/dashboard-guru', function () {

    $totalSiswa = Siswa::count();

    $totalMonitoring = Monitoring::count();

    $aktivitas = [
        'Monitoring ibadah berhasil diperbarui',
        'Absensi siswa berhasil disimpan',
        'Setoran Qur’an berhasil ditambahkan',
        'Data siswa berhasil diperbarui',
    ];

    return view('guru\monitoring.dashboard', compact(
        'totalSiswa',
        'totalMonitoring',
        'aktivitas'
    ));

});
