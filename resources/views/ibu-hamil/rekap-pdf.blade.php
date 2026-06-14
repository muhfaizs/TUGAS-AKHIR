<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Pemeriksaan ANC - {{ $ibuHamil->nama_lengkap }}</title>
    <style>
        @page { margin: 15px 25px; }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        .header h2 {
            margin: 3px 0 0;
            font-size: 13px;
        }
        .header p {
            margin: 3px 0 0;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 3px 5px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .info-table th, .info-table td {
            border: none;
            padding: 2px 5px;
        }
        .info-table th {
            width: 180px;
        }
        .text-center {
            text-align: center;
        }
        .footer-ttd {
            width: 200px;
            float: right;
            text-align: center;
            margin-top: 15px;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .section-title {
            margin-top: 10px;
            margin-bottom: 5px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
            font-size: 12px;
        }
        .anc-block {
            border: 1px solid #000;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        .anc-header {
            background-color: #f0f0f0;
            padding: 4px 8px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            font-size: 11px;
        }
        .anc-body {
            padding: 4px;
        }
        .anc-table {
            width: 100%;
            border-collapse: collapse;
        }
        .anc-table th, .anc-table td {
            border: none;
            padding: 2px 4px;
        }
        .anc-table th {
            width: 30%;
            background-color: transparent;
            font-weight: normal;
            color: #555;
        }
        .anc-table td {
            font-weight: bold;
        }
        .col-half {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>PUSKESMAS BOJONGSOANG</h1>
        <h2>REKAPITULASI PEMERIKSAAN ANC (ANTENATAL CARE)</h2>
        <p>Jl. Raya Bojongsoang No.232, Cipagalo, Kec. Bojongsoang, Kabupaten Bandung, Jawa Barat 40287</p>
    </div>

    <h3 class="section-title">Data Identitas Pasien</h3>
    <table class="info-table">
        <tr>
            <th>Nomor Rekam Medis</th>
            <td>: {{ $ibuHamil->nomor_rekam_medis }}</td>
        </tr>
        <tr>
            <th>Nama Lengkap</th>
            <td>: {{ $ibuHamil->nama_lengkap }}</td>
        </tr>
        <tr>
            <th>NIK</th>
            <td>: {{ $ibuHamil->nik }}</td>
        </tr>
        <tr>
            <th>Umur / Gol. Darah</th>
            <td>: {{ $ibuHamil->umur }} Tahun / {{ $ibuHamil->golongan_darah }}</td>
        </tr>
        <tr>
            <th>Nama Suami</th>
            <td>: {{ $ibuHamil->nama_suami }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>: {{ $ibuHamil->alamat }}</td>
        </tr>
    </table>

    <h3 class="section-title">Status Kehamilan</h3>
    <table class="info-table">
        <tr>
            <th>G/P/A (Gravida/Paritas/Abortus)</th>
            <td>: G{{ $ibuHamil->gravida }} P{{ $ibuHamil->paritas }} A{{ $ibuHamil->abortus }}</td>
        </tr>
        <tr>
            <th>HPHT / HPL</th>
            <td>: {{ $ibuHamil->hpht->format('d M Y') }} / {{ $ibuHamil->hpl->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Risiko Kehamilan</th>
            <td>: {{ $ibuHamil->status_risiko_kehamilan }}</td>
        </tr>
    </table>

    @if($ibuHamil->pemeriksaanAncs && $ibuHamil->pemeriksaanAncs->count() > 0)
    <h3 class="section-title">Grafik Perkembangan Janin</h3>
    <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 10px;">
            <tr>
                <th style="width: 15%; text-align: left; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Tanggal</th>
                <th style="width: 28%; text-align: left; border-bottom: 1px solid #ccc; padding-bottom: 5px; color: #ec4899;">TFU (cm)</th>
                <th style="width: 28%; text-align: left; border-bottom: 1px solid #ccc; padding-bottom: 5px; color: #0d9488;">DJJ (bpm)</th>
                <th style="width: 28%; text-align: left; border-bottom: 1px solid #ccc; padding-bottom: 5px; color: #eab308;">Berat Badan (kg)</th>
            </tr>
            @foreach($ibuHamil->pemeriksaanAncs->sortBy('tanggal_pemeriksaan') as $anc)
            <tr>
                <td style="padding: 5px 0;">{{ $anc->tanggal_pemeriksaan->format('d M y') }}</td>
                
                <td style="padding: 5px 0;">
                    <div style="display: inline-block; width: {{ min(100, ($anc->tinggi_fundus_uteri ?: 0) * 2.5) }}px; height: 10px; background-color: #fbcfe8; border: 1px solid #ec4899;"></div>
                    <span style="margin-left: 5px;">{{ $anc->tinggi_fundus_uteri ?: '-' }}</span>
                </td>
                
                <td style="padding: 5px 0;">
                    <div style="display: inline-block; width: {{ min(100, ($anc->denyut_jantung_janin ?: 0) * 0.5) }}px; height: 10px; background-color: #99f6e4; border: 1px solid #0d9488;"></div>
                    <span style="margin-left: 5px;">{{ $anc->denyut_jantung_janin ?: '-' }}</span>
                </td>
                
                <td style="padding: 5px 0;">
                    <div style="display: inline-block; width: {{ min(100, ($anc->berat_badan ?: 0)) }}px; height: 10px; background-color: #fef08a; border: 1px solid #eab308;"></div>
                    <span style="margin-left: 5px;">{{ $anc->berat_badan ?: '-' }}</span>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif

    <h3 class="section-title" style="margin-top: 15px;">Detail Riwayat Pemeriksaan ANC</h3>
    @if($ibuHamil->pemeriksaanAncs && $ibuHamil->pemeriksaanAncs->count() > 0)
        @foreach($ibuHamil->pemeriksaanAncs as $index => $anc)
        <div class="anc-block">
            <div class="anc-header">
                Pemeriksaan ke-{{ $index + 1 }} | Tanggal: {{ $anc->tanggal_pemeriksaan->format('d F Y') }} | Trimester: {{ $anc->trimester ?: '-' }}
            </div>
            <div class="anc-body">
                <div class="col-half">
                    <table class="anc-table">
                        <tr><th>Keluhan Utama</th><td>: {{ $anc->keluhan_utama ?: '-' }}</td></tr>
                        <tr><th>Tensi & BB/TB</th><td>: {{ $anc->tekanan_darah ?: '-' }} mmHg / {{ $anc->berat_badan ?: '-' }} kg / {{ $anc->tinggi_badan ?: '-' }} cm</td></tr>
                        <tr><th>LILA</th><td>: {{ $anc->lingkar_lengan_atas ?: '-' }} cm</td></tr>
                        <tr><th>Tinggi Fundus Uteri (TFU)</th><td>: {{ $anc->tinggi_fundus_uteri ?: '-' }} cm</td></tr>
                        <tr><th>Letak Janin</th><td>: {{ $anc->letak_janin ?: '-' }}</td></tr>
                        <tr><th>Denyut Jantung Janin (DJJ)</th><td>: {{ $anc->denyut_jantung_janin ?: '-' }} bpm</td></tr>
                        <tr><th>Status TT & TTD</th><td>: TT: {{ $anc->status_imunisasi_tt ?: '-' }} | TTD: {{ $anc->jumlah_tablet_darah ?: '-' }} tab</td></tr>
                    </table>
                </div>
                <div class="col-half" style="margin-left: 2%;">
                    <table class="anc-table">
                        <tr><th>Lab HB / Protein Urine</th><td>: {{ $anc->lab_hb ?: '-' }} g/dl / {{ $anc->lab_protein_urine ?: '-' }}</td></tr>
                        <tr><th>Gol. Darah / Sifilis / HIV</th><td>: {{ $anc->lab_golongan_darah ?: '-' }} / {{ $anc->lab_sifilis ?: '-' }} / {{ $anc->lab_hiv ?: '-' }}</td></tr>
                        <tr><th>Hasil USG</th><td>: {{ $anc->hasil_usg ?: '-' }}</td></tr>
                        <tr><th>Tatalaksana Kasus</th><td>: {{ $anc->tatalaksana_kasus ?: '-' }}</td></tr>
                        <tr><th>Temu Wicara (Konseling)</th><td>: {{ $anc->konseling ?: '-' }}</td></tr>
                        <tr><th>Nasihat</th><td>: {{ $anc->nasihat ?: '-' }}</td></tr>
                        <tr><th>Risiko Ditemukan</th><td>: {{ $anc->ditemukan_risiko ? 'Ya' : 'Tidak' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <p>Belum ada riwayat pemeriksaan ANC untuk pasien ini.</p>
    @endif

    <div class="clearfix">
        <div style="float: left; font-size: 10px; color: #777; margin-top: 30px;">
            Waktu Dicetak: {{ now()->translatedFormat('d F Y H:i:s') }}
        </div>
        <div class="footer-ttd">
            <p>Bojongsoang, {{ $tanggal ?? now()->translatedFormat('d F Y') }}</p>
            <p>{{ isset($bidan) && $bidan ? 'Bidan Pemeriksa,' : 'Dicetak Oleh,' }}</p>
            <br><br><br>
            <p><strong>{{ isset($bidan) && $bidan ? $bidan->name : $ibuHamil->nama_lengkap }}</strong></p>
        </div>
    </div>

</body>
</html>
