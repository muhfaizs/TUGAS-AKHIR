<!DOCTYPE html>
<html>
<head>
    <title>Rekam Medis - Imunisasi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; line-height: 1.5; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; margin: 0; }
        .subtitle { font-size: 14px; margin: 5px 0 0; }
        .section-title { font-size: 16px; font-weight: bold; margin: 20px 0 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table th, .info-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .info-table th { background-color: #f5f5f5; width: 30%; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">REKAM MEDIS PASIEN - IMUNISASI</h1>
        <p class="subtitle">Sistem Informasi Posyandu & KIA</p>
    </div>

    <div class="section-title">Data Pasien</div>
    <table class="info-table">
        <tr><th>Nama Anak</th><td>{{ $imunisasi->anak->nama_anak }}</td></tr>
        <tr><th>NIK Anak</th><td>{{ $imunisasi->anak->nik_anak ?? '-' }}</td></tr>
        <tr><th>Tanggal Lahir</th><td>{{ \Carbon\Carbon::parse($imunisasi->anak->tanggal_lahir)->format('d F Y') }}</td></tr>
        <tr><th>Nama Orang Tua</th><td>{{ $imunisasi->anak->orangTua->nama_lengkap ?? '-' }}</td></tr>
    </table>

    <div class="section-title">Detail Imunisasi</div>
    <table class="info-table">
        <tr><th>Tanggal Pemberian</th><td>{{ \Carbon\Carbon::parse($imunisasi->tanggal_pemberian)->format('d F Y') }}</td></tr>
        <tr><th>Nama Vaksin</th><td>{{ $imunisasi->nama_vaksin }}</td></tr>
        <tr><th>Nomor Batch</th><td>{{ $imunisasi->batch_vaksin }}</td></tr>
        <tr><th>Lokasi Suntikan</th><td>{{ $imunisasi->lokasi_suntikan }}</td></tr>
        <tr><th>Suhu Tubuh Sebelum</th><td>{{ $imunisasi->suhu_tubuh }} °C</td></tr>
        <tr><th>Catatan / Edukasi</th><td>{{ $imunisasi->catatan }}</td></tr>
    </table>

    <div class="section-title">Informasi Petugas</div>
    <table class="info-table">
        <tr><th>Bidan Pemeriksa</th><td>{{ $imunisasi->bidan->nama_lengkap ?? '-' }} (NIP: {{ $imunisasi->bidan->nip_bidan ?? '-' }})</td></tr>
        <tr><th>Puskesmas / Posyandu</th><td>
            @if($imunisasi->puskesmas)
                {{ $imunisasi->puskesmas->nama_puskesmas }}
            @elseif($imunisasi->posyandu)
                {{ $imunisasi->posyandu->nama_posyandu }}
            @else
                -
            @endif
        </td></tr>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>
</body>
</html>
