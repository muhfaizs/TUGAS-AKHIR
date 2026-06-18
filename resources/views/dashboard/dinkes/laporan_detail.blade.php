@extends('layouts.dashboard')

@section('title', 'Detail Laporan Rekapitulasi')
@section('page_title', 'Detail Laporan: ' . $laporanDinkes->nama_puskesmas)
@section('page_subtitle', 'Periode: ' . \Carbon\Carbon::parse($laporanDinkes->periode_awal)->translatedFormat('d M Y') . ' - ' . \Carbon\Carbon::parse($laporanDinkes->periode_akhir)->translatedFormat('d M Y'))

@section('content')
    <div style="margin-bottom: 24px;">
        <a href="{{ route('dashboard') }}" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; color: #475569; text-decoration: none; padding: 8px 16px; background: #F1F5F9; border-radius: 8px;">
            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: currentColor;"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div style="background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(13,148,136,0.04); border: 1px solid rgba(15,23,42,0.06); overflow: hidden;">
        <div style="padding: 24px 28px; border-bottom: 1px solid rgba(15,23,42,0.06); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h3 style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0;">Data Laporan Rekapitulasi</h3>
                @php
                    $totalData = 0;
                    if ($laporanDinkes->jenis_laporan === 'KB') {
                        $totalData = isset($laporan->detailLayanan) ? count((array)$laporan->detailLayanan) : (isset($laporan['detailLayanan']) ? count($laporan['detailLayanan']) : 0);
                    } elseif ($laporanDinkes->jenis_laporan === 'Ibu Hamil') {
                        $totalData = isset($laporan->ibuHamils) ? count((array)$laporan->ibuHamils) : (isset($laporan['ibuHamils']) ? count($laporan['ibuHamils']) : 0);
                    } else {
                        $totalData = is_array($laporan) || $laporan instanceof \Countable ? count($laporan) : 0;
                    }
                @endphp
                <p style="font-size: 13px; color: #64748B; margin: 2px 0 0;">Pengirim: {{ $laporanDinkes->bidan->nama_lengkap ?? '-' }} | Total: {{ $totalData }} data | Disubmit pada: {{ $laporanDinkes->created_at->translatedFormat('d M Y, H:i') }}</p>
            </div>
        </div>

        @if($laporanDinkes->jenis_laporan === 'KB')
            @php
                $kbData = isset($laporan->laporanData) ? $laporan->laporanData : [];
                $kbDetail = isset($laporan->detailLayanan) ? $laporan->detailLayanan : [];
                $totalBaru = 0;
                $totalAktif = 0;
                foreach($kbData as $k) {
                    $totalBaru += $k->baru;
                    $totalAktif += $k->aktif;
                }
            @endphp
            <div style="padding: 24px;">
                <h4 style="font-weight: 700; color: #0F172A; margin-bottom: 16px; font-size: 15px;">Rekapitulasi Pelayanan KB (Bulan {{ isset($laporan->bulan) ? \Carbon\Carbon::create()->month((int) $laporan->bulan)->translatedFormat('F') : '' }} {{ $laporan->tahun ?? '' }})</h4>
                <div style="overflow-x: auto; margin-bottom: 32px;">
                    <table style="width: 100%; border-collapse: collapse; min-width: 600px; text-align: center; border: 1px solid rgba(15,23,42,0.06);">
                        <thead style="background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">
                            <tr>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B; border-right: 1px solid rgba(15,23,42,0.06);" rowspan="2">Metode Kontrasepsi</th>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B; border-bottom: 1px solid rgba(15,23,42,0.06);" colspan="2">Jumlah Peserta KB</th>
                            </tr>
                            <tr>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B; border-right: 1px solid rgba(15,23,42,0.06);">Baru</th>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B;">Aktif</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kbData as $k)
                            <tr style="border-bottom: 1px solid rgba(15,23,42,0.04);">
                                <td style="padding: 12px; font-size: 14px; font-weight: 500; text-align: left; border-right: 1px solid rgba(15,23,42,0.06);">{{ $k->metode }}</td>
                                <td style="padding: 12px; font-size: 14px; color: #475569; border-right: 1px solid rgba(15,23,42,0.06);">{{ $k->baru }}</td>
                                <td style="padding: 12px; font-size: 14px; color: #475569;">{{ $k->aktif }}</td>
                            </tr>
                            @endforeach
                            <tr style="background: #F8FAFC; font-weight: 700;">
                                <td style="padding: 12px; font-size: 14px; text-align: right; border-right: 1px solid rgba(15,23,42,0.06);">TOTAL</td>
                                <td style="padding: 12px; font-size: 14px; color: #0F172A; border-right: 1px solid rgba(15,23,42,0.06);">{{ $totalBaru }}</td>
                                <td style="padding: 12px; font-size: 14px; color: #0F172A;">{{ $totalAktif }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4 style="font-weight: 700; color: #0F172A; margin-bottom: 16px; font-size: 15px;">Daftar Rincian Pelayanan Pasien</h4>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; min-width: 800px; text-align: left; border: 1px solid rgba(15,23,42,0.06);">
                        <thead style="background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">
                            <tr>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B;">Nama Akseptor</th>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B;">Metode</th>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B;">Tanggal</th>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B;">Lokasi</th>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B;">Keluhan / Risko</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kbDetail as $d)
                            <tr style="border-bottom: 1px solid rgba(15,23,42,0.04);">
                                <td style="padding: 12px;">
                                    <div style="font-weight: 600; font-size: 14px; color: #0F172A;">{{ $d->acceptor->full_name ?? $d->akseptor_name ?? '-' }}</div>
                                    <div style="font-size: 12px; color: #64748B;">{{ $d->acceptor->nik ?? '-' }}</div>
                                </td>
                                <td style="padding: 12px; font-size: 14px; color: #475569;">{{ $d->service_method }}</td>
                                <td style="padding: 12px; font-size: 14px; color: #475569;">{{ \Carbon\Carbon::parse($d->service_date)->translatedFormat('d M Y') }}</td>
                                <td style="padding: 12px; font-size: 14px; color: #475569;">{{ $d->location }}</td>
                                <td style="padding: 12px; font-size: 14px; color: #475569;">{{ $d->side_effects ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="padding: 24px; text-align: center; color: #64748B; font-size: 14px;">Tidak ada data pelayanan bulan ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($laporanDinkes->jenis_laporan === 'Ibu Hamil')
            @php
                $ihData = is_array($laporan) ? $laporan : (is_object($laporan) ? (array) $laporan : []);
                $ihType = $ihData['type'] ?? 'bulanan';
                $ihBulan = $ihData['bulan'] ?? '';
                $ihTahun = $ihData['tahun'] ?? '';
                $ihMetrics = isset($ihData['metrics']) ? (is_object($ihData['metrics']) ? (array) $ihData['metrics'] : $ihData['metrics']) : [];
                $ihPasiens = isset($ihData['ibuHamils']) ? collect($ihData['ibuHamils'])->map(function($item) { return is_object($item) ? $item : json_decode(json_encode($item)); }) : collect();
                $months = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
                $periodeLabel = $ihType == 'bulanan' ? 'Bulan '.($months[$ihBulan] ?? $ihBulan).' '.$ihTahun : 'Tahun '.$ihTahun;
            @endphp
            <div style="padding: 24px;">
                <h4 style="font-weight: 700; color: #0F172A; margin-bottom: 16px; font-size: 15px;">Laporan Pemeriksaan ANC - {{ $periodeLabel }}</h4>

                {{-- Summary Metrics --}}
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; margin-bottom: 24px;">
                    @php
                        $metricItems = [
                            ['label' => 'K1 (Trimester 1)', 'key' => 'k1', 'color' => '#0D9488'],
                            ['label' => 'Triple Eliminasi', 'key' => 'triple_eliminasi', 'color' => '#6366F1'],
                            ['label' => 'Gizi Buruk (KEK)', 'key' => 'kek', 'color' => '#EA580C'],
                            ['label' => 'Kasus Anemia', 'key' => 'anemia', 'color' => '#DC2626'],
                            ['label' => 'Faktor Risiko', 'key' => 'faktor_risiko', 'color' => '#9333EA'],
                            ['label' => 'Komplikasi', 'key' => 'komplikasi', 'color' => '#EC4899'],
                            ['label' => 'Rujukan FKRTL', 'key' => 'rujukan', 'color' => '#D97706'],
                            ['label' => 'TTD >= 90', 'key' => 'ttd_90', 'color' => '#059669'],
                            ['label' => 'Kematian Ibu', 'key' => 'kematian', 'color' => '#334155'],
                        ];
                    @endphp
                    @foreach($metricItems as $mi)
                        <div style="background: #F8FAFC; border-radius: 12px; padding: 14px 16px; border: 1px solid rgba(15,23,42,0.06);">
                            <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; color: #64748B; letter-spacing: 0.05em;">{{ $mi['label'] }}</div>
                            <div style="font-size: 22px; font-weight: 800; color: {{ $mi['color'] }}; margin-top: 4px;">{{ $ihMetrics[$mi['key']] ?? 0 }}</div>
                        </div>
                    @endforeach
                </div>

                {{-- Data Table --}}
                <h4 style="font-weight: 700; color: #0F172A; margin-bottom: 16px; font-size: 15px;">Daftar Data Pasien</h4>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; min-width: 900px; text-align: left; border: 1px solid rgba(15,23,42,0.06);">
                        <thead style="background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">
                            <tr>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B;">Nama Pasien</th>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B;">Usia</th>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B;">Usia Kehamilan</th>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B;">Risiko</th>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B;">Gravida</th>
                                <th style="padding: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B;">Jml Pemeriksaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ihPasiens as $pasien)
                            <tr style="border-bottom: 1px solid rgba(15,23,42,0.04);">
                                <td style="padding: 12px;">
                                    <div style="font-weight: 600; font-size: 14px; color: #0F172A;">{{ $pasien->nama_lengkap ?? '-' }}</div>
                                    <div style="font-size: 12px; color: #64748B;">NIK: {{ $pasien->nik ?? '-' }}</div>
                                </td>
                                <td style="padding: 12px; font-size: 14px; color: #475569;">{{ $pasien->umur ?? '-' }} thn</td>
                                <td style="padding: 12px; font-size: 14px; color: #475569;">{{ $pasien->usia_kehamilan ?? '-' }} minggu</td>
                                <td style="padding: 12px;">
                                    @php $risiko = $pasien->status_risiko_kehamilan ?? 'Rendah'; @endphp
                                    @if($risiko === 'Sangat Tinggi')
                                        <span style="background: rgba(239,68,68,0.1); color: #DC2626; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">{{ $risiko }}</span>
                                    @elseif($risiko === 'Tinggi')
                                        <span style="background: rgba(244,63,94,0.1); color: #E11D48; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">{{ $risiko }}</span>
                                    @else
                                        <span style="background: rgba(16,185,129,0.1); color: #059669; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">{{ $risiko }}</span>
                                    @endif
                                </td>
                                <td style="padding: 12px; font-size: 14px; color: #475569;">G{{ $pasien->gravida ?? '-' }}P{{ $pasien->paritas ?? '-' }}A{{ $pasien->abortus ?? '-' }}</td>
                                <td style="padding: 12px; font-size: 14px; color: #475569;">{{ $pasien->jumlah_pemeriksaan_anc ?? 0 }}x</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="padding: 24px; text-align: center; color: #64748B; font-size: 14px;">Tidak ada data pasien.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            @if(count($laporan) == 0)
                <div style="text-align: center; padding: 48px 24px; color: #64748B;">
                    <svg viewBox="0 0 24 24" style="width: 48px; height: 48px; fill: #CBD5E1; margin: 0 auto 12px; display: block;"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h-2v5H6v2h2v5h2v-5h2v-2z"/></svg>
                    <p style="font-size: 15px; font-weight: 600; margin: 0 0 4px;">Tidak Ada Data</p>
                </div>
            @else
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; min-width: 900px; text-align: left;">
                        <thead>
                            <tr>
                                <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Tanggal</th>
                                <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Nama Anak</th>
                                <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Posyandu</th>
                                <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">BB / TB</th>
                                <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Status Gizi</th>
                                <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Tindakan & Imunisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporan as $data)
                                <tr style="transition: background 0.15s; border-bottom: 1px solid rgba(15,23,42,0.04);">
                                    <td style="padding: 16px 24px; vertical-align: middle; font-size: 14px; color: #0F172A; font-weight: 500;">
                                        {{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') }}
                                    </td>
                                    <td style="padding: 16px 24px; vertical-align: middle;">
                                        <div style="font-weight: 600; color: #0F172A; font-size: 14px;">{{ $data->anak->nama_anak ?? '-' }}</div>
                                        <div style="font-size: 12px; color: #64748B;">NIK: {{ $data->anak->nik_anak ?? '-' }}</div>
                                    </td>
                                    <td style="padding: 16px 24px; vertical-align: middle; font-size: 14px; color: #475569;">
                                        <div style="font-weight: 600; color: #0F172A;">{{ $data->posyandu ?? '-' }}</div>
                                        @if(isset($data->pelaksana) && count($data->pelaksana) > 0)
                                            <div style="font-size: 11px; color: #64748B; margin-top: 4px;">{{ implode(', ', $data->pelaksana) }}</div>
                                        @endif
                                    </td>
                                    <td style="padding: 16px 24px; vertical-align: middle; font-size: 14px; color: #475569;">
                                        @if(isset($data->pengukuran))
                                            <span style="font-weight: 600;">{{ $data->pengukuran->berat_badan }} kg</span> / <span style="font-weight: 600;">{{ $data->pengukuran->tinggi_badan }} cm</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td style="padding: 16px 24px; vertical-align: middle;">
                                        @if(isset($data->pengukuran))
                                            @if(isset($data->pengukuran->status_stunting) && str_contains(strtolower($data->pengukuran->status_stunting), 'stunting'))
                                                <span class="badge badge-danger" style="margin-bottom: 4px; display: inline-block;">{{ $data->pengukuran->status_stunting }}</span><br>
                                            @endif
                                            @if(isset($data->pengukuran->status_gizi))
                                                @if(str_contains(strtolower($data->pengukuran->status_gizi), 'kurang') || str_contains(strtolower($data->pengukuran->status_gizi), 'buruk'))
                                                    <span class="badge badge-warning" style="display: inline-block;">{{ $data->pengukuran->status_gizi }}</span>
                                                @else
                                                    <span class="badge badge-success" style="display: inline-block;">{{ $data->pengukuran->status_gizi }}</span>
                                                @endif
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td style="padding: 16px 24px; vertical-align: middle; font-size: 13px; color: #475569;">
                                        @if(isset($data->tindakan) || isset($data->imunisasi))
                                            @if(isset($data->imunisasi))
                                                <div style="margin-bottom: 4px; color: #059669;">
                                                    <svg viewBox="0 0 24 24" style="width: 14px; height: 14px; fill: currentColor; display: inline; vertical-align: middle; margin-top: -2px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                                    Vaksin: {{ $data->imunisasi->nama_vaksin }}
                                                </div>
                                            @endif
                                            @if(isset($data->tindakan))
                                                <div style="color: #E11D48;">
                                                    <svg viewBox="0 0 24 24" style="width: 14px; height: 14px; fill: currentColor; display: inline; vertical-align: middle; margin-top: -2px;"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h-2v5H6v2h2v5h2v-5h2v-2z"/></svg>
                                                    Tindakan: {{ \Illuminate\Support\Str::limit($data->tindakan->diagnosa, 20) }}
                                                </div>
                                            @endif
                                        @else
                                            <span style="color: #94A3B8;">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
    </div>

    <style>
        .badge-success { background: rgba(16, 185, 129, 0.1); color: #059669; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-warning { background: rgba(245, 158, 11, 0.1); color: #D97706; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-danger { background: rgba(239, 68, 68, 0.1); color: #DC2626; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
    </style>
@endsection
