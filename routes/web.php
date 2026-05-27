<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\OrangTua\ProfileController;
use App\Http\Controllers\OrangTua\AnakController;
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

    // Admin routes (super admin, bidan, kader)
    Route::middleware('role:super admin,bidan,kader')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        // Anak Management (for Admin, Bidan, Kader)
        Route::resource('anak', \App\Http\Controllers\Admin\AnakController::class)->except(['show']);

        // User Management (Super Admin only)
        Route::middleware('role:super admin')->group(function () {
            Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
            Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
            Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
            Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        });

        // Profile routes (Admin & Bidan)
        Route::get('/profile', [\App\Http\Controllers\Admin\AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('profile.update');
    });

    // Kader routes
    Route::middleware('role:kader')->prefix('kader')->name('kader.')->group(function () {
        // Profile routes
        Route::get('/profile', [\App\Http\Controllers\Kader\KaderProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Kader\KaderProfileController::class, 'update'])->name('profile.update');

        // Pengukuran routes
        Route::get('/pengukuran/create', [\App\Http\Controllers\Kader\PengukuranController::class, 'create'])->name('pengukuran.create');
        Route::post('/pengukuran', [\App\Http\Controllers\Kader\PengukuranController::class, 'store'])->name('pengukuran.store');
    });

    // Orang Tua routes
    Route::middleware('role:orang tua')->prefix('orangtua')->name('orangtua.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'orangTuaDashboard'])->name('dashboard');
        
        // Profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // Anak routes
        Route::resource('anak', AnakController::class)->except(['show']);
    });
});
