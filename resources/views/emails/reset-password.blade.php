<!DOCTYPE html>
<html>
<head>
    <title>Pemulihan Kata Sandi Akun SatuKIA</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f1f5f9; padding: 20px;">
    <div style="max-w: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #0e755f; text-align: center;">Pemulihan Kata Sandi SatuKIA</h2>
        <p>Halo, <strong>{{ $user->name }}</strong>,</p>
        <p>Kami menerima permintaan untuk menyetel ulang kata sandi akun SatuKIA Anda.</p>
        <p>Silakan klik tombol di bawah ini untuk membuat kata sandi baru:</p>
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetUrl }}" style="background-color: #0e755f; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: bold; display: inline-block;">Reset Kata Sandi</a>
        </div>
        <p>Tautan ini akan kedaluwarsa dalam 60 menit.</p>
        <p>Jika Anda tidak meminta pengaturan ulang kata sandi, abaikan email ini.</p>
        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 20px 0;">
        <p style="font-size: 12px; color: #64748b; text-align: center;">
            Jika Anda kesulitan mengklik tombol "Reset Kata Sandi", salin dan tempel URL di bawah ini ke peramban web Anda:<br>
            <a href="{{ $resetUrl }}" style="color: #0e755f; word-break: break-all;">{{ $resetUrl }}</a>
        </p>
    </div>
</body>
</html>
