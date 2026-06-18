<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    /**
     * Send a notification to parent (WA format + simulated email + in-app)
     */
    public function send(Request $request, Anak $anak)
    {
        $orangTua = $anak->orangTua;

        $contactNumber = $anak->nomor_kontak_darurat ?: ($orangTua ? $orangTua->phone : null);

        if (! $contactNumber) {
            return back()->with('error', 'Nomor kontak tidak ditemukan untuk anak ini.');
        }

        // WhatsApp Number Formatting (The "0 to 62" Fix)
        $waNumber = preg_replace('/[^0-9]/', '', $contactNumber);
        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62'.substr($waNumber, 1);
        } elseif (str_starts_with($waNumber, '+62')) {
            $waNumber = '62'.substr($waNumber, 3);
        }

        // Generate Message Based on Context
        // (Assuming checking the latest measurement or medical record for the child)
        $latestPengukuran = $anak->pengukuran()->orderByDesc('tanggal_pengukuran')->first();
        $latestTindakan = $anak->tindakanMedis()->orderByDesc('tanggal_pemeriksaan')->first();

        $pesan = "Halo {$orangTua->nama_lengkap}, ini pemberitahuan dari Puskesmas. Anak Anda, {$anak->nama_anak}";

        if ($latestTindakan && (! $latestPengukuran || $latestTindakan->tanggal_pemeriksaan >= $latestPengukuran->tanggal_pengukuran)) {
            $pesan .= ', baru saja menerima pemeriksaan medis dengan diagnosa: '.($latestTindakan->diagnosa ?? 'Pemeriksaan Rutin').'.';
        } elseif ($latestPengukuran) {
            $pesan .= ", telah ditimbang dengan BB: {$latestPengukuran->berat_badan}kg, TB: {$latestPengukuran->tinggi_badan}cm. Status Gizi: {$latestPengukuran->status_gizi}.";
        } else {
            $pesan .= ' terdeteksi membutuhkan perhatian medis. Silakan ke Puskesmas.';
        }

        $pesan .= ' Mohon perhatiannya untuk kesehatan tumbuh kembang anak Anda.';

        $waLink = "https://api.whatsapp.com/send?phone={$waNumber}&text=".urlencode($pesan);

        // 1. Create In-App Notification (If OrangTua exists)
        if ($orangTua && $orangTua->id_user) {
            Notifikasi::create([
                'id_user' => $orangTua->id_user,
                'judul' => 'Laporan Hasil Pemeriksaan',
                'pesan' => $pesan,
                'wa_link' => $waLink,
            ]);
        }

        // 3. Redirect the Bidan to the WA Link
        return redirect()->away($waLink);
    }

    /**
     * Send a notification to parent (System/In-App Only + Email)
     */
    public function sendSystem(Request $request, Anak $anak)
    {
        $orangTua = $anak->orangTua;

        if (! $orangTua) {
            return back()->with('error', 'Data Orang Tua tidak ditemukan untuk anak ini.');
        }

        // Generate Message Based on Context
        $latestPengukuran = $anak->pengukuran()->orderByDesc('tanggal_pengukuran')->first();
        $latestTindakan = $anak->tindakanMedis()->orderByDesc('tanggal_pemeriksaan')->first();

        $pesan = "Halo {$orangTua->nama_lengkap}, ini PANGGILAN SISTEM dari Puskesmas. Anak Anda, {$anak->nama_anak}";

        if ($latestTindakan && (! $latestPengukuran || $latestTindakan->tanggal_pemeriksaan >= $latestPengukuran->tanggal_pengukuran)) {
            $pesan .= ', tercatat memiliki indikasi medis: '.($latestTindakan->diagnosa ?? 'Pemeriksaan Rutin').'.';
        } elseif ($latestPengukuran) {
            $pesan .= ", terdeteksi memiliki status gizi: {$latestPengukuran->status_gizi} (BB: {$latestPengukuran->berat_badan}kg).";
        }

        $pesan .= ' Mohon SEGERA datang ke Puskesmas untuk pemeriksaan lanjutan.';

        // 1. Create In-App Notification
        Notifikasi::create([
            'id_user' => $orangTua->id_user,
            'judul' => 'Panggilan Medis (Puskesmas)',
            'pesan' => $pesan,
        ]);

        return back()->with('success', 'Notifikasi Panggilan Sistem berhasil dikirim ke Orang Tua.');
    }
}
