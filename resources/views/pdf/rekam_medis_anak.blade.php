<!DOCTYPE html>
<html>
<head>
    <title>Rekam Medis - {{ $anak->nama_anak }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; line-height: 1.5; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; margin: 0; }
        .subtitle { font-size: 14px; margin: 5px 0 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .section-title { font-size: 16px; font-weight: bold; margin: 20px 0 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .info-table th, .info-table td { border: none; padding: 4px; }
        .info-table th { width: 150px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">REKAM MEDIS PASIEN</h1>
        <p class="subtitle">Sistem Informasi Posyandu & KIA</p>
    </div>

    <div class="section-title">Data Pasien</div>
    <table class="info-table">
        <tr><th>Nama Anak</th><td>: {{ $anak->nama_anak }}</td></tr>
        <tr><th>NIK Anak</th><td>: {{ $anak->nik_anak ?? '-' }}</td></tr>
        <tr><th>Tanggal Lahir</th><td>: {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d F Y') }}</td></tr>
        <tr><th>Nama Orang Tua</th><td>: {{ $anak->orangTua->name ?? '-' }}</td></tr>
    </table>

    <div class="section-title">Riwayat Tindakan Medis</div>
    @if($anak->tindakanMedis && $anak->tindakanMedis->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Diagnosa</th>
                    <th>Resep Obat</th>
                    <th>Catatan</th>
                    <th>Bidan Pemeriksa</th>
                    <th>Tempat Tugas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($anak->tindakanMedis->sortByDesc('tanggal_pemeriksaan') as $tindakan)
                    <tr>
                        <td>{{ $tindakan->tanggal_pemeriksaan->format('d/m/Y') }}</td>
                        <td>{{ $tindakan->diagnosa }}</td>
                        <td>{{ $tindakan->resep_obat }}</td>
                        <td>{{ $tindakan->catatan_pemeriksaan }}</td>
                        <td>{{ $tindakan->bidan->name ?? '-' }}</td>
                        <td>
                            @if($tindakan->puskesmas)
                                {{ $tindakan->puskesmas->nama_puskesmas }}
                            @elseif($tindakan->posyandu)
                                {{ $tindakan->posyandu->nama_posyandu }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada riwayat tindakan medis.</p>
    @endif

    <div class="section-title">Riwayat Imunisasi</div>
    @if($anak->imunisasi && $anak->imunisasi->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Vaksin</th>
                    <th>Suhu</th>
                    <th>Catatan</th>
                    <th>Bidan Pemeriksa</th>
                    <th>Tempat Tugas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($anak->imunisasi->sortByDesc('tanggal_pemberian') as $imunisasi)
                    <tr>
                        <td>{{ $imunisasi->tanggal_pemberian->format('d/m/Y') }}</td>
                        <td>{{ $imunisasi->nama_vaksin }}</td>
                        <td>{{ $imunisasi->suhu_tubuh }} °C</td>
                        <td>{{ $imunisasi->catatan }}</td>
                        <td>{{ $imunisasi->bidan->name ?? '-' }}</td>
                        <td>
                            @if($imunisasi->puskesmas)
                                {{ $imunisasi->puskesmas->nama_puskesmas }}
                            @elseif($imunisasi->posyandu)
                                {{ $imunisasi->posyandu->nama_posyandu }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada riwayat imunisasi.</p>
    @endif

    <div style="margin-top: 50px; text-align: right;">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>
</body>
</html>
