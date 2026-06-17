<!DOCTYPE html>
<html>
<head>
    <title>Rekam Medis - Tindakan Medis</title>
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
        <h1 class="title">REKAM MEDIS PASIEN - TINDAKAN MEDIS</h1>
        <p class="subtitle">Sistem Informasi Posyandu & KIA</p>
    </div>

    <div class="section-title">Data Pasien</div>
    <table class="info-table">
        <tr><th>Nama Anak</th><td>{{ $tindakan->anak->nama_anak }}</td></tr>
        <tr><th>NIK Anak</th><td>{{ $tindakan->anak->nik_anak ?? '-' }}</td></tr>
        <tr><th>Tanggal Lahir</th><td>{{ \Carbon\Carbon::parse($tindakan->anak->tanggal_lahir)->format('d F Y') }}</td></tr>
        <tr><th>Nama Orang Tua</th><td>{{ $tindakan->anak->orangTua->name ?? '-' }}</td></tr>
    </table>

    <div class="section-title">Detail Pemeriksaan / Tindakan</div>
    <table class="info-table">
        <tr><th>Tanggal Pemeriksaan</th><td>{{ \Carbon\Carbon::parse($tindakan->tanggal_pemeriksaan)->format('d F Y') }}</td></tr>
        <tr><th>Suhu Tubuh</th><td>{{ $tindakan->suhu_tubuh }} °C</td></tr>
        <tr><th>Diagnosa</th><td>{{ $tindakan->diagnosa }}</td></tr>
        <tr><th>Resep Obat</th><td>{{ $tindakan->resep_obat }}</td></tr>
        <tr><th>Catatan / Tindakan</th><td>{{ $tindakan->catatan_pemeriksaan }}</td></tr>
    </table>

    <div class="section-title">Informasi Petugas</div>
    <table class="info-table">
        <tr><th>Bidan Pemeriksa</th><td>{{ $tindakan->bidan->name ?? '-' }} (NIP: {{ $tindakan->bidan->nip ?? '-' }})</td></tr>
        <tr><th>Puskesmas / Posyandu</th><td>
            @if($tindakan->puskesmas)
                {{ $tindakan->puskesmas->nama_puskesmas }}
            @elseif($tindakan->posyandu)
                {{ $tindakan->posyandu->nama_posyandu }}
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
