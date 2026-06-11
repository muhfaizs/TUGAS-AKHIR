@extends('layouts.dashboard')

@section('title', 'Kader Dashboard')
@section('page_title', 'Dashboard Posyandu')
@section('page_subtitle', 'Ringkasan operasional dan pemantauan posyandu')

@section('content')
    <!-- Welcome Banner -->
    <div class="welcome-banner" id="welcome-banner">
        <h2 class="welcome-title">Selamat Datang, Kader {{ auth()->user()->nama_lengkap }}! 👋</h2>
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
@endsection
