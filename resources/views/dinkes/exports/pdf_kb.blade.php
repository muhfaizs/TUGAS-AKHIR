<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekapitulasi Akseptor KB</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header h2 { margin: 5px 0 0 0; font-size: 14px; }
        .header p { margin: 5px 0 0 0; font-size: 11px; }
        .sub-header { text-align: center; margin-bottom: 20px; }
        .sub-header h3 { margin: 0; font-size: 14px; text-transform: uppercase; }
        .sub-header p { margin: 5px 0 0 0; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: center; vertical-align: middle; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-left { text-align: left; }
        .footer { margin-top: 40px; text-align: right; }
        .signature { margin-top: 60px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>DINAS KESEHATAN</h1>
        <h2>SATUKIA - SISTEM INFORMASI KIA</h2>
        <p>Laporan Pelayanan Keluarga Berencana (KB)</p>
    </div>

    <div class="sub-header">
        <h3>LAPORAN REKAPITULASI AKSEPTOR KB</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Akseptor</th>
                <th>NIK</th>
                <th>Metode KB</th>
                <th>Kunjungan Terakhir</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($akseptors as $index => $kb)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left">{{ $kb->full_name ?? '-' }}</td>
                <td>{{ $kb->nik ?? '-' }}</td>
                <td>{{ $kb->lastService()->service_method ?? '-' }}</td>
                <td>{{ $kb->lastService() && $kb->lastService()->service_date ? \Carbon\Carbon::parse($kb->lastService()->service_date)->translatedFormat('d M Y') : '-' }}</td>
                <td>{{ strtolower($kb->status) == 'active' || strtolower($kb->status) == 'aktif' ? 'Aktif' : $kb->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">Belum ada data akseptor KB</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>{{ date('d M Y') }}</p>
        <p class="signature">Dinas Kesehatan</p>
    </div>

</body>
</html>
