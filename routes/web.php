<?php

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MonitoringController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrangTuaController;

Route::prefix('admin')->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index']);
    Route::get('/siswa/create', [SiswaController::class, 'create']);
    Route::post('/siswa', [SiswaController::class, 'store']);
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
