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
                <p style="font-size: 13px; color: #64748B; margin: 2px 0 0;">Pengirim: {{ $laporanDinkes->bidan->nama_lengkap ?? '-' }} | Total: {{ count($laporan) }} data | Disubmit pada: {{ $laporanDinkes->created_at->translatedFormat('d M Y, H:i') }}</p>
            </div>
        </div>

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
    </div>

    <style>
        .badge-success { background: rgba(16, 185, 129, 0.1); color: #059669; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-warning { background: rgba(245, 158, 11, 0.1); color: #D97706; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-danger { background: rgba(239, 68, 68, 0.1); color: #DC2626; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
    </style>
@endsection
