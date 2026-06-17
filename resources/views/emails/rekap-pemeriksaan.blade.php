<!DOCTYPE html>
<html>
<head>
    <title>Hasil Rekapitulasi Pemeriksaan Kehamilan (ANC)</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f1f5f9; padding: 20px;">
    <div style="max-w: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #0e755f; text-align: center;">Hasil Pemeriksaan Kehamilan</h2>
        <p>Halo, <strong>{{ $ibuHamil->nama_lengkap }}</strong>,</p>
        <p>Berikut kami lampirkan berkas dokumen PDF yang berisi rekapitulasi riwayat pemeriksaan kehamilan (ANC) Anda di Puskesmas Bojongsoang.</p>
        
        <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; margin: 20px 0; border-radius: 6px;">
            <p style="margin: 0; font-size: 14px; color: #475569;">
                <strong>Catatan:</strong><br/>
                Silakan unduh lampiran pada email ini. Dokumen tersebut berisi rincian pemeriksaan dan grafik perkembangan kehamilan Anda.
            </p>
        </div>

        @if($tanggalBerikutnya)
        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; padding: 15px; margin: 20px 0; border-radius: 6px;">
            <h3 style="color: #166534; margin-top: 0; margin-bottom: 10px; font-size: 16px;">📅 Pengingat Jadwal Pemeriksaan</h3>
            <p style="margin: 0; font-size: 14px; color: #166534;">
                Berdasarkan usia kehamilan Anda, jadwal pemeriksaan ANC Anda berikutnya adalah pada:<br/>
                <strong style="font-size: 16px; display: inline-block; margin-top: 8px; color: #15803d;">{{ $tanggalBerikutnya }}</strong>
            </p>
        </div>
        @endif

        <p>Terus pantau kesehatan Anda dan pastikan untuk selalu datang pada jadwal pemeriksaan berikutnya.</p>
        
        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">
        <p style="font-size: 12px; color: #64748b; text-align: center;">
            Terima kasih,<br>Puskesmas Bojongsoang<br>Sistem Monitoring KIA (SatuKIA)
        </p>
    </div>
</body>
</html>
