@extends('layouts.dashboard')

@section('title', 'Kader Dashboard')
@section('page_title', 'Dashboard Posyandu')
@section('page_subtitle', 'Ringkasan operasional dan pemantauan posyandu')

@section('content')
    <!-- Welcome Banner -->
    <div class="welcome-banner" id="welcome-banner">
        <h2 class="welcome-title">Selamat Datang, Kader {{ auth()->user()->name }}! 👋</h2>
        <p class="welcome-text">
            Pantau jadwal posyandu dan kelola data pengukuran tumbuh kembang anak di wilayah kerja Anda.
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

        <div class="dash-card dash-card--coral" id="card-jadwal">
            <div class="dash-card-header">
                <div class="dash-card-icon dash-card-icon--coral">
                    <svg viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2zm-8 4H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z"/></svg>
                </div>
            </div>
            @if($jadwalTerdekat)
                <div class="dash-card-value" style="font-size: 1.5rem; margin-bottom: 4px;">{{ $jadwalTerdekat->tanggal->format('d M Y') }}</div>
                <div class="dash-card-label" style="line-height: 1.4;">
                    Pukul: {{ \Carbon\Carbon::parse($jadwalTerdekat->waktu_mulai)->format('H:i') }} WIB <br>
                    Lokasi: {{ $jadwalTerdekat->lokasi }}
                </div>
            @else
                <div class="dash-card-value">Belum Ada</div>
                <div class="dash-card-label">Jadwal Posyandu Terdekat</div>
            @endif
        </div>
        
        <div class="dash-card dash-card--amber" id="card-risiko">
            <div class="dash-card-header">
                <div class="dash-card-icon dash-card-icon--amber">
                    <svg viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                </div>
            </div>
            <div class="dash-card-value">{{ $anakBerisiko }}</div>
            <div class="dash-card-label">Anak Berisiko Bulan Ini</div>
        </div>
    </div>

    <!-- Pasien Prioritas / Berisiko Table -->
    <div style="background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(13,148,136,0.04); border: 1px solid rgba(15,23,42,0.06); overflow: hidden; margin-top: 24px;" id="pasien-prioritas-section">
        <div style="padding: 24px 28px; border-bottom: 1px solid rgba(15,23,42,0.06); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(251,113,133,0.1); display: grid; place-items: center;">
                    <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: #FB7185;"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0;">Pasien Prioritas / Berisiko</h3>
                    <p style="font-size: 13px; color: #64748B; margin: 2px 0 0;">Anak dengan flag risiko pada bulan ini</p>
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
                                    {{ $anak->orangTua ? $anak->orangTua->name : '-' }}
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
                                        <a href="{{ route('admin.anak.show', $anak->id_anak) }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: rgba(13,148,136,0.08); color: var(--kia-primary); border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='rgba(13,148,136,0.15)';" onmouseout="this.style.background='rgba(13,148,136,0.08)';">
                                            <svg viewBox="0 0 20 20" style="width: 14px; height: 14px; fill: currentColor;"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                            Riwayat
                                        </a>
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
