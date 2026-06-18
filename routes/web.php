<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Bidan\ImunisasiController;
use App\Http\Controllers\Bidan\TindakanMedisController;
use App\Http\Controllers\BidanController;
use App\Http\Controllers\BidanReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DinkesController;
use App\Http\Controllers\IbuHamilController;
use App\Http\Controllers\Kader\JadwalPosyanduController;
use App\Http\Controllers\Kader\PengukuranController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\KBAcceptorController;
use App\Http\Controllers\KBServiceController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\OrangTua\AnakController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PdfExportController;
use App\Http\Controllers\PemeriksaanAncController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RujukanController;
use App\Http\Controllers\UserManagementController;
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
    Route::post('/notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.read-all');
    Route::get('/dashboard/download-rekap', [OrtuController::class, 'downloadRekap'])->name('ortu.download-rekap');
    Route::get('/data-pemeriksaan', [OrtuController::class, 'pemeriksaan'])->name('ortu.pemeriksaan');
    Route::get('/data-pemeriksaan/{id}', [OrtuController::class, 'pemeriksaanDetail'])->name('ortu.pemeriksaan.show');
    Route::get('/dashboard/dismiss-pengingat', [OrtuController::class, 'dismissPengingat'])->name('ortu.dismiss-pengingat');

    // Modul Keluarga Berencana (KB)
    Route::get('/kb-acceptors/search', [KBAcceptorController::class, 'search'])->name('kb-acceptors.search');
    Route::get('/kb-acceptors/laporan-r1', [KBAcceptorController::class, 'laporanR1'])->name('kb-acceptors.laporan-r1');
    Route::post('/kb-acceptors/laporan-r1/submit', [KBAcceptorController::class, 'submitLaporanR1'])->name('kb-acceptors.laporan-r1.submit');
    Route::post('/kb-acceptors/{kb_acceptor}/submit', [KBAcceptorController::class, 'submitForVerification'])->name('kb-acceptors.submit');
    Route::post('/kb-acceptors/{kb_acceptor}/verify', [KBAcceptorController::class, 'verify'])->name('kb-acceptors.verify');
    Route::resource('kb-acceptors', KBAcceptorController::class);
    
    Route::get('/kb-services/jadwal-kontrol', [KBServiceController::class, 'jadwalKontrol'])->name('kb-services.jadwal-kontrol');
    Route::post('/kb-services/{kb_service}/send-reminder', [KBServiceController::class, 'sendReminder'])->name('kb-services.send-reminder');
    Route::post('/kb-services/{kb_service}/verify', [KBServiceController::class, 'verify'])->name('kb-services.verify');
    Route::resource('kb-services', KBServiceController::class);
    
    // Rute Follow Up (Pemantauan Tindak Lanjut KB)
    Route::get('followups/{kb_service}', [FollowUpController::class, 'show'])->name('followups.show');
    Route::post('followups/{kb_service}', [FollowUpController::class, 'store'])->name('followups.store');

    // Modul Data Anak (Orang Tua)
    Route::resource('orangtua/anak', AnakController::class)->names('orangtua.anak');
    Route::get('/orangtua/anak/{id_anak}/rekam-medis-pdf', [PdfExportController::class, 'downloadRekamMedisAnak'])->name('orangtua.rekam-medis.pdf');
    Route::get('/orangtua/tindakan/{tindakan}/pdf', [PdfExportController::class, 'downloadTindakanMedis'])->name('orangtua.tindakan.pdf');
    Route::get('/orangtua/imunisasi/{imunisasi}/pdf', [PdfExportController::class, 'downloadImunisasi'])->name('orangtua.imunisasi.pdf');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/dinkes/export-pdf', [DinkesController::class, 'exportPdf'])->name('dinkes.export-pdf');
    Route::get('/dinkes/export-excel', [DinkesController::class, 'exportExcel'])->name('dinkes.export-excel');
    Route::get('/dinkes/export-bayi-pdf', [DinkesController::class, 'exportBayiPdf'])->name('dinkes.export-bayi-pdf');
    Route::get('/dinkes/export-bayi-excel', [DinkesController::class, 'exportBayiExcel'])->name('dinkes.export-bayi-excel');
    Route::get('/dinkes/export-kb-pdf', [DinkesController::class, 'exportKbPdf'])->name('dinkes.export-kb-pdf');
    Route::get('/dinkes/export-kb-excel', [DinkesController::class, 'exportKbExcel'])->name('dinkes.export-kb-excel');
    Route::get('/laporan-rekapitulasi', [DinkesController::class, 'laporan'])->name('dinkes.laporan');
    Route::get('/laporan-rekapitulasi/{id}', [App\Http\Controllers\LaporanController::class, 'showDinkes'])->name('dinkes.laporan.show');

    Route::get('/notifications/{id}/read', function ($id) {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->route('dinkes.laporan');
    })->name('notifications.read');


    // Cetak Rekap (Bisa diakses oleh Bidan, Super Admin, dan Ibu Hamil)
    Route::get('ibu-hamil/{id}/cetak-rekap', [IbuHamilController::class, 'cetakRekapPdf'])->name('ibu-hamil.cetak-rekap');

    // Data Ibu Hamil: Hanya untuk Bidan (Bukan Super Admin)
    Route::middleware(BidanOnlyMiddleware::class)->group(function () {
        // Kelola Data Kader
        Route::resource('bidan/kader', UserManagementController::class)->names('bidan.kader');

        // Kelola Data Pasien (Ibu Hamil)
        Route::resource('ibu-hamil', IbuHamilController::class);
        Route::post('ibu-hamil/{id}/turun-risiko', [IbuHamilController::class, 'turunRisiko'])->name('ibu-hamil.turun-risiko');
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

        // Data Anak (Bidan)
        Route::post('anak/{anak}/send-system', [App\Http\Controllers\Bidan\NotificationController::class, 'sendSystem'])->name('bidan.anak.send-system');
        Route::post('anak/{anak}/send-notification', [App\Http\Controllers\Bidan\NotificationController::class, 'send'])->name('bidan.anak.send-notification');
        Route::resource('anak', App\Http\Controllers\Admin\AnakController::class)->names('bidan.anak');

        // Tindakan Medis (Bidan)
        Route::get('bidan/tindakan/{tindakan}/pdf', [App\Http\Controllers\PdfExportController::class, 'downloadTindakanMedis'])->name('bidan.tindakan.pdf');
        Route::resource('bidan/tindakan', TindakanMedisController::class)->names('bidan.tindakan');

        // Imunisasi (Bidan)
        Route::get('bidan/imunisasi/{imunisasi}/pdf', [App\Http\Controllers\PdfExportController::class, 'downloadImunisasi'])->name('bidan.imunisasi.pdf');
        Route::resource('bidan/imunisasi', ImunisasiController::class)->names('bidan.imunisasi');

        // Laporan Periodik (alias untuk backward compatibility)
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
        Route::get('/laporan/excel', [LaporanController::class, 'excel'])->name('laporan.excel');
        Route::post('/laporan/submit', [LaporanController::class, 'submitToDinkes'])->name('bidan.laporan.submit');
    });

    // Kelola Pengguna: Hanya untuk Super Administrator
    Route::middleware(SuperAdminMiddleware::class)->group(function () {
        Route::resource('admin/users', UserManagementController::class)->names('admin.users');
        Route::resource('bidan', BidanController::class);
        Route::resource('dinkes', DinkesController::class);
        Route::resource('ortu', OrtuController::class);
    });

    // Modul Khusus Admin & Kader
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('anak', App\Http\Controllers\Admin\AnakController::class);
    });

    // Modul Pengukuran (Kader)
    Route::prefix('kader')->name('kader.')->group(function () {
        Route::get('/pengukuran/create', [PengukuranController::class, 'create'])->name('pengukuran.create');
        Route::post('/pengukuran', [PengukuranController::class, 'store'])->name('pengukuran.store');
        Route::resource('jadwal', JadwalPosyanduController::class);
    });
});
