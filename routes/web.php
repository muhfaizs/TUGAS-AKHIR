<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidanController;
use App\Http\Controllers\BidanReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DinkesController;
use App\Http\Controllers\IbuHamilController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PemeriksaanAncController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RujukanController;
use App\Http\Middleware\BidanOnlyMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Lupa Kata Sandi & Reset Password
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/download-rekap', [OrtuController::class, 'downloadRekap'])->name('ortu.download-rekap');
    Route::get('/data-pemeriksaan', [OrtuController::class, 'pemeriksaan'])->name('ortu.pemeriksaan');
    Route::get('/data-pemeriksaan/{id}', [OrtuController::class, 'pemeriksaanDetail'])->name('ortu.pemeriksaan.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/dinkes/export-pdf', [DinkesController::class, 'exportPdf'])->name('dinkes.export-pdf');
    Route::get('/dinkes/export-excel', [DinkesController::class, 'exportExcel'])->name('dinkes.export-excel');
    Route::get('/laporan-rekapitulasi', [DinkesController::class, 'laporan'])->name('dinkes.laporan');

    Route::get('/notifications/{id}/read', function ($id) {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->route('dinkes.laporan');
    })->name('notifications.read');

    // Kelola Pengguna: Hanya untuk Super Administrator
    Route::middleware(SuperAdminMiddleware::class)->group(function () {
        Route::resource('bidan', BidanController::class);
        Route::resource('dinkes', DinkesController::class);
        Route::resource('ortu', OrtuController::class);
    });

    // Data Ibu Hamil: Hanya untuk Bidan (Bukan Super Admin)
    Route::middleware(BidanOnlyMiddleware::class)->group(function () {
        // Kelola Data Pasien (Ibu Hamil)
        Route::resource('ibu-hamil', IbuHamilController::class);
        Route::post('ibu-hamil/{id}/turun-risiko', [IbuHamilController::class, 'turunRisiko'])->name('ibu-hamil.turun-risiko');
        Route::get('ibu-hamil/{id}/cetak-rekap', [IbuHamilController::class, 'cetakRekapPdf'])->name('ibu-hamil.cetak-rekap');
        Route::post('ibu-hamil/{id}/send-reminder', [IbuHamilController::class, 'sendReminder'])->name('ibu-hamil.send-reminder');
        Route::post('ibu-hamil/{id}/send-rekap', [IbuHamilController::class, 'sendRekapPdf'])->name('ibu-hamil.send-rekap');

        // Rujukan
        Route::get('rujukan', [RujukanController::class, 'index'])->name('rujukan.index');
        Route::post('rujukan/{id}/cetak', [RujukanController::class, 'cetakPdf'])->name('rujukan.cetak');

        // Pemeriksaan ANC (12T)
        Route::get('pemeriksaan-anc/create', [PemeriksaanAncController::class, 'create'])->name('pemeriksaan-anc.create');
        Route::post('pemeriksaan-anc', [PemeriksaanAncController::class, 'store'])->name('pemeriksaan-anc.store');
        Route::get('pemeriksaan-anc/{id}', [PemeriksaanAncController::class, 'show'])->name('pemeriksaan-anc.show');
        Route::get('pemeriksaan-anc/{id}/edit', [PemeriksaanAncController::class, 'edit'])->name('pemeriksaan-anc.edit');
        Route::put('pemeriksaan-anc/{id}', [PemeriksaanAncController::class, 'update'])->name('pemeriksaan-anc.update');
        Route::delete('pemeriksaan-anc/{id}', [PemeriksaanAncController::class, 'destroy'])->name('pemeriksaan-anc.destroy');
        Route::get('pemeriksaan-anc/{id}/cetak-rujukan-lab', [PemeriksaanAncController::class, 'cetakRujukanLabPdf'])->name('pemeriksaan-anc.cetak-rujukan-lab');

        // Laporan Dinkes
        Route::get('laporan-dinkes/bulanan', [BidanReportController::class, 'bulanan'])->name('bidan.laporan-bulanan');
        Route::get('laporan-dinkes/tahunan', [BidanReportController::class, 'tahunan'])->name('bidan.laporan-tahunan');
        Route::get('laporan-dinkes/export', [BidanReportController::class, 'export'])->name('bidan.laporan-export');
        Route::post('laporan-dinkes/kirim', [BidanReportController::class, 'kirim'])->name('bidan.laporan-kirim');
    });
});
