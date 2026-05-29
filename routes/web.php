<?php

use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Bidan\BidanProfileController;
use App\Http\Controllers\Bidan\ImunisasiController;
use App\Http\Controllers\Bidan\TindakanMedisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Kader\KaderProfileController;
use App\Http\Controllers\Kader\PengukuranController;
use App\Http\Controllers\OrangTua\AnakController;
use App\Http\Controllers\OrangTua\ProfileController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Notifications
    Route::post('/notifikasi/read-all', [\App\Http\Controllers\NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.read-all');

    // Admin routes (super admin, kader)
    Route::middleware('role:super admin,kader')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        Route::get('/anak/{id_anak}/rekam-medis-pdf', [\App\Http\Controllers\PdfExportController::class, 'downloadRekamMedisAnak'])->name('anak.rekam-medis.pdf');
        Route::get('/tindakan/{tindakan}/pdf', [\App\Http\Controllers\PdfExportController::class, 'downloadTindakanMedis'])->name('tindakan.pdf');
        Route::get('/imunisasi/{imunisasi}/pdf', [\App\Http\Controllers\PdfExportController::class, 'downloadImunisasi'])->name('imunisasi.pdf');

        // Anak Management (for Admin, Kader)
        Route::resource('anak', App\Http\Controllers\Admin\AnakController::class);

        // User Management (Super Admin only)
        Route::middleware('role:super admin')->group(function () {
            Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
            Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
            Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
            Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        });

        // Profile routes (Admin)
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    });

    // Bidan routes
    Route::middleware('role:bidan')->prefix('bidan')->name('bidan.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'bidanDashboard'])->name('dashboard');

        // Anak Management (Bidan can also manage anak data)
        Route::resource('anak', App\Http\Controllers\Admin\AnakController::class);

        // Anak & Pasien Management
        Route::post('/anak/{anak}/send-notification', [\App\Http\Controllers\Bidan\NotificationController::class, 'send'])->name('anak.send-notification');
        Route::post('/anak/{anak}/send-system', [\App\Http\Controllers\Bidan\NotificationController::class, 'sendSystem'])->name('anak.send-system');

        // Tindakan Medis
        Route::resource('tindakan', TindakanMedisController::class)->except(['show']);

        // Imunisasi
        Route::resource('imunisasi', ImunisasiController::class)->except(['show']);

        // Profile routes
        Route::get('/profile', [BidanProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [BidanProfileController::class, 'update'])->name('profile.update');
    });

    // Kader routes
    Route::middleware('role:kader')->prefix('kader')->name('kader.')->group(function () {
        // Profile routes
        Route::get('/profile', [KaderProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [KaderProfileController::class, 'update'])->name('profile.update');

        // Pengukuran routes
        Route::get('/pengukuran/create', [PengukuranController::class, 'create'])->name('pengukuran.create');
        Route::post('/pengukuran', [PengukuranController::class, 'store'])->name('pengukuran.store');
    });

    // Orang Tua routes
    Route::middleware('role:orang tua')->prefix('orangtua')->name('orangtua.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'orangTuaDashboard'])->name('dashboard');

        // Profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // Anak routes
        Route::resource('anak', AnakController::class);

        Route::get('/anak/{id_anak}/rekam-medis-pdf', [\App\Http\Controllers\PdfExportController::class, 'downloadRekamMedisAnak'])->name('rekam-medis.pdf');
        Route::get('/tindakan/{tindakan}/pdf', [\App\Http\Controllers\PdfExportController::class, 'downloadTindakanMedis'])->name('tindakan.pdf');
        Route::get('/imunisasi/{imunisasi}/pdf', [\App\Http\Controllers\PdfExportController::class, 'downloadImunisasi'])->name('imunisasi.pdf');
    });

    // Dinkes routes
    Route::middleware('role:dinkes')->prefix('dinkes')->name('dinkes.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Dinkes\DashboardController::class, 'index'])->name('dashboard');
    });

    // Shared Laporan Routes (Bidan & Dinkes)
    Route::middleware('role:bidan,dinkes')->group(function () {
        Route::get('/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/print', [\App\Http\Controllers\LaporanController::class, 'print'])->name('laporan.print');
    });
});

