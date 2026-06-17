<!DOCTYPE html>
<html>
<head>
    <title>Pengingat Jadwal Pemeriksaan Kehamilan</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f1f5f9; padding: 20px;">
    <div style="max-w: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #0e755f; text-align: center;">Pengingat Jadwal Pemeriksaan Kehamilan</h2>
        <p>Halo, <strong>{{ $ibuHamil->nama_lengkap }}</strong>,</p>
        <p>Ini adalah pengingat dari Puskesmas Bojongsoang bahwa Anda memiliki jadwal pemeriksaan kehamilan (ANC) berikutnya pada:</p>
        
        <div style="background-color: #f8fafc; border-left: 4px solid #0e755f; padding: 15px; margin: 20px 0;">
            <p style="margin: 0; font-size: 16px;"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($tanggalKembali)->translatedFormat('l, d F Y') }}</p>
        </div>

        @if($catatan)
        <p><strong>Catatan Tambahan dari Bidan:</strong><br/>{{ $catatan }}</p>
        @endif

        <p>Mohon untuk datang tepat waktu. Pemeriksaan rutin sangat penting untuk memantau kesehatan Anda dan perkembangan janin.</p>
        
        <p>Jika ada pertanyaan atau kendala, silakan hubungi Bidan yang menangani Anda.</p>
        
        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">
        <p style="font-size: 12px; color: #64748b; text-align: center;">
            Terima kasih,<br>Puskesmas Bojongsoang<br>Sistem Monitoring KIA (SatuKIA)
        </p>
    </div>
</body>
</html>
