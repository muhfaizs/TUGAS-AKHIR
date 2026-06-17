<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laporan Pemeriksaan ANC' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 11px;
        }
        .sub-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .sub-header h3 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
        }
        .sub-header p {
            margin: 5px 0 0 0;
            font-size: 12px;
        }
        .filter-info {
            margin-bottom: 15px;
        }
        .filter-info p {
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-left {
            text-align: left;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
        }
        .footer p {
            margin: 5px 0;
        }
        .signature {
            margin-top: 60px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>DINAS KESEHATAN KOTA</h1>
        <h2>PUSKESMAS SATUKIA</h2>
        <p>Jl. Kesehatan No. 123, Kota Sehat, Provinsi Jawa Barat - Telp. (021) 1234567</p>
    </div>

    <div class="sub-header">
        <h3>{{ $title ?? 'LAPORAN PEMERIKSAAN IBU HAMIL' }}</h3>
        <p>Bidan: {{ auth()->user()->name }}</p>
    </div>

    <div class="filter-info">
        <p><strong>Periode:</strong> {{ $periode ?? '-' }}</p>
    </div>

    <!-- Summary Metrics Table -->
    <h3 style="margin-bottom: 5px; font-size: 12px; text-transform: uppercase;">Ringkasan Indikator (Berdasarkan Filter)</h3>
    <table style="width: 100%; margin-bottom: 25px;">
        <thead>
            <tr>
                <th>K1</th>
                <th>Triple Eliminasi</th>
                <th>Gizi Buruk (KEK)</th>
                <th>Kasus Anemia</th>
                <th>Faktor Risiko</th>
                <th>Komplikasi</th>
                <th>Rujukan FKRTL</th>
                <th>TTD >= 90</th>
                <th>Kematian Ibu</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-weight: bold; font-size: 14px;">{{ $metrics['k1'] }}</td>
                <td style="font-weight: bold; font-size: 14px;">{{ $metrics['triple_eliminasi'] }}</td>
                <td style="font-weight: bold; font-size: 14px;">{{ $metrics['kek'] }}</td>
                <td style="font-weight: bold; font-size: 14px;">{{ $metrics['anemia'] }}</td>
                <td style="font-weight: bold; font-size: 14px;">{{ $metrics['faktor_risiko'] }}</td>
                <td style="font-weight: bold; font-size: 14px;">{{ $metrics['komplikasi'] }}</td>
                <td style="font-weight: bold; font-size: 14px;">{{ $metrics['rujukan'] }}</td>
                <td style="font-weight: bold; font-size: 14px;">{{ $metrics['ttd_90'] }}</td>
                <td style="font-weight: bold; font-size: 14px;">{{ $metrics['kematian'] }}</td>
            </tr>
        </tbody>
    </table>

    <h3 style="margin-bottom: 5px; font-size: 12px; text-transform: uppercase;">Detail Data Pasien</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Ibu Hamil</th>
                <th>K1</th>
                <th>Trp Eliminasi</th>
                <th>KEK</th>
                <th>Anemia</th>
                <th>F. Risiko</th>
                <th>Komplikasi</th>
                <th>Rujukan</th>
                <th>TTD>=90</th>
                <th>Kematian</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($ibuHamils as $pasien)
                @foreach($pasien->pemeriksaanAncs as $anc)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $anc->tanggal_pemeriksaan ? $anc->tanggal_pemeriksaan->format('d/m/Y') : '-' }}</td>
                    <td class="text-left">
                        <strong>{{ $pasien->nama_lengkap }}</strong><br>
                        <span style="font-size: 9px; color: #555;">Usia: {{ $pasien->umur }} thn</span>
                    </td>
                    <td>{{ ($pasien->usia_kehamilan <= 12) ? 'Ya' : '-' }}</td>
                    <td>{{ ($anc->lab_hiv || $anc->lab_sifilis || $anc->lab_hepatitis_b) ? 'Ya' : '-' }}</td>
                    <td>{{ ($anc->lingkar_lengan_atas && $anc->lingkar_lengan_atas < 23.5) ? 'Ya' : '-' }}</td>
                    <td>{{ ($anc->lab_hb && $anc->lab_hb < 11) ? 'Ya' : '-' }}</td>
                    <td>{{ ($pasien->umur < 20 || $pasien->umur > 35 || ($anc->tinggi_badan && $anc->tinggi_badan < 145)) ? 'Ya' : '-' }}</td>
                    <td>{{ ($pasien->status_risiko_kehamilan == 'Sangat Tinggi') ? 'Ya' : '-' }}</td>
                    <td>{{ ($pasien->status_risiko_kehamilan == 'Sangat Tinggi') ? 'Ya' : '-' }}</td>
                    <td>{{ ($anc->jumlah_tablet_darah >= 90) ? 'Ya' : '-' }}</td>
                    <td>{{ ($pasien->status_ibu_meninggal == 'Meninggal') ? 'Ya' : '-' }}</td>
                </tr>
                @endforeach
            @empty
            <tr>
                <td colspan="9">Belum ada data pemeriksaan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Kota Sehat, {{ date('d M Y') }}</p>
        <p class="signature">{{ auth()->user()->name }}</p>
    </div>

</body>
</html>
