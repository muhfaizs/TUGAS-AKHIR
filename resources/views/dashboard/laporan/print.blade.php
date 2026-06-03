<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Pelayanan KIA & Gizi</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            margin: 0;
            padding: 20px 40px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 5px 0 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 12px;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .filter-info {
            font-size: 12px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
        }
        th {
            background-color: #f0f0f0;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        
        .footer {
            margin-top: 40px;
            width: 100%;
        }
        .footer-signature {
            float: right;
            text-align: center;
            width: 250px;
        }
        
        @media print {
            body { padding: 0; }
            @page { size: landscape; margin: 15mm; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h1>DINAS KESEHATAN KOTA</h1>
        <h2>PUSKESMAS SATUKIA</h2>
        <p>Jl. Kesehatan No. 123, Kota Sehat, Provinsi Jawa Barat - Telp. (021) 1234567</p>
    </div>

    <div class="title">
        LAPORAN REKAPITULASI PELAYANAN KESEHATAN IBU DAN ANAK<br>
        (PENGUKURAN GIZI, TINDAKAN MEDIS, & IMUNISASI)
    </div>

    <div class="filter-info">
        <strong>Filter Diterapkan:</strong><br>
        Puskesmas: {{ request('puskesmas') ? \App\Models\Puskesmas::find(request('puskesmas'))->nama_puskesmas ?? 'Semua Puskesmas' : 'Semua Puskesmas' }} <br>
        Periode: {{ request('tgl_awal') ? \Carbon\Carbon::parse(request('tgl_awal'))->translatedFormat('d M Y') : 'Awal' }} 
        s/d 
        {{ request('tgl_akhir') ? \Carbon\Carbon::parse(request('tgl_akhir'))->translatedFormat('d M Y') : 'Sekarang' }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">Tanggal</th>
                <th width="15%">Nama Anak</th>
                <th width="15%">Posyandu</th>
                <th width="10%">BB / TB</th>
                <th width="12%">Status Gizi</th>
                <th width="35%">Tindakan Medis & Imunisasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $data)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') }}</td>
                    <td>
                        <strong>{{ $data->anak->nama_anak ?? '-' }}</strong><br>
                        NIK: {{ $data->anak->nik_anak ?? '-' }}
                    </td>
                    <td>
                        {{ $data->posyandu }}<br>
                        @if(count($data->pelaksana) > 0)
                            <span style="font-size: 10px;">({{ implode(', ', $data->pelaksana) }})</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($data->pengukuran)
                            {{ $data->pengukuran->berat_badan }} kg / {{ $data->pengukuran->tinggi_badan }} cm
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if($data->pengukuran)
                            {{ $data->pengukuran->status_gizi }}<br>
                            @if(str_contains(strtolower($data->pengukuran->status_stunting), 'stunting'))
                                ({{ $data->pengukuran->status_stunting }})
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($data->imunisasi)
                            <strong>Vaksin:</strong> {{ $data->imunisasi->nama_vaksin }}<br>
                        @endif
                        
                        @if($data->tindakan)
                            <strong>Tindakan:</strong> {{ $data->tindakan->diagnosa }}
                        @endif
                        
                        @if(!$data->imunisasi && !$data->tindakan)
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data yang ditemukan pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="footer-signature">
            <p>Kota Sehat, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p><strong>Kepala Puskesmas / Dinas</strong></p>
            <br><br><br><br>
            <p>_______________________</p>
            <p>NIP. ..............................</p>
        </div>
    </div>

</body>
</html>
