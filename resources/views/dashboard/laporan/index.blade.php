@extends('layouts.dashboard')

@section('title', 'Laporan Rekapitulasi')
@section('page_title', 'Laporan Rekapitulasi')
@section('page_subtitle', 'Filter dan unduh data pengukuran, tindakan medis, dan imunisasi')

@section('content')
    <div style="background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(13,148,136,0.04); border: 1px solid rgba(15,23,42,0.06); padding: 24px; margin-bottom: 24px;">
        <form method="GET" action="{{ route('laporan.index') }}" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end;">
            
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Puskesmas</label>
                <select name="puskesmas" class="form-control" style="width: 100%; border: 1px solid #CBD5E1; border-radius: 8px; padding: 10px 14px; background: #fff; font-size: 14px; outline: none; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" onfocus="this.style.borderColor='#0D9488'; this.style.boxShadow='0 0 0 3px rgba(13, 148, 136, 0.1)';" onblur="this.style.borderColor='#CBD5E1'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)';">
                    <option value="">Semua Puskesmas</option>
                    @foreach($puskesmasList as $pusk)
                        <option value="{{ $pusk->id }}" {{ request('puskesmas') == $pusk->id ? 'selected' : '' }}>
                            {{ $pusk->nama_puskesmas }}
                        </option>
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

    <form method="POST" action="{{ route('bidan.laporan.submit') }}">
        @csrf
        <input type="hidden" name="posyandu" value="{{ request('posyandu') }}">
        <input type="hidden" name="tgl_awal" value="{{ request('tgl_awal') }}">
        <input type="hidden" name="tgl_akhir" value="{{ request('tgl_akhir') }}">

        <div style="background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(13,148,136,0.04); border: 1px solid rgba(15,23,42,0.06); overflow: hidden;">
            <div style="padding: 24px 28px; border-bottom: 1px solid rgba(15,23,42,0.06); display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0;">Hasil Laporan</h3>
                    <p style="font-size: 13px; color: #64748B; margin: 2px 0 0;">Menampilkan {{ $laporan->count() }} data pengukuran sesuai filter</p>
                </div>
                
                <div style="display: flex; gap: 12px; align-items: center;">
                    @if(!$laporan->isEmpty())
                        <a href="{{ route('laporan.print', request()->all()) }}" target="_blank" class="btn-primary" style="padding: 10px 20px; display: inline-flex; align-items: center; gap: 8px; font-weight: 600; background: #0F172A; color: #fff; text-decoration: none; border-radius: 8px;">
                            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: currentColor;"><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg>
                            Export PDF
                        </a>

                        <a href="{{ route('laporan.excel', request()->all()) }}" target="_blank" class="btn-primary" style="padding: 10px 20px; display: inline-flex; align-items: center; gap: 8px; font-weight: 600; background: #16A34A; color: #fff; text-decoration: none; border-radius: 8px;">
                            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: currentColor;"><path d="M21.17 3.25Q21.5 3.25 21.76 3.5 22 3.74 22 4.08V19.92Q22 20.26 21.76 20.5 21.5 20.75 21.17 20.75H7.83Q7.5 20.75 7.24 20.5 7 20.26 7 19.92V17H2.83Q2.5 17 2.24 16.76 2 16.5 2 16.17V7.83Q2 7.5 2.24 7.24 2.5 7 2.83 7H7V4.08Q7 3.74 7.24 3.5 7.5 3.25 7.83 3.25M7 13.06L8.18 15.28H9.97L8 12.06L9.93 8.89H8.22L7.13 10.9L6.04 8.89H4.26L6.19 12.06L4.25 15.28H6.04ZM17 15.5V13H11V15.5ZM17 11.5V9H11V11.5ZM17 7.5V5H11V7.5Z"/></svg>
                            Export Excel
                        </a>

                        @if (auth()->user()->isBidan())
                            <button type="submit" class="btn-primary" style="padding: 10px 20px; display: inline-flex; align-items: center; gap: 8px; font-weight: 600; background: #0D9488; color: #fff; border: none; border-radius: 8px; cursor: pointer;">
                                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: currentColor;"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                                Submit ke Dinkes
                            </button>
                        @endif
                    @endif
                </div>
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
                            @if(auth()->user()->isBidan())
                                <th style="padding: 14px 24px; text-align: center; width: 50px; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">
                                    <input type="checkbox" id="selectAll" style="cursor: pointer;">
                                </th>
                            @endif
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
                                @if(auth()->user()->isBidan())
                                    <td style="padding: 16px 24px; text-align: center; vertical-align: middle;">
                                        <input type="checkbox" name="selected_laporan[]" class="laporan-checkbox" value="{{ $data->id }}" style="cursor: pointer;">
                                    </td>
                                @endif
                                <td style="padding: 16px 24px; vertical-align: middle; font-size: 14px; color: #0F172A; font-weight: 500;">
                                    {{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') }}
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <div style="font-weight: 600; color: #0F172A; font-size: 14px;">{{ $data->anak->nama_anak ?? '-' }}</div>
                                    <div style="font-size: 12px; color: #64748B;">NIK: {{ $data->anak->nik_anak ?? '-' }}</div>
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle; font-size: 14px; color: #475569;">
                                    <div style="font-weight: 600; color: #0F172A;">{{ $data->posyandu }}</div>
                                    @if(count($data->pelaksana) > 0)
                                        <div style="font-size: 11px; color: #64748B; margin-top: 4px;">{{ implode(', ', $data->pelaksana) }}</div>
                                    @endif
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle; font-size: 14px; color: #475569;">
                                    @if($data->pengukuran)
                                        <span style="font-weight: 600;">{{ $data->pengukuran->berat_badan }} kg</span> / <span style="font-weight: 600;">{{ $data->pengukuran->tinggi_badan }} cm</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    @if($data->pengukuran)
                                        @if(str_contains(strtolower($data->pengukuran->status_stunting), 'stunting'))
                                            <span class="badge badge-danger" style="margin-bottom: 4px; display: inline-block;">{{ $data->pengukuran->status_stunting }}</span><br>
                                        @endif
                                        @if(str_contains(strtolower($data->pengukuran->status_gizi), 'kurang') || str_contains(strtolower($data->pengukuran->status_gizi), 'buruk'))
                                            <span class="badge badge-warning" style="display: inline-block;">{{ $data->pengukuran->status_gizi }}</span>
                                        @else
                                            <span class="badge badge-success" style="display: inline-block;">{{ $data->pengukuran->status_gizi }}</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle; font-size: 13px; color: #475569;">
                                    @if($data->tindakan || $data->imunisasi)
                                        @if($data->imunisasi)
                                            <div style="margin-bottom: 4px; color: #059669;">
                                                <svg viewBox="0 0 24 24" style="width: 14px; height: 14px; fill: currentColor; display: inline; vertical-align: middle; margin-top: -2px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                                Vaksin: {{ $data->imunisasi->nama_vaksin }}
                                            </div>
                                        @endif
                                        @if($data->tindakan)
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
    </form>

    <style>
        .badge-success { background: rgba(16, 185, 129, 0.1); color: #059669; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-warning { background: rgba(245, 158, 11, 0.1); color: #D97706; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-danger { background: rgba(239, 68, 68, 0.1); color: #DC2626; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.laporan-checkbox');

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                });
                
                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function() {
                        if (!this.checked) {
                            selectAll.checked = false;
                        } else if (document.querySelectorAll('.laporan-checkbox:checked').length === checkboxes.length) {
                            selectAll.checked = true;
                        }
                    });
                });
            }
        });
    </script>
@endsection
