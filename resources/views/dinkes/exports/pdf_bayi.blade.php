<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekapitulasi Layanan Bayi</title>
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
        <p>Laporan Pelayanan Kesehatan Ibu dan Anak</p>
    </div>

    <div class="sub-header">
        <h3>LAPORAN REKAPITULASI LAYANAN BAYI & IMUNISASI</h3>
        <p>(DATA PENGUKURAN, IMUNISASI, DAN TINDAKAN BAYI)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Lokasi/Faskes Terakhir</th>
                <th>Nama Bayi (NIK)</th>
                <th>Nama Ibu</th>
                <th>BB/TB Terakhir</th>
                <th>Status Stunting</th>
                <th>Imunisasi & Tindakan Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($anaks as $index => $anak)
            @php 
                $latest = $anak->latestPengukuran;
                $lokasiUtama = '-';
                if(isset($anak->orangTua->posyandu)) {
                    $lokasiUtama = $anak->orangTua->posyandu->nama_posyandu;
                } elseif(isset($anak->orangTua->puskesmas)) {
                    $lokasiUtama = $anak->orangTua->puskesmas->name ?? $anak->orangTua->puskesmas->nama_puskesmas ?? 'Puskesmas';
                } elseif($latest && isset($latest->kader->posyandu)) {
                    $lokasiUtama = $latest->kader->posyandu->nama_posyandu;
                } elseif($anak->tindakanMedis->count() > 0) {
                    $lastTindakan = $anak->tindakanMedis->last();
                    $lokasiUtama = $lastTindakan->bidan->puskesmas->name ?? $lastTindakan->bidan->puskesmas->nama_puskesmas ?? $lastTindakan->puskesmas->name ?? $lastTindakan->puskesmas->nama_puskesmas ?? $lastTindakan->posyandu->nama_posyandu ?? 'Faskes';
                } elseif($anak->imunisasi->count() > 0) {
                    $lastImun = $anak->imunisasi->last();
                    $lokasiUtama = $lastImun->bidan->puskesmas->name ?? $lastImun->bidan->puskesmas->nama_puskesmas ?? $lastImun->puskesmas->name ?? $lastImun->puskesmas->nama_puskesmas ?? $lastImun->posyandu->nama_posyandu ?? 'Faskes';
                }
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $lokasiUtama }}</td>
                <td class="text-left">
                    <strong>{{ $anak->nama_anak }}</strong><br>
                    <span style="font-size: 9px; color: #555;">NIK: {{ $anak->nik_anak }}</span>
                </td>
                <td>{{ $anak->nama_ibu }}</td>
                <td>{{ $latest ? $latest->berat_badan.' kg / '.$latest->tinggi_badan.' cm' : '-' }}</td>
                <td>{{ $latest ? $latest->status_stunting : '-' }}</td>
                <td class="text-left" style="font-size: 9px;">
                    @if($anak->imunisasi->count() > 0)
                        Imunisasi: {{ $anak->imunisasi->last()->nama_vaksin }}
                    @endif
                    @if($anak->tindakanMedis->count() > 0)
                        <br>Tindakan: {{ \Illuminate\Support\Str::limit($anak->tindakanMedis->last()->diagnosa, 20) }}
                    @endif
                    @if($anak->imunisasi->count() == 0 && $anak->tindakanMedis->count() == 0)
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">Belum ada data layanan bayi</td>
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
