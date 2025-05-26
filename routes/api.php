<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DokterController;
use App\Http\Controllers\API\PendaftaranController;
use App\Http\Controllers\API\PinController;
use App\Http\Controllers\API\PoliController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\RekamMedisController;
use App\Http\Controllers\API\PasienController;
use Illuminate\Support\Facades\Route;

// Route publik
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login-pin', [AuthController::class, 'loginWithPin']);
Route::post('/verify', [AuthController::class, 'verifyUser']);
Route::post('/pin', [PinController::class, 'create']);
Route::get('/antrian', [PendaftaranController::class, 'public']);


// Route informasi umum
Route::get('/dokter', [DokterController::class, 'index']);
Route::get('/dokter/{id}', [DokterController::class, 'show']);
Route::get('/dokter-poli/{poliId}', [DokterController::class, 'getByPoli']);
Route::get('/poli', [PoliController::class, 'index']);
Route::get('/poli/{id}', [PoliController::class, 'show']);
Route::get('/jadwal-dokter', [DokterController::class, 'jadwal']);
Route::get('/jadwal-poli', [PoliController::class, 'jadwal']);
Route::get('/list-poli', [PoliController::class, 'getListPoli']);

// Route yang memerlukan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    // User info
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Pasien API
    Route::post('/pasien', [PasienController::class, 'store']);
    Route::get('/pasien/{id}', [PasienController::class, 'show']);
    Route::put('/pasien/{id}', [PasienController::class, 'update']);
    Route::delete('/pasien/{id}', [PasienController::class, 'destroy']);
    Route::post('/pasien/{id}/upload-foto', [PasienController::class, 'uploadFoto']);
    Route::get('/keluarga-pasien', [PasienController::class, 'getKeluarga']);
    Route::get('/pasien/rekam-medis/{noRm}', [PasienController::class, 'getPasien']);

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
    Route::put('/pin', [PinController::class, 'update']);
    Route::delete('/pin', [PinController::class, 'delete']);
});
