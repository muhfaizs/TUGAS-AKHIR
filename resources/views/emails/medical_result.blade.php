<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Pemeriksaan Medis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h2 {
            color: #0D9488;
            margin: 0;
        }
        .content {
            font-size: 16px;
            color: #333333;
            line-height: 1.5;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #888888;
            border-top: 1px solid #eeeeee;
            padding-top: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #0D9488;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Laporan Medis Puskesmas</h2>
        </div>
        <div class="content">
            <p>{{ $pesan }}</p>
            <p>Bersama email ini, kami melampirkan hasil detail pemeriksaan/imunisasi anak Anda dalam format PDF.</p>
        </div>
        <div class="footer">
            <p>Terima kasih atas kepercayaan Anda kepada layanan Posyandu & Puskesmas kami.</p>
            <p>&copy; {{ date('Y') }} Sistem Informasi KIA. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
