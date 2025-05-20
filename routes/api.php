<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DokterController;
use App\Http\Controllers\API\PendaftaranController;
use App\Http\Controllers\API\PinController;
use App\Http\Controllers\API\PoliController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\RekamMedisController;
use Illuminate\Support\Facades\Route;

// Route publik
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login-pin', [AuthController::class, 'loginWithPin']);
Route::post('/verify-email', [AuthController::class, 'verifyEmail']);

// Route informasi umum
Route::get('/dokter', [DokterController::class, 'index']);
Route::get('/dokter/{id}', [DokterController::class, 'show']);
Route::get('/poli', [PoliController::class, 'index']);
Route::get('/poli/{id}', [PoliController::class, 'show']);
Route::get('/jadwal-dokter', [DokterController::class, 'jadwal']);
Route::get('/jadwal-poli', [PoliController::class, 'jadwal']);

// Route yang memerlukan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    // User info
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Pendaftaran Online (Dafon)
    Route::get('/pendaftaran', [PendaftaranController::class, 'index']);
    Route::post('/pendaftaran', [PendaftaranController::class, 'store']);
    Route::get('/pendaftaran/{id}', [PendaftaranController::class, 'show']);
    Route::delete('/pendaftaran/{id}', [PendaftaranController::class, 'destroy']);

    // Rekam Medis
    Route::get('/rekam-medis', [RekamMedisController::class, 'index']);
    Route::get('/rekam-medis/{id}', [RekamMedisController::class, 'show']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto']);

    // Anggota Keluarga
    Route::get('/keluarga', [ProfileController::class, 'getKeluarga']);
    Route::post('/keluarga', [ProfileController::class, 'addKeluarga']);
    Route::put('/keluarga/{id}', [ProfileController::class, 'updateKeluarga']);
    Route::delete('/keluarga/{id}', [ProfileController::class, 'deleteKeluarga']);

    // Riwayat Kunjungan
    Route::get('/riwayat-kunjungan', [ProfileController::class, 'riwayatKunjungan']);

    // PIN Management
    Route::post('/pin', [PinController::class, 'create']);
    Route::post('/pin/verify', [PinController::class, 'verify']);
    Route::put('/pin', [PinController::class, 'update']);
    Route::delete('/pin', [PinController::class, 'delete']);
});
