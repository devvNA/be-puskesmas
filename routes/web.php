<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\JadwalPoliController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\Admin\RekamMedisController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Admin (perlu autentikasi)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Pasien
    Route::resource('pasien', PasienController::class);
    Route::get('pasien-search', [PasienController::class, 'search'])->name('pasien.search');

    // Manajemen Obat
    Route::resource('obat', ObatController::class);
    Route::get('obat-search', [ObatController::class, 'search'])->name('obat.search');
    Route::get('obat-kadaluarsa', [ObatController::class, 'kadaluarsa'])->name('obat.kadaluarsa');
    Route::get('obat-stok-rendah', [ObatController::class, 'stokRendah'])->name('obat.stok-rendah');

    // Manajemen Pendaftaran
    Route::resource('pendaftaran', PendaftaranController::class);
    Route::get('pendaftaran-search', [PendaftaranController::class, 'searchByDate'])->name('pendaftaran.search');
    Route::get('pendaftaran-search-pasien', [PendaftaranController::class, 'search'])->name('pendaftaran.search-pasien');
    Route::post('pendaftaran/{pendaftaran}/status', [PendaftaranController::class, 'updateStatus'])->name('pendaftaran.status');

    // QR Code
    Route::post('pendaftaran/scan-qr', [PendaftaranController::class, 'scanQR'])->name('pendaftaran.scan-qr');
    Route::get('pendaftaran/{pendaftaran}/qrcode', [QrCodeController::class, 'generate'])
        ->name('pendaftaran.qrcode');
    Route::get('pendaftaran/{pendaftaran}/qrcode/download', [QrCodeController::class, 'saveQrCode'])
        ->name('pendaftaran.qrcode.download');

    // Manajemen Poli
    Route::resource('poli', PoliController::class);

    // Manajemen Jadwal Poli (menggunakan controller baru)
    Route::get('poli/{poli}/jadwal', [JadwalPoliController::class, 'index'])->name('jadwal.index');
    Route::get('poli/{poli}/jadwal/create', [JadwalPoliController::class, 'create'])->name('jadwal.create');
    Route::post('poli/{poli}/jadwal', [JadwalPoliController::class, 'store'])->name('jadwal.store');
    Route::get('poli/{poli}/jadwal/{jadwal}/edit', [JadwalPoliController::class, 'edit'])->name('jadwal.edit');
    Route::put('poli/{poli}/jadwal/{jadwal}', [JadwalPoliController::class, 'update'])->name('jadwal.update');
    Route::delete('poli/{poli}/jadwal/{jadwal}', [JadwalPoliController::class, 'destroy'])->name('jadwal.destroy');

    // Manajemen Dokter
    Route::resource('dokter', DokterController::class);
    Route::get('dokter/{dokter}/jadwal', [DokterController::class, 'jadwal'])->name('dokter.jadwal');
    Route::get('dokter/{dokter}/jadwal/create', [DokterController::class, 'createJadwal'])->name('dokter.jadwal.create');
    Route::post('dokter/{dokter}/jadwal', [DokterController::class, 'storeJadwal'])->name('dokter.jadwal.store');
    Route::get('dokter/{dokter}/jadwal/{jadwal}/edit', [DokterController::class, 'editJadwal'])->name('dokter.jadwal.edit');
    Route::put('dokter/{dokter}/jadwal/{jadwal}', [DokterController::class, 'updateJadwal'])->name('dokter.jadwal.update');
    Route::delete('dokter/{dokter}/jadwal/{jadwal}', [DokterController::class, 'destroyJadwal'])->name('dokter.jadwal.destroy');

    // Manajemen Rekam Medis
    Route::resource('rekam-medis', RekamMedisController::class)->parameters([
        'rekam-medis' => 'rekamMedis',
    ]);
    Route::get('rekam-medis-search', [RekamMedisController::class, 'search'])->name('rekam-medis.search');
    Route::get('pasien/{pasien}/rekam-medis', [RekamMedisController::class, 'pasien'])->name('rekam-medis.pasien');
    Route::delete('file-pendukung/{file}', [RekamMedisController::class, 'destroyFile'])->name('file-pendukung.destroy');

    // QR Code Rekam Medis
    Route::get('rekam-medis/{rekamMedis}/qrcode', [QrCodeController::class, 'generateRekamMedis'])
        ->name('rekam-medis.qrcode');
    Route::get('rekam-medis/{rekamMedis}/qrcode/download', [QrCodeController::class, 'saveRekamMedisQrCode'])
        ->name('rekam-medis.qrcode.download');
    Route::get('rekam-medis/{rekamMedis}/qrcode-data', [RekamMedisController::class, 'qrCodeData'])
        ->name('rekam-medis.qrcode-data');
});
