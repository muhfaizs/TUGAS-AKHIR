<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pelayanan KB Tahun {{ $year }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #105448; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #105448; font-size: 20px; }
        .header p { margin: 5px 0 0; color: #555; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #105448; color: white; }
        .footer { margin-top: 50px; text-align: right; }
        .footer .signature { margin-top: 60px; font-weight: bold; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .badge-draft { background: #e2e8f0; color: #475569; }
        .badge-submitted { background: #fef08a; color: #854d0e; }
        .badge-verified { background: #bbf7d0; color: #166534; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Pelayanan Keluarga Berencana (KB)</h1>
        <p>Tahun Periode: <strong>{{ $year }}</strong> | Status: <span class="badge badge-{{ $report->status }}">{{ strtoupper($report->status) }}</span></p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Layanan</th>
                <th>Nama Akseptor</th>
                <th>Metode KB</th>
                <th>Bidan Bertugas</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $index => $service)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($service->service_date ?? $service->created_at)->format('d/m/Y') }}</td>
                <td>{{ $service->acceptor->full_name ?? '-' }}</td>
                <td>{{ $service->service_method }}</td>
                <td>{{ $service->creator->name ?? $service->bidan->name ?? '-' }}</td>
                <td>{{ $service->puskesmasData->name ?? $service->location ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data pelayanan KB pada tahun ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dibuat oleh,</p>
        <div class="signature">
            {{ $report->submittedBy->name ?? 'Bidan' }}
        </div>
    </div>
</body>
</html>
