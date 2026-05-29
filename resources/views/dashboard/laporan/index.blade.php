@extends('layouts.dashboard')

@section('title', 'Laporan Rekapitulasi')
@section('page_title', 'Laporan Rekapitulasi')
@section('page_subtitle', 'Filter dan unduh data pengukuran, tindakan medis, dan imunisasi')

@section('content')
    <div style="background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(13,148,136,0.04); border: 1px solid rgba(15,23,42,0.06); padding: 24px; margin-bottom: 24px;">
        <form method="GET" action="{{ route('laporan.index') }}" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label for="posyandu" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Posyandu</label>
                <select name="posyandu" id="posyandu" class="form-input" style="width: 100%; appearance: none; background: url('data:image/svg+xml;utf8,<svg viewBox=\"0 0 24 24\" fill=\"%2394A3B8\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>') no-repeat right 12px center; background-color: #fff; background-size: 24px;">
                    <option value="">Semua Posyandu</option>
                    @foreach($posyanduList as $pos)
                        <option value="{{ $pos }}" {{ request('posyandu') == $pos ? 'selected' : '' }}>Posyandu ID: {{ $pos }}</option>
                    @endforeach
                </select>
            </div>
            
            <div style="flex: 1; min-width: 150px;">
                <label for="tgl_awal" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Tanggal Awal</label>
                <input type="date" name="tgl_awal" id="tgl_awal" class="form-input" value="{{ request('tgl_awal') }}" style="width: 100%;">
            </div>

            <div style="flex: 1; min-width: 150px;">
                <label for="tgl_akhir" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Tanggal Akhir</label>
                <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-input" value="{{ request('tgl_akhir') }}" style="width: 100%;">
            </div>

            <div style="display: flex; gap: 12px; margin-top: 8px;">
                <button type="submit" class="btn-primary" style="padding: 12px 24px; display: inline-flex; align-items: center; gap: 8px; font-weight: 600;">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: currentColor;"><path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/></svg>
                    Tampilkan Laporan
                </button>
                <a href="{{ route('laporan.index') }}" class="btn-secondary" style="padding: 12px 24px; display: inline-flex; align-items: center; gap: 8px; font-weight: 600;">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div style="background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(13,148,136,0.04); border: 1px solid rgba(15,23,42,0.06); overflow: hidden;">
        <div style="padding: 24px 28px; border-bottom: 1px solid rgba(15,23,42,0.06); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h3 style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0;">Hasil Laporan</h3>
                <p style="font-size: 13px; color: #64748B; margin: 2px 0 0;">Menampilkan {{ $laporan->count() }} data pengukuran sesuai filter</p>
            </div>
            
            <a href="{{ route('laporan.print', request()->all()) }}" target="_blank" class="btn-primary" style="padding: 10px 20px; display: inline-flex; align-items: center; gap: 8px; font-weight: 600; background: #0F172A; color: #fff; text-decoration: none; border-radius: 8px;">
                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: currentColor;"><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg>
                Export PDF / Cetak
            </a>
        </div>

        @if($laporan->isEmpty())
            <div style="text-align: center; padding: 48px 24px; color: #64748B;">
                <svg viewBox="0 0 24 24" style="width: 48px; height: 48px; fill: #CBD5E1; margin: 0 auto 12px; display: block;"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h-2v5H6v2h2v5h2v-5h2v-2z"/></svg>
                <p style="font-size: 15px; font-weight: 600; margin: 0 0 4px;">Tidak Ada Data</p>
                <p style="font-size: 13px; margin: 0;">Silakan sesuaikan filter untuk menemukan data.</p>
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
                                    {{ \Carbon\Carbon::parse($data->tanggal_pengukuran)->translatedFormat('d M Y') }}
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <div style="font-weight: 600; color: #0F172A; font-size: 14px;">{{ $data->anak->nama_anak ?? '-' }}</div>
                                    <div style="font-size: 12px; color: #64748B;">NIK: {{ $data->anak->nik_anak ?? '-' }}</div>
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle; font-size: 14px; color: #475569;">
                                    {{ $data->kader->id_posyandu_kader ?? '-' }}
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle; font-size: 14px; color: #475569;">
                                    <span style="font-weight: 600;">{{ $data->berat_badan }} kg</span> / <span style="font-weight: 600;">{{ $data->tinggi_badan }} cm</span>
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    @if(str_contains(strtolower($data->status_stunting), 'stunting'))
                                        <span class="badge badge-danger" style="margin-bottom: 4px; display: inline-block;">{{ $data->status_stunting }}</span><br>
                                    @endif
                                    @if(str_contains(strtolower($data->status_gizi), 'kurang') || str_contains(strtolower($data->status_gizi), 'buruk'))
                                        <span class="badge badge-warning" style="display: inline-block;">{{ $data->status_gizi }}</span>
                                    @else
                                        <span class="badge badge-success" style="display: inline-block;">{{ $data->status_gizi }}</span>
                                    @endif
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle; font-size: 13px; color: #475569;">
                                    @php
                                        // Find tindakan and imunisasi on the exact same date
                                        $tindakan = $data->anak->tindakanMedis->where('tanggal_pemeriksaan', $data->tanggal_pengukuran)->first();
                                        $imunisasi = $data->anak->imunisasi->where('tanggal_pemberian', $data->tanggal_pengukuran)->first();
                                    @endphp
                                    
                                    @if($tindakan || $imunisasi)
                                        @if($imunisasi)
                                            <div style="margin-bottom: 4px; color: #059669;">
                                                <svg viewBox="0 0 24 24" style="width: 14px; height: 14px; fill: currentColor; display: inline; vertical-align: middle; margin-top: -2px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                                Vaksin: {{ $imunisasi->nama_vaksin }}
                                            </div>
                                        @endif
                                        @if($tindakan)
                                            <div style="color: #E11D48;">
                                                <svg viewBox="0 0 24 24" style="width: 14px; height: 14px; fill: currentColor; display: inline; vertical-align: middle; margin-top: -2px;"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h-2v5H6v2h2v5h2v-5h2v-2z"/></svg>
                                                Tindakan: {{ \Illuminate\Support\Str::limit($tindakan->diagnosa, 20) }}
                                            </div>
                                        @endif
                                    @else
                                        <span style="color: #94A3B8;">-</span>
                                    @endif

                                    @if($data->anak && $data->anak->orangTua && $data->anak->orangTua->nomor_kontak)
                                        @if (auth()->user()->isBidan())
                                            <div style="margin-top: 8px;">
                                                <form action="{{ route('bidan.anak.send-notification', $data->anak->id_anak) }}" method="POST" target="_blank" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; background: rgba(34,197,94,0.1); color: #16A34A; border: none; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(34,197,94,0.2)';" onmouseout="this.style.background='rgba(34,197,94,0.1)';">
                                                        <svg viewBox="0 0 24 24" style="width: 12px; height: 12px; fill: currentColor;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                                        Kirim Laporan via WA
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
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
