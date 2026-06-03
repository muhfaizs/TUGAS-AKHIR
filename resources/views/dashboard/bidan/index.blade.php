@extends('layouts.dashboard')

@section('title', 'Dashboard Bidan')
@section('page_title', 'Dashboard Bidan')
@section('page_subtitle', 'Monitoring layanan kesehatan ibu dan anak')

@section('content')
    <!-- Welcome Banner -->
    <div class="welcome-banner" id="welcome-banner">
        <h2 class="welcome-title">Selamat Datang, Bidan {{ auth()->user()->nama_lengkap }}! 👋</h2>
        <p class="welcome-text">
            Pantau status kesehatan pasien, identifikasi anak berisiko, dan kelola pemeriksaan kesehatan secara efisien.
        </p>
    </div>

    <!-- Summary Cards -->
    <div class="dash-grid" id="summary-cards">
        <div class="dash-card dash-card--teal" id="card-total-anak">
            <div class="dash-card-header">
                <div class="dash-card-icon dash-card-icon--teal">
                    <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
            </div>
            <div class="dash-card-value">{{ $totalAnak }}</div>
            <div class="dash-card-label">Total Anak Terdaftar</div>
        </div>

        <div class="dash-card dash-card--coral" id="card-anak-berisiko">
            <div class="dash-card-header">
                <div class="dash-card-icon dash-card-icon--coral">
                    <svg viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                </div>
            </div>
            <div class="dash-card-value">{{ $anakBerisiko }}</div>
            <div class="dash-card-label">Anak Berisiko</div>
        </div>

        <div class="dash-card dash-card--amber" id="card-total-pengukuran">
            <div class="dash-card-header">
                <div class="dash-card-icon dash-card-icon--amber">
                    <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h-2v5H6v2h2v5h2v-5h2v-2z"/></svg>
                </div>
            </div>
            <div class="dash-card-value">{{ $totalPengukuran }}</div>
            <div class="dash-card-label">Total Pengukuran</div>
        </div>

        <div class="dash-card dash-card--indigo" id="card-total-bidan">
            <div class="dash-card-header">
                <div class="dash-card-icon dash-card-icon--indigo">
                    <svg viewBox="0 0 24 24"><path d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-6 0h-4V4h4v2z"/></svg>
                </div>
            </div>
            <div class="dash-card-value">{{ $totalBidan }}</div>
            <div class="dash-card-label">Bidan Aktif</div>
        </div>
    </div>

    <!-- Pasien Prioritas / Berisiko Table -->
    <div style="background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(13,148,136,0.04); border: 1px solid rgba(15,23,42,0.06); overflow: hidden;" id="pasien-prioritas-section">
        <div style="padding: 24px 28px; border-bottom: 1px solid rgba(15,23,42,0.06); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(251,113,133,0.1); display: grid; place-items: center;">
                    <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: #FB7185;"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0;">Pasien Prioritas / Berisiko</h3>
                    <p style="font-size: 13px; color: #64748B; margin: 2px 0 0;">Anak dengan flag risiko berdasarkan data pengukuran</p>
                </div>
            </div>
            <span style="display: inline-flex; padding: 6px 14px; border-radius: 999px; font-size: 12px; font-weight: 600; background: rgba(251,113,133,0.1); color: #E11D48;">
                {{ $pasienPrioritas->count() }} Anak
            </span>
        </div>

        @if($pasienPrioritas->isEmpty())
            <div style="text-align: center; padding: 48px 24px; color: #64748B;">
                <svg viewBox="0 0 24 24" style="width: 48px; height: 48px; fill: #CBD5E1; margin: 0 auto 12px; display: block;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                <p style="font-size: 15px; font-weight: 600; margin: 0 0 4px;">Tidak Ada Pasien Berisiko</p>
                <p style="font-size: 13px; margin: 0;">Semua anak dalam kondisi baik. Data akan muncul saat ada anak dengan flag risiko.</p>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 700px; text-align: left;">
                    <thead>
                        <tr>
                            <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Nama Anak</th>
                            <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Orang Tua</th>
                            <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Usia</th>
                            <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">BB / TB Terakhir</th>
                            <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Status</th>
                            <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pasienPrioritas as $anak)
                            @php
                                $latestPengukuran = $anak->pengukuran->first();
                                $birthDate = $anak->tanggal_lahir;
                                $usia = $birthDate ? $birthDate->diff(now()) : null;
                                $usiaText = $usia ? ($usia->y > 0 ? $usia->y . ' thn ' . $usia->m . ' bln' : $usia->m . ' bulan') : '-';
                            @endphp
                            <tr style="transition: background 0.15s;">
                                <td style="padding: 16px 24px; vertical-align: middle; border-bottom: 1px solid rgba(15,23,42,0.04);">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #FB7185, #F43F5E); display: grid; place-items: center; color: #fff; font-weight: 700; font-size: 13px; flex-shrink: 0;">
                                            {{ strtoupper(substr($anak->nama_anak, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 600; color: #0F172A; font-size: 14px;">{{ $anak->nama_anak }}</div>
                                            <div style="font-size: 12px; color: #64748B; margin-top: 1px;">{{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle; border-bottom: 1px solid rgba(15,23,42,0.04); font-size: 14px; color: #475569;">
                                    {{ $anak->orangTua ? $anak->orangTua->nama_lengkap : '-' }}
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle; border-bottom: 1px solid rgba(15,23,42,0.04); font-size: 14px; color: #475569;">
                                    {{ $usiaText }}
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle; border-bottom: 1px solid rgba(15,23,42,0.04); font-size: 14px; color: #475569;">
                                    @if($latestPengukuran)
                                        <span style="font-weight: 600;">{{ $latestPengukuran->berat_badan }} kg</span> / <span style="font-weight: 600;">{{ $latestPengukuran->tinggi_badan }} cm</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle; border-bottom: 1px solid rgba(15,23,42,0.04); font-size: 14px; color: #475569;">
                                    {{ $latestPengukuran ? $latestPengukuran->tanggal_pengukuran->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle; border-bottom: 1px solid rgba(15,23,42,0.04);">
                                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; background: rgba(239,68,68,0.1); color: #DC2626;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #EF4444; animation: status-pulse 2s ease-in-out infinite;"></span>
                                        Berisiko
                                    </span>
                                </td>
                                <td style="padding: 16px 24px; vertical-align: middle; border-bottom: 1px solid rgba(15,23,42,0.04);">
                                    <div style="display: flex; gap: 8px;">
                                        <a href="{{ route('bidan.anak.show', $anak->id_anak) }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: rgba(13,148,136,0.08); color: var(--kia-primary); border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='rgba(13,148,136,0.15)';" onmouseout="this.style.background='rgba(13,148,136,0.08)';">
                                            <svg viewBox="0 0 20 20" style="width: 14px; height: 14px; fill: currentColor;"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                            Riwayat
                                        </a>

                                        @if($anak->orangTua && $anak->orangTua->nomor_kontak)
                                            <!-- Panggilan Sistem -->
                                            <form action="{{ route('bidan.anak.send-system', $anak->id_anak) }}" method="POST" style="display:inline;" title="Kirim notifikasi panggilan via Sistem dan Email">
                                                @csrf
                                                <button type="submit" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: rgba(234,179,8,0.1); color: #CA8A04; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(234,179,8,0.2)';" onmouseout="this.style.background='rgba(234,179,8,0.1)';">
                                                    <svg viewBox="0 0 24 24" style="width: 14px; height: 14px; fill: currentColor;"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                                                    Panggilan Sistem
                                                </button>
                                            </form>

                                            <!-- Kirim WA & Email -->
                                            <form action="{{ route('bidan.anak.send-notification', $anak->id_anak) }}" method="POST" target="_blank" style="display:inline;" title="Kirim laporan via WA dan Email">
                                                @csrf
                                                <button type="submit" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: rgba(34,197,94,0.1); color: #16A34A; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(34,197,94,0.2)';" onmouseout="this.style.background='rgba(34,197,94,0.1)';">
                                                    <svg viewBox="0 0 24 24" style="width: 14px; height: 14px; fill: currentColor;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                                    WA & Email
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
