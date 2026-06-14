<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Rujukan - {{ $ibuHamil->nama_lengkap }}</title>
    <style>
        @page {
            margin: 30px 40px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
        }
        .kop-surat p {
            margin: 5px 0 0;
            font-size: 12pt;
        }
        .tanggal {
            text-align: right;
            margin-bottom: 20px;
        }
        .tujuan {
            margin-bottom: 20px;
        }
        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 20px;
        }
        .isi-surat {
            margin-bottom: 20px;
            text-align: justify;
        }
        .data-pasien {
            margin-left: 20px;
            margin-bottom: 20px;
        }
        .data-pasien table {
            width: 100%;
        }
        .data-pasien td {
            padding: 3px 0;
            vertical-align: top;
        }
        .data-pasien td:first-child {
            width: 30%;
        }
        .data-pasien td:nth-child(2) {
            width: 2%;
        }
        .tanda-tangan {
            margin-top: 30px;
            float: right;
            text-align: center;
            width: 250px;
        }
        .tanda-tangan .nama-terang {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>PUSKESMAS BOJONGSOANG</h2>
        <p>Bidan: {{ $bidan->name }}</p>
        <p>Jl. Raya Bojongsoang No.232, Cipagalo, Kec. Bojongsoang, Kabupaten Bandung, Jawa Barat 40287</p>
    </div>

    <div class="tanggal">
        Tanggal: {{ $tanggal }}
    </div>

    <div class="tujuan">
        Yth. Dokter,<br>
        <strong>{{ $rumahSakitTujuan }}</strong><br>
        di Tempat
    </div>

    <div class="judul">
        SURAT RUJUKAN
    </div>

    <div class="isi-surat">
        <p>Dengan hormat,</p>
        <p>Mohon pemeriksaan dan penanganan lebih lanjut terhadap pasien di bawah ini:</p>

        <div class="data-pasien">
            <table>
                <tr>
                    <td>Nama Pasien</td>
                    <td>:</td>
                    <td><strong>{{ $ibuHamil->nama_lengkap }}</strong></td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td>{{ $ibuHamil->nik }}</td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td>:</td>
                    <td>{{ $ibuHamil->umur }} Tahun</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>:</td>
                    <td>{{ $ibuHamil->pekerjaan ?: '-' }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $ibuHamil->alamat }}</td>
                </tr>
                <tr>
                    <td>HPHT</td>
                    <td>:</td>
                    <td>{{ $ibuHamil->hpht ? \Carbon\Carbon::parse($ibuHamil->hpht)->translatedFormat('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td>HPL</td>
                    <td>:</td>
                    <td>{{ $ibuHamil->hpl ? \Carbon\Carbon::parse($ibuHamil->hpl)->translatedFormat('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td>Riwayat (G/P/A)</td>
                    <td>:</td>
                    <td>Gravida: {{ $ibuHamil->gravida }}, Paritas: {{ $ibuHamil->paritas }}, Abortus: {{ $ibuHamil->abortus }}</td>
                </tr>
                <tr>
                    <td>Status Risiko Kehamilan</td>
                    <td>:</td>
                    <td><strong>{{ strtoupper($ibuHamil->status_risiko_kehamilan) }}</strong></td>
                </tr>
                <tr>
                    <td>Diagnosa / Tindakan Sementara</td>
                    <td>:</td>
                    <td>{{ $ibuHamil->tindakan_medis ?: 'Belum ada catatan tindakan medis.' }}</td>
                </tr>
            </table>
        </div>

        <p>Pasien memiliki status risiko kehamilan <strong>Sangat Tinggi</strong> berdasarkan hasil pemeriksaan awal. Kami memohon agar pasien segera mendapatkan penanganan medis secara komprehensif.</p>
        
        <p>Demikian surat rujukan ini kami buat, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
    </div>

    <div class="tanda-tangan">
        Hormat Kami,<br>
        Bidan Perujuk,
        <div class="nama-terang">{{ $bidan->name }}</div>
    </div>

    <div class="clear"></div>

</body>
</html>
