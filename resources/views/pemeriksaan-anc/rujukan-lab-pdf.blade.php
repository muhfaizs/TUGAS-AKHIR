<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar Laboratorium - {{ $ibuHamil->nama_lengkap }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            color: #000;
            line-height: 1.5;
            margin: 20px;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .kop-surat p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .judul-surat {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            text-decoration: underline;
            margin-bottom: 30px;
        }
        .tujuan {
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
            width: 150px;
        }
        .pemeriksaan-list {
            margin-left: 20px;
            margin-bottom: 30px;
        }
        .pemeriksaan-list table {
            width: 80%;
            border-collapse: collapse;
        }
        .pemeriksaan-list th, .pemeriksaan-list td {
            border: 1px solid #000;
            padding: 5px 10px;
            text-align: left;
        }
        .pemeriksaan-list th {
            background-color: #f0f0f0;
        }
        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 5px;
        }
        .checkbox.checked {
            background-color: #000;
        }
        .ttd-container {
            width: 100%;
            margin-top: 50px;
        }
        .ttd-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .ttd-box p {
            margin: 0 0 70px 0;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h1>PUSKESMAS BOJONGSOANG</h1>
        <p>Jl. Raya Bojongsoang No.232, Cipagalo, Kec. Bojongsoang, Kabupaten Bandung, Jawa Barat 40287</p>
    </div>

    <div class="tujuan">
        Yth. Bagian Laboratorium,<br>
        <strong>Puskesmas Bojongsoang</strong><br>
        di Tempat
    </div>

    <div class="judul-surat">
        SURAT PENGANTAR PEMERIKSAAN LABORATORIUM
    </div>

    <div class="isi-surat">
        Dengan hormat,<br>
        Mohon bantuan sejawat untuk dapat dilakukan pemeriksaan laboratorium terhadap pasien ibu hamil berikut:
    </div>

    <div class="data-pasien">
        <table>
            <tr>
                <td>Nama Pasien</td>
                <td>: {{ $ibuHamil->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Umur</td>
                <td>: {{ $ibuHamil->umur }} Tahun</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $ibuHamil->alamat }}</td>
            </tr>
            <tr>
                <td>Status Kehamilan</td>
                <td>: G{{ $ibuHamil->gravida }} P{{ $ibuHamil->paritas }} A{{ $ibuHamil->abortus }} (Trimester {{ explode(' ', $anc->trimester)[1] ?? '-' }})</td>
            </tr>
        </table>
    </div>

    <div class="isi-surat">
        Adapun pemeriksaan yang kami minta (ANC Terpadu):
    </div>

    <div class="pemeriksaan-list">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">Cek</th>
                    <th style="width: 40%;">Jenis Pemeriksaan Laboratorium</th>
                    <th>Hasil Pemeriksaan (Diisi oleh Petugas Lab)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;"><div class="checkbox"></div></td>
                    <td>Darah Rutin / Hemoglobin (Hb)</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: center;"><div class="checkbox"></div></td>
                    <td>Protein Urine</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: center;"><div class="checkbox"></div></td>
                    <td>Golongan Darah</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: center;"><div class="checkbox"></div></td>
                    <td>Sifilis</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: center;"><div class="checkbox"></div></td>
                    <td>HIV</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: center;"><div class="checkbox"></div></td>
                    <td>Hepatitis B (HBsAg)</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="isi-surat">
        Atas bantuan dan kerjasamanya, kami ucapkan terima kasih.
    </div>

    <div class="ttd-container clearfix">
        <div class="ttd-box">
            <p>Bojongsoang, {{ $tanggal }}<br>Bidan Pengirim,</p>
            <strong>{{ $bidan->name }}</strong>
        </div>
    </div>

</body>
</html>
