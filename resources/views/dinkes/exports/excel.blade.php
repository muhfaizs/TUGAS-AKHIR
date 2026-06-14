<table>
    <thead>
        <tr>
            <th colspan="9" style="font-size: 16px; font-weight: bold; text-align: center;">LAPORAN REKAPITULASI PELAYANAN KESEHATAN IBU HAMIL</th>
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
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000; text-align: center;">No</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000; text-align: center;">Tanggal</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000; text-align: center;">Nama Ibu Hamil</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000; text-align: center;">K1</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000; text-align: center;">Trp Eliminasi</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000; text-align: center;">KEK</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000; text-align: center;">Anemia</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000; text-align: center;">F. Risiko</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000; text-align: center;">Komplikasi</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000; text-align: center;">Rujukan</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000; text-align: center;">TTD>=90</th>
            <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000; text-align: center;">Kematian</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ibuHamils as $index => $pasien)
        @php 
            $hasK1 = false;
            $hasTripleEliminasi = false;
            $hasKek = false;
            $hasAnemia = false;
            $hasTtd90 = false;
            $hasFaktorRisiko = ($pasien->umur < 20 || $pasien->umur > 35);
            
            foreach ($pasien->pemeriksaanAncs as $anc) {
                if ($anc->usia_kehamilan_minggu <= 12) $hasK1 = true;
                if ($anc->lab_hiv || $anc->lab_sifilis || $anc->lab_hepatitis_b) $hasTripleEliminasi = true;
                if ($anc->lingkar_lengan_atas && $anc->lingkar_lengan_atas < 23.5) $hasKek = true;
                if ($anc->lab_hb && $anc->lab_hb < 11) $hasAnemia = true;
                if ($anc->tinggi_badan && $anc->tinggi_badan < 145) $hasFaktorRisiko = true;
                if ($anc->jumlah_tablet_darah >= 90) $hasTtd90 = true;
            }
            
            $hasKomplikasi = ($pasien->status_risiko_kehamilan == 'Sangat Tinggi');
            $hasRujukan = ($pasien->status_risiko_kehamilan == 'Sangat Tinggi');
            $hasKematian = ($pasien->status_ibu_meninggal == 'Meninggal');
        @endphp
        <tr>
            <td style="border: 1px solid #000; text-align: center;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $pasien->tanggal_registrasi_pasien ? $pasien->tanggal_registrasi_pasien->format('d/m/Y') : '-' }}</td>
            <td style="border: 1px solid #000;">{{ $pasien->nama_lengkap }} (Usia: {{ $pasien->umur }} thn)</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $hasK1 ? 'Ya' : '-' }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $hasTripleEliminasi ? 'Ya' : '-' }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $hasKek ? 'Ya' : '-' }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $hasAnemia ? 'Ya' : '-' }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $hasFaktorRisiko ? 'Ya' : '-' }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $hasKomplikasi ? 'Ya' : '-' }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $hasRujukan ? 'Ya' : '-' }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $hasTtd90 ? 'Ya' : '-' }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $hasKematian ? 'Ya' : '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="12" style="border: 1px solid #000; text-align: center;">Belum ada data pemeriksaan ibu hamil.</td>
        </tr>
        @endforelse
    </tbody>
</table>
