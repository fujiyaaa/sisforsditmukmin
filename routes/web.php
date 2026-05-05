<?php

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MonitoringController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index']);
    Route::get('/siswa/create', [SiswaController::class, 'create']);
    Route::post('/siswa', [SiswaController::class, 'store']);
});

Route::prefix('guru')->group(function () {
    Route::get('/siswa', [SiswaController::class, 'listGuru']);
    Route::get('/monitoring/{id}', [MonitoringController::class, 'create']);
    Route::post('/monitoring', [MonitoringController::class, 'store']);
});
