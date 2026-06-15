<?php

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
