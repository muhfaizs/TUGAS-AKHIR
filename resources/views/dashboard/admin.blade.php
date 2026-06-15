@extends('layouts.app')

@section('title', 'Dashboard Admin - SatuKIA')
@section('header_title', 'Dashboard')
@section('header_subtitle', 'Ringkasan sistem monitoring layanan ibu dan anak')

@section('content')

<style>
    :root {
        --teal-700: #0f766e;
        --teal-600: #0d9488;
        --teal-50: #f0fdfa;
    }
    
    .welcome-banner {
        background: linear-gradient(135deg, #0d5f52 0%, #16a085 100%);
        border-radius: 20px;
        padding: 2.5rem;
        color: white;
        margin-bottom: 2.5rem;
        box-shadow: 0 10px 25px -5px rgba(22, 160, 133, 0.4);
        position: relative;
        overflow: hidden;
    }
    
    .welcome-banner::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .welcome-banner h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        position: relative;
        z-index: 2;
    }
    
    .welcome-banner p {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.85);
        max-width: 600px;
        line-height: 1.6;
        position: relative;
        z-index: 2;
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    @media (max-width: 1200px) {
        .kpi-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 900px) {
        .kpi-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .kpi-grid { grid-template-columns: 1fr; }
    }

    .kpi-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid #f3f4f6;
        transition: transform 0.2s, box-shadow 0.2s;
        border-top: 4px solid var(--card-color, #0d9488);
        display: flex;
        flex-direction: column;
    }
    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .kpi-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        background: var(--icon-bg);
        color: var(--icon-color);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 1.5rem;
    }
    
    .kpi-content h4 { 
        font-size: 0.85rem; 
        color: #6b7280; 
        font-weight: 500;
        margin-top: 0.5rem;
    }
    
    .kpi-content p { 
        font-size: 2rem; 
        font-weight: 800; 
        color: #111827; 
        line-height: 1;
    }

    /* Colors */
    .card-teal { --card-color: #0ea5e9; --icon-bg: #e0f2fe; --icon-color: #0284c7; }
    .card-pink { --card-color: #ec4899; --icon-bg: #fce7f3; --icon-color: #db2777; }
    .card-orange { --card-color: #f97316; --icon-bg: #ffedd5; --icon-color: #ea580c; }
    .card-green { --card-color: #10b981; --icon-bg: #d1fae5; --icon-color: #059669; }
    .card-purple { --card-color: #8b5cf6; --icon-bg: #ede9fe; --icon-color: #7c3aed; }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: #dcfce7;
        color: #166534;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .status-badge .dot {
        width: 6px; height: 6px;
        background: #166534;
        border-radius: 50%;
    }
</style>

<div class="welcome-banner">
    <h2>Selamat Datang, {{ auth()->user()->name ?? 'Administrator' }}! 👋</h2>
    <p>Berikut adalah ringkasan data sistem monitoring layanan ibu dan anak. Pastikan semua data ter-update untuk pelaporan yang akurat.</p>
</div>

<div class="kpi-grid">
    <!-- Total Pengguna -->
    <div class="kpi-card card-teal">
        <div class="kpi-icon">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <div class="kpi-content">
            <p>{{ $totalPengguna }}</p>
            <h4>Total Pengguna</h4>
        </div>
    </div>

    <!-- Bidan Aktif -->
    <div class="kpi-card card-pink">
        <div class="kpi-icon">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>
        <div class="kpi-content">
            <p>{{ $bidanAktif }}</p>
            <h4>Bidan Aktif</h4>
        </div>
    </div>

    <!-- Pasien KB Terdaftar -->
    <div class="kpi-card card-orange">
        <div class="kpi-icon">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div class="kpi-content">
            <p>{{ $pasienTerdaftar }}</p>
            <h4>Pasien KB Terdaftar</h4>
        </div>
    </div>

    <!-- Total Kader Posyandu -->
    <div class="kpi-card card-green">
        <div class="kpi-icon">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <div class="kpi-content">
            <p>{{ $kaderPosyandu }}</p>
            <h4>Total Kader Posyandu</h4>
        </div>
    </div>

    <!-- Total Petugas Dinkes -->
    <div class="kpi-card card-pink">
        <div class="kpi-icon" style="--icon-bg: #fee2e2; --icon-color: #ef4444;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div class="kpi-content">
            <p>{{ $petugasDinkes }}</p>
            <h4>Total Petugas Dinkes</h4>
        </div>
    </div>

    <!-- Status Sistem -->
    <div class="kpi-card card-purple">
        <div class="kpi-icon">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="kpi-content">
            <div><span class="status-badge"><span class="dot"></span> Aktif</span></div>
            <h4>Status Sistem</h4>
        </div>
    </div>
</div>

@endsection
