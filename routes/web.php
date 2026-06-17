<?php

use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Bidan\BidanProfileController;
use App\Http\Controllers\Bidan\ImunisasiController;
use App\Http\Controllers\Bidan\NotificationController;
use App\Http\Controllers\Bidan\TindakanMedisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dinkes\DinkesProfileController;
use App\Http\Controllers\Kader\JadwalPosyanduController;
use App\Http\Controllers\Kader\KaderProfileController;
use App\Http\Controllers\Kader\PengukuranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\OrangTua\AnakController;
use App\Http\Controllers\OrangTua\ProfileController;
use App\Http\Controllers\PdfExportController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KBAcceptorController;
use App\Http\Controllers\KBServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientPortalController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected routes — require login
Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', ...) is moved below into a role middleware group

    // Patient Portal Routes
    Route::middleware(['role:patient'])->group(function () {
        Route::get('/patient/dashboard', [PatientPortalController::class, 'dashboard'])->name('patient.dashboard');
    });

    // KB Acceptor Routes
    Route::middleware(['role:super_admin,admin,bidan,kader'])->group(function () {
        Route::resource('kb-acceptors', KBAcceptorController::class);
        Route::match(['get', 'post'], '/kb-acceptors/{kbAcceptor}/submit', [KBAcceptorController::class, 'submitForVerification'])->name('kb-acceptors.submit');
        Route::post('/kb-acceptors/{kbAcceptor}/verify', [KBAcceptorController::class, 'verify'])->name('kb-acceptors.verify');
        Route::get('/api/kb-acceptors/search', [KBAcceptorController::class, 'search'])->name('kb-acceptors.search');
    });

    // KB Service, Follow up, Dashboard, and Notification Routes
    Route::middleware(['role:super_admin,admin,bidan'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('kb-services', KBServiceController::class);
        Route::post('/kb-services/{kbService}/verify', [KBServiceController::class, 'verify'])->name('kb-services.verify');
        Route::get('/api/kb-services/search', [KBServiceController::class, 'search'])->name('kb-services.search');
        
        Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
        
        Route::get('/follow-ups', [\App\Http\Controllers\FollowUpController::class, 'index'])->name('followups.index');
        Route::get('/follow-ups/{service}', [\App\Http\Controllers\FollowUpController::class, 'show'])->name('followups.show');
        Route::post('/follow-ups/{service}', [\App\Http\Controllers\FollowUpController::class, 'store'])->name('followups.store');
    });
    
    // Reports Routes
    Route::middleware(['role:super_admin,admin,bidan,dinas_kesehatan'])->group(function () {
        Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports', [\App\Http\Controllers\ReportController::class, 'store'])->name('reports.store');
        Route::get('/reports/{report}/download', [\App\Http\Controllers\ReportController::class, 'download'])->name('reports.download');
        Route::post('/reports/{report}/submit', [\App\Http\Controllers\ReportController::class, 'submit'])->name('reports.submit');
        Route::post('/reports/{report}/verify', [\App\Http\Controllers\ReportController::class, 'verify'])->name('reports.verify');
        Route::delete('/reports/{report}', [\App\Http\Controllers\ReportController::class, 'destroy'])->name('reports.destroy');
    });

    // User Management Routes
    Route::middleware(['role:super_admin,admin'])->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    });
});

// API Routes untuk refresh data
Route::post('/api/kb/refresh', [DashboardController::class, 'refreshDataFromAPI']);
Route::get('/api/dashboard/stats', [DashboardController::class, 'getStats']);
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
    Route::post('/notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.read-all');

    // Admin routes (super admin, kader)
    Route::middleware('role:super admin,kader')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        Route::get('/anak/{id_anak}/rekam-medis-pdf', [PdfExportController::class, 'downloadRekamMedisAnak'])->name('anak.rekam-medis.pdf');
        Route::get('/tindakan/{tindakan}/pdf', [PdfExportController::class, 'downloadTindakanMedis'])->name('tindakan.pdf');
        Route::get('/imunisasi/{imunisasi}/pdf', [PdfExportController::class, 'downloadImunisasi'])->name('imunisasi.pdf');

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
        Route::post('/anak/{anak}/send-notification', [NotificationController::class, 'send'])->name('anak.send-notification');
        Route::post('/anak/{anak}/send-system', [NotificationController::class, 'sendSystem'])->name('anak.send-system');

        // Tindakan Medis
        Route::resource('tindakan', TindakanMedisController::class)->except(['show']);

        // Imunisasi
        Route::resource('imunisasi', ImunisasiController::class)->except(['show']);

        // PDF Downloads
        Route::get('/anak/{id_anak}/rekam-medis-pdf', [PdfExportController::class, 'downloadRekamMedisAnak'])->name('anak.rekam-medis.pdf');
        Route::get('/tindakan/{tindakan}/pdf', [PdfExportController::class, 'downloadTindakanMedis'])->name('tindakan.pdf');
        Route::get('/imunisasi/{imunisasi}/pdf', [PdfExportController::class, 'downloadImunisasi'])->name('imunisasi.pdf');

        // Kader Management (Bidan can manage Kader)
        Route::get('/kader', [UserManagementController::class, 'index'])->name('kader.index');
        Route::post('/kader', [UserManagementController::class, 'store'])->name('kader.store');
        Route::get('/kader/{user}', [UserManagementController::class, 'show'])->name('kader.show');
        Route::put('/kader/{user}', [UserManagementController::class, 'update'])->name('kader.update');
        Route::delete('/kader/{user}', [UserManagementController::class, 'destroy'])->name('kader.destroy');

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

        // Jadwal Posyandu routes
        Route::resource('jadwal', JadwalPosyanduController::class);
    });

    // Orang Tua routes
    Route::middleware('role:orang tua')->prefix('orangtua')->name('orangtua.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'orangTuaDashboard'])->name('dashboard');
        Route::post('/dashboard/reminder/dismiss', [DashboardController::class, 'dismissReminder'])->name('reminder.dismiss');

        // Profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // Anak routes
        Route::resource('anak', AnakController::class);

        Route::get('/anak/{id_anak}/rekam-medis-pdf', [PdfExportController::class, 'downloadRekamMedisAnak'])->name('rekam-medis.pdf');
        Route::get('/tindakan/{tindakan}/pdf', [PdfExportController::class, 'downloadTindakanMedis'])->name('tindakan.pdf');
        Route::get('/imunisasi/{imunisasi}/pdf', [PdfExportController::class, 'downloadImunisasi'])->name('imunisasi.pdf');
    });

    // Dinkes routes
    Route::middleware('role:dinkes')->prefix('dinkes')->name('dinkes.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Dinkes\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [DinkesProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [DinkesProfileController::class, 'update'])->name('profile.update');
        Route::get('/laporan/{id}', [LaporanController::class, 'showDinkes'])->name('laporan.show');
    });

    // Shared Laporan Routes (Bidan & Dinkes)
    Route::middleware('role:bidan,dinkes')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
        Route::get('/laporan/excel', [LaporanController::class, 'excel'])->name('laporan.excel');
        Route::post('/laporan/submit', [LaporanController::class, 'submitToDinkes'])->name('bidan.laporan.submit');
    });
});
