<table>
    <thead>
        <tr>
            <th colspan="9" style="font-size: 16px; font-weight: bold; text-align: center;">{{ strtoupper($title ?? 'LAPORAN KESEHATAN IBU HAMIL') }}</th>
        </tr>
        <tr>
            <th colspan="9" style="font-size: 12px; text-align: center;">Periode: {{ $periode ?? '-' }}</th>
        </tr>
        <tr>
            <th colspan="9" style="font-size: 12px; text-align: center;">Ringkasan Indikator (Berdasarkan Filter)</th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f2f2f2;">K1</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f2f2f2;">Triple Eliminasi</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f2f2f2;">Gizi Buruk (KEK)</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f2f2f2;">Kasus Anemia</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f2f2f2;">Faktor Risiko</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f2f2f2;">Komplikasi</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f2f2f2;">Rujukan FKRTL</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f2f2f2;">TTD >= 90</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center; background-color: #f2f2f2;">Kematian Ibu</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #000; text-align: center; font-weight: bold;">{{ $metrics['k1'] }}</td>
            <td style="border: 1px solid #000; text-align: center; font-weight: bold;">{{ $metrics['triple_eliminasi'] }}</td>
            <td style="border: 1px solid #000; text-align: center; font-weight: bold;">{{ $metrics['kek'] }}</td>
            <td style="border: 1px solid #000; text-align: center; font-weight: bold;">{{ $metrics['anemia'] }}</td>
            <td style="border: 1px solid #000; text-align: center; font-weight: bold;">{{ $metrics['faktor_risiko'] }}</td>
            <td style="border: 1px solid #000; text-align: center; font-weight: bold;">{{ $metrics['komplikasi'] }}</td>
            <td style="border: 1px solid #000; text-align: center; font-weight: bold;">{{ $metrics['rujukan'] }}</td>
            <td style="border: 1px solid #000; text-align: center; font-weight: bold;">{{ $metrics['ttd_90'] }}</td>
            <td style="border: 1px solid #000; text-align: center; font-weight: bold;">{{ $metrics['kematian'] }}</td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th colspan="12" style="font-size: 12px; text-align: center; height: 30px;">Detail Data Pasien</th>
        </tr>
        <tr>
            <th colspan="12" style="font-size: 12px; text-align: center;">Bidan: {{ auth()->user()->name }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000;">No</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000;">Tanggal</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000;">Nama Ibu Hamil</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000;">K1</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000;">Trp Eliminasi</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000;">KEK</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000;">Anemia</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000;">F. Risiko</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000;">Komplikasi</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000;">Rujukan</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000;">TTD>=90</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000;">Kematian</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @forelse($ibuHamils as $pasien)
            @foreach($pasien->pemeriksaanAncs as $anc)
            <tr>
                <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ $anc->tanggal_pemeriksaan ? $anc->tanggal_pemeriksaan->format('d/m/Y') : '-' }}</td>
                <td style="border: 1px solid #000;">{{ $pasien->nama_lengkap }} (Usia: {{ $pasien->umur }} thn)</td>
                <td style="border: 1px solid #000; text-align: center;">{{ ($pasien->usia_kehamilan <= 12) ? 'Ya' : '-' }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ ($anc->lab_hiv || $anc->lab_sifilis || $anc->lab_hepatitis_b) ? 'Ya' : '-' }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ ($anc->lingkar_lengan_atas && $anc->lingkar_lengan_atas < 23.5) ? 'Ya' : '-' }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ ($anc->lab_hb && $anc->lab_hb < 11) ? 'Ya' : '-' }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ ($pasien->umur < 20 || $pasien->umur > 35 || ($anc->tinggi_badan && $anc->tinggi_badan < 145)) ? 'Ya' : '-' }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ ($pasien->status_risiko_kehamilan == 'Sangat Tinggi') ? 'Ya' : '-' }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ ($pasien->status_risiko_kehamilan == 'Sangat Tinggi') ? 'Ya' : '-' }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ ($anc->jumlah_tablet_darah >= 90) ? 'Ya' : '-' }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ ($pasien->status_ibu_meninggal == 'Meninggal') ? 'Ya' : '-' }}</td>
            </tr>
            @endforeach
        @empty
        <tr>
            <td colspan="12" style="border: 1px solid #000; text-align: center;">Belum ada data pemeriksaan</td>
        </tr>
        @endforelse
    </tbody>
</table>
