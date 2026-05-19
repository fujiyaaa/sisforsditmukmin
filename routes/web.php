<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\KelasController;
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
});

Route::prefix('guru')->group(function () {
    Route::get('/siswa', [SiswaController::class, 'listGuru']);

    Route::get('/monitoring', [MonitoringController::class, 'index'])
        ->name('monitoring.index');

    Route::get('/monitoring/{nis}', [MonitoringController::class, 'create'])
        ->name('monitoring.create');

    Route::post('/monitoring/{nis}', [MonitoringController::class, 'store'])
        ->name('monitoring.store');
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
