<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name', 'SatuKIA') }}</title>
    <meta name="description" content="@yield('meta_description', 'Dashboard Sistem Monitoring Layanan Ibu dan Anak')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/dashboard.css', 'resources/js/app.js'])
    @endif
</head>
<body x-data="{ sidebarOpen: false, showLogoutModal: false }">
    <div class="dashboard-layout">
        <!-- Mobile Overlay -->
        <div
            class="sidebar-overlay"
            :class="{ 'sidebar-overlay--visible': sidebarOpen }"
            @click="sidebarOpen = false"
        ></div>

        <!-- Sidebar -->
        <aside class="sidebar" :class="{ 'sidebar--open': sidebarOpen }" id="sidebar">
            <a href="/" class="sidebar-brand">
                <div class="sidebar-brand-mark">SK</div>
                <div class="sidebar-brand-info">
                    <span class="sidebar-brand-name">SatuKIA</span>
                    <span class="sidebar-brand-sub">Monitoring KIA</span>
                </div>
            </a>

            <nav class="sidebar-nav">
                @if (auth()->user()->isSuperAdmin())
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link--active' : '' }}" id="nav-dashboard">
                        <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'sidebar-link--active' : '' }}" id="nav-users">
                        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        Kelola Pengguna
                    </a>

                    <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link--active' : '' }}" id="nav-admin-profile">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Profil Saya
                    </a>
                @endif

                @if (auth()->user()->isBidan())
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link--active' : '' }}" id="nav-bidan-dashboard">
                        <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                        Dashboard
                    </a>

                    <a href="{{ route('bidan.anak.index') }}" class="sidebar-link {{ request()->routeIs('bidan.anak.*') ? 'sidebar-link--active' : '' }}" id="nav-bidan-anak">
                        <svg viewBox="0 0 24 24"><path d="M13 2v8h8c0-4.42-3.58-8-8-8zm6.32 13.89C20.37 14.54 21 12.84 21 11H6.44l-.95-2H2v2h2.22s1.89 4.07 2.12 4.42C5.24 16.01 4.5 17.17 4.5 18.5 4.5 20.43 6.07 22 8 22c1.76 0 3.22-1.3 3.46-3h2.08c.24 1.7 1.7 3 3.46 3 1.93 0 3.5-1.57 3.5-3.5 0-1.04-.46-1.97-1.18-2.61zM8 20c-.83 0-1.5-.67-1.5-1.5S7.17 17 8 17s1.5.67 1.5 1.5S8.83 20 8 20zm9 0c-.83 0-1.5-.67-1.5-1.5S16.17 17 17 17s1.5.67 1.5 1.5S17.83 20 17 20z"/></svg>
                        Kelola Data Anak
                    </a>

                    <a href="{{ route('bidan.tindakan.index') }}" class="sidebar-link {{ request()->routeIs('bidan.tindakan.*') ? 'sidebar-link--active' : '' }}" id="nav-bidan-tindakan">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.5 13H9v-2.5H6.5v-2H9V9h1.5v2.5H13v2h-2.5V16zM18 16h-4v-2h4v2zm0-4h-4v-2h4v2z"/></svg>
                        Tindakan Medis
                    </a>

                    <a href="{{ route('bidan.imunisasi.index') }}" class="sidebar-link {{ request()->routeIs('bidan.imunisasi.*') ? 'sidebar-link--active' : '' }}" id="nav-bidan-imunisasi">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                        Imunisasi Bayi
                    </a>


                    <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link--active' : '' }}" id="nav-bidan-profile">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Profil Saya
                    </a>

                    <a href="{{ route('bidan.kader.index') }}" class="sidebar-link {{ request()->routeIs('bidan.kader.*') ? 'sidebar-link--active' : '' }}" id="nav-bidan-kader">
                        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        Kelola Akun Kader
                    </a>

                    <a href="{{ route('ibu-hamil.index') }}" class="sidebar-link {{ request()->routeIs('ibu-hamil.*') ? 'sidebar-link--active' : '' }}" id="nav-bidan-ibu-hamil">
                        <svg viewBox="0 0 24 24"><path d="M12 2c-4.97 0-9 4.03-9 9 0 4.17 2.84 7.67 6.69 8.69L12 22l2.31-2.31C18.16 18.67 21 15.17 21 11c0-4.97-4.03-9-9-9zm0 2c3.86 0 7 3.14 7 7 0 2.38-1.19 4.47-3 5.74V17h-2v-1.5h-4V17H8v-1.26C6.19 14.47 5 12.38 5 11c0-3.86 3.14-7 7-7z"/></svg>
                        Data Ibu Hamil
                    </a>

                    <a href="{{ route('rujukan.index') }}" class="sidebar-link {{ request()->routeIs('rujukan.*') ? 'sidebar-link--active' : '' }}" id="nav-bidan-rujukan">
                        <svg viewBox="0 0 24 24"><path d="M14 6l-3.75 5 2.85 3.8-1.6 1.2C9.81 13.75 7 10 7 10l-4 5h18l-7-9z"/></svg>
                        Surat Rujukan
                    </a>

                    <a href="{{ route('kb-acceptors.index') }}" class="sidebar-link {{ request()->routeIs('kb-acceptors.index', 'kb-acceptors.show', 'kb-acceptors.create', 'kb-acceptors.edit') ? 'sidebar-link--active' : '' }}" id="nav-kb-acceptors">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Data Pasien KB
                    </a>

                    <a href="{{ route('kb-services.create') }}" class="sidebar-link {{ request()->routeIs('kb-services.create') ? 'sidebar-link--active' : '' }}" id="nav-kb-services-create">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
                        Input Pelayanan KB
                    </a>

                    <a href="{{ route('kb-services.index') }}" class="sidebar-link {{ request()->routeIs('kb-services.index', 'kb-services.show', 'kb-services.edit') ? 'sidebar-link--active' : '' }}" id="nav-kb-services">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                        Riwayat Pelayanan KB
                    </a>

                    <a href="{{ route('kb-services.jadwal-kontrol') }}" class="sidebar-link {{ request()->routeIs('kb-services.jadwal-kontrol') ? 'sidebar-link--active' : '' }}" id="nav-kb-jadwal-kontrol">
                        <svg viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2zm-8 4H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z"/></svg>
                        Jadwal Kontrol KB
                    </a>

                    <a href="{{ route('bidan.laporan-bulanan') }}" class="sidebar-link {{ request()->routeIs('bidan.laporan-bulanan') ? 'sidebar-link--active' : '' }}" id="nav-bidan-laporan-bulanan">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                        Laporan Bulanan Bumil
                    </a>

                    <a href="{{ route('bidan.laporan-tahunan') }}" class="sidebar-link {{ request()->routeIs('bidan.laporan-tahunan') ? 'sidebar-link--active' : '' }}" id="nav-bidan-laporan-tahunan">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                        Laporan Tahunan Bumil
                    </a>

                    <a href="{{ route('kb-acceptors.laporan-r1') }}" class="sidebar-link {{ request()->routeIs('kb-acceptors.laporan-r1') ? 'sidebar-link--active' : '' }}" id="nav-bidan-laporan-kb">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                        Laporan KB
                    </a>

                    <a href="{{ route('laporan.index') }}" class="sidebar-link {{ request()->routeIs('laporan.*') ? 'sidebar-link--active' : '' }}" id="nav-bidan-laporan-anak">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                        Laporan Anak
                    </a>
                @endif

                @if (auth()->user()->isKader())
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link--active' : '' }}" id="nav-dashboard">
                        <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.anak.index') }}" class="sidebar-link {{ request()->routeIs('admin.anak.*') ? 'sidebar-link--active' : '' }}" id="nav-admin-anak">
                        <svg viewBox="0 0 24 24"><path d="M13 2v8h8c0-4.42-3.58-8-8-8zm6.32 13.89C20.37 14.54 21 12.84 21 11H6.44l-.95-2H2v2h2.22s1.89 4.07 2.12 4.42C5.24 16.01 4.5 17.17 4.5 18.5 4.5 20.43 6.07 22 8 22c1.76 0 3.22-1.3 3.46-3h2.08c.24 1.7 1.7 3 3.46 3 1.93 0 3.5-1.57 3.5-3.5 0-1.04-.46-1.97-1.18-2.61zM8 20c-.83 0-1.5-.67-1.5-1.5S7.17 17 8 17s1.5.67 1.5 1.5S8.83 20 8 20zm9 0c-.83 0-1.5-.67-1.5-1.5S16.17 17 17 17s1.5.67 1.5 1.5S17.83 20 17 20z"/></svg>
                        Kelola Data Anak
                    </a>

                    <a href="{{ route('kader.pengukuran.create') }}" class="sidebar-link {{ request()->routeIs('kader.pengukuran.*') ? 'sidebar-link--active' : '' }}" id="nav-kader-pengukuran">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h-2v5H6v2h2v5h2v-5h2v-2z"/></svg>
                        Input Pengukuran
                    </a>

                    <a href="{{ route('kader.jadwal.index') }}" class="sidebar-link {{ request()->routeIs('kader.jadwal.*') ? 'sidebar-link--active' : '' }}" id="nav-kader-jadwal">
                        <svg viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2zm-8 4H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z"/></svg>
                        Jadwal Posyandu
                    </a>

                    <a href="{{ route('kb-acceptors.index') }}" class="sidebar-link {{ request()->routeIs('kb-acceptors.*') ? 'sidebar-link--active' : '' }}" id="nav-kader-kb">
                        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        Data Pasien KB
                    </a>

                    <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link--active' : '' }}" id="nav-kader-profile">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Profil Saya
                    </a>
                @endif

                @if (auth()->user()->isOrangTua())
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link--active' : '' }}" id="nav-ot-dashboard">
                        <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                        Dashboard
                    </a>

                    <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link--active' : '' }}" id="nav-ot-profile">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Profil Saya
                    </a>

                    <a href="{{ route('orangtua.anak.index') }}" class="sidebar-link {{ request()->routeIs('orangtua.anak*') ? 'sidebar-link--active' : '' }}" id="nav-ot-anak">
                        <svg viewBox="0 0 24 24"><path d="M13 2v8h8c0-4.42-3.58-8-8-8zm6.32 13.89C20.37 14.54 21 12.84 21 11H6.44l-.95-2H2v2h2.22s1.89 4.07 2.12 4.42C5.24 16.01 4.5 17.17 4.5 18.5 4.5 20.43 6.07 22 8 22c1.76 0 3.22-1.3 3.46-3h2.08c.24 1.7 1.7 3 3.46 3 1.93 0 3.5-1.57 3.5-3.5 0-1.04-.46-1.97-1.18-2.61zM8 20c-.83 0-1.5-.67-1.5-1.5S7.17 17 8 17s1.5.67 1.5 1.5S8.83 20 8 20zm9 0c-.83 0-1.5-.67-1.5-1.5S16.17 17 17 17s1.5.67 1.5 1.5S17.83 20 17 20z"/></svg>
                        Data Anak
                    </a>
                @endif

                @if (auth()->user()->isIbuHamil())
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link--active' : '' }}" id="nav-ih-dashboard">
                        <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                        Dashboard
                    </a>

                    <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link--active' : '' }}" id="nav-ih-profile">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Profil Saya
                    </a>

                    <a href="{{ route('ortu.pemeriksaan') }}" class="sidebar-link {{ request()->routeIs('ortu.pemeriksaan*') ? 'sidebar-link--active' : '' }}" id="nav-ih-pemeriksaan">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                        Riwayat Kehamilan (ANC)
                    </a>
                @endif

                @if (auth()->user()->isPasienKb())
                    <div class="sidebar-heading">MENU UTAMA</div>
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link--active' : '' }}" id="nav-pkb-dashboard">
                        <svg viewBox="0 0 24 24"><path d="M4 11h5V5H4v6zm0 7h5v-6H4v6zm6 0h5v-6h-5v6zm6 0h5v-6h-5v6zm-6-7h5V5h-5v6zm6-6v6h5V5h-5z"/></svg>
                        Pasien
                    </a>
                    <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link--active' : '' }}" id="nav-pkb-profile">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Profil Saya
                    </a>
                @endif

                @if (auth()->user()->isDinkes())
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link--active' : '' }}" id="nav-dinkes-dashboard">
                        <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                        Dashboard Eksekutif
                    </a>

                    <a href="{{ route('dinkes.laporan') }}" class="sidebar-link {{ request()->routeIs('dinkes.laporan*') ? 'sidebar-link--active' : '' }}" id="nav-dinkes-laporan">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                        Laporan Rekapitulasi
                    </a>

                    <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link--active' : '' }}" id="nav-dinkes-profile">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Profil Saya
                    </a>
                @endif
            </nav>

            <div class="sidebar-footer">
                <form id="logout-form-dashboard" method="POST" action="{{ route('logout') }}" x-ref="logoutForm">
                    @csrf
                    <button type="button" @click="showLogoutModal = true" class="sidebar-link" style="width: 100%; border: none; background: rgba(255,255,255,0.08); cursor: pointer; font-family: inherit; font-size: 14px; color: rgba(255,255,255,0.8);">
                        <svg viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main -->
        <div class="dashboard-main">
            <!-- Topbar -->
            <header class="topbar">
                <div class="topbar-left">
                    <button class="topbar-hamburger" @click="sidebarOpen = !sidebarOpen" aria-label="Toggle sidebar" id="btn-toggle-sidebar">
                        <svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
                    </button>
                    <div>
                        <h1 class="topbar-title">@yield('page_title', 'Dashboard')</h1>
                        <p class="topbar-subtitle">@yield('page_subtitle', now()->translatedFormat('l, d F Y'))</p>
                    </div>
                </div>

                <div class="topbar-right" style="display: flex; align-items: center; gap: 20px;">
                    @php
                        $notifications = \App\Models\Notifikasi::where('id_user', auth()->id())->latest()->take(5)->get();
                        $unreadNotifCount = $notifications->where('is_read', false)->count();
                    @endphp
                    
                    <div class="topbar-notification" x-data="{ open: false }" style="position: relative;">
                        <div @click="open = !open" style="cursor: pointer; position: relative; padding: 8px;">
                            <svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #64748B; transition: fill 0.2s;" onmouseover="this.style.fill='#0F172A'" onmouseout="this.style.fill='#64748B'"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                            @if($unreadNotifCount > 0)
                                <span style="position: absolute; top: 4px; right: 2px; background: #EF4444; color: #fff; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 99px; border: 2px solid #fff;">
                                    {{ $unreadNotifCount > 99 ? '99+' : $unreadNotifCount }}
                                </span>
                            @endif
                        </div>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" x-transition.opacity style="display: none; position: absolute; right: 0; top: 50px; width: 320px; background: #fff; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border: 1px solid #E2E8F0; z-index: 100; overflow: hidden;">
                            <div style="padding: 16px; border-bottom: 1px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center; background: #F8FAFC;">
                                <h3 style="margin: 0; font-size: 14px; font-weight: 700; color: #0F172A;">Notifikasi Sistem</h3>
                                @if($unreadNotifCount > 0)
                                    <form action="{{ route('notifikasi.read-all') }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" style="background: none; border: none; color: #0D9488; font-size: 12px; font-weight: 600; cursor: pointer;">Tandai Dibaca</button>
                                    </form>
                                @endif
                            </div>
                            <div style="max-height: 350px; overflow-y: auto;">
                                @forelse($notifications as $notif)
                                    <div style="padding: 16px; border-bottom: 1px solid #F1F5F9; background: {{ $notif->is_read ? '#fff' : '#F0FDFA' }};">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                            <strong style="font-size: 13px; color: #0F172A;">{{ $notif->judul }}</strong>
                                            <span style="font-size: 11px; color: #94A3B8;">{{ $notif->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p style="margin: 0 0 8px 0; font-size: 12px; color: #475569; line-height: 1.4;">{{ $notif->pesan }}</p>
                                        @if($notif->wa_link)
                                            <a href="{{ $notif->wa_link }}" target="_blank" style="font-size: 11px; color: #0D9488; font-weight: 600; text-decoration: none;">Buka di WhatsApp &rarr;</a>
                                        @endif
                                    </div>
                                @empty
                                    <div style="padding: 24px 16px; text-align: center; color: #64748B; font-size: 13px;">
                                        Belum ada notifikasi
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="topbar-user">
                        <div class="topbar-avatar" style="{{ auth()->user()->profile_photo_path ? 'background-image: url(' . asset('storage/' . auth()->user()->profile_photo_path) . '); background-size: cover; background-position: center; color: transparent;' : '' }}">
                            {{ auth()->user()->profile_photo_path ? '' : strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="topbar-user-info">
                            <span class="topbar-user-name">{{ auth()->user()->name }}</span>
                            <span class="topbar-user-role">{{ auth()->user()->role === 'dinkes' ? 'Dinas Kesehatan' : (auth()->user()->role === 'ortu' ? 'Orang Tua' : (auth()->user()->role === 'ibu_hamil' ? 'Ibu Hamil' : ucwords(str_replace('_', ' ', auth()->user()->role)))) }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="dashboard-content">
                @if (session('success'))
                    <div class="toast-success" id="toast-success">
                        <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="toast-error" id="toast-error">
                        <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Custom Logout Modal -->
    <div class="um-modal-overlay" x-show="showLogoutModal" x-transition:enter="um-overlay-enter" x-transition:leave="um-overlay-leave" @click.self="showLogoutModal = false" style="display:none; z-index: 9999;">
        <div class="um-modal" x-show="showLogoutModal" x-transition:enter="um-modal-enter" x-transition:leave="um-modal-leave" @click.stop style="max-width: 400px; text-align: center; padding: 32px 24px;">
            <div style="width: 64px; height: 64px; background: rgba(239,68,68,0.1); color: #EF4444; border-radius: 50%; display: grid; place-items: center; margin: 0 auto 20px;">
                <svg viewBox="0 0 24 24" style="width: 32px; height: 32px; fill: currentColor;"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
            </div>
            <h3 style="font-size: 20px; font-weight: 700; color: #0F172A; margin: 0 0 12px;">Konfirmasi Keluar</h3>
            <p style="font-size: 15px; color: #64748B; margin: 0 0 28px; line-height: 1.5;">Apakah Anda yakin ingin keluar dari aplikasi? Anda harus masuk kembali untuk mengakses dashboard.</p>
            
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" @click="showLogoutModal = false" style="flex: 1; padding: 12px; background: #fff; border: 1px solid #CBD5E1; color: #475569; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='#fff'">
                    Batal
                </button>
                <button type="button" onclick="document.getElementById('logout-form-dashboard').submit();" style="flex: 1; padding: 12px; background: #EF4444; border: none; color: #fff; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#DC2626'" onmouseout="this.style.background='#EF4444'">
                    Ya, Keluar
                </button>
            </div>
        </div>
    </div>

    <script>
        let isAlertShowing = false;
        document.addEventListener('invalid', function(e) {
            e.preventDefault();
            if (!isAlertShowing) {
                isAlertShowing = true;
                
                // Set custom validation messages based on attributes
                let msg = e.target.validationMessage;
                if (e.target.validity.valueMissing) {
                    msg = 'Bagian ini wajib diisi, silakan dilengkapi terlebih dahulu.';
                } else if (e.target.type === 'email' && e.target.validity.typeMismatch) {
                    msg = 'Email tidak sesuai, silakan perbaiki.';
                } else if (e.target.name === 'nik_anak' || e.target.name === 'nik_ortu' || e.target.name === 'nik') {
                    if (e.target.validity.patternMismatch || e.target.validity.tooShort || e.target.validity.tooLong) {
                        msg = 'NIK harus terdiri dari tepat 16 digit angka.';
                    }
                } else if (e.target.name === 'no_bpjs') {
                    if (e.target.validity.patternMismatch || e.target.validity.tooShort || e.target.validity.tooLong) {
                        msg = 'Nomor BPJS harus terdiri dari tepat 13 digit angka jika diisi.';
                    }
                } else if (e.target.name === 'no_telp' && e.target.validity.patternMismatch) {
                    msg = 'Nomor telepon tidak valid, hanya menerima angka.';
                } else if ((e.target.type === 'number' || e.target.inputMode === 'numeric') && (e.target.validity.badInput || e.target.validity.stepMismatch)) {
                    msg = 'Hanya menerima input numerik.';
                }

                alert(msg || 'Masih ada bagian wajib yang kosong atau belum sesuai.');
                e.target.focus();
                setTimeout(() => { isAlertShowing = false; }, 100);
            }
        }, true);
        // Form dirty checking mechanism for edit forms
        window.markFormState = function(form) {
            // Ignore search forms, delete forms, or logout forms
            if (!form || form.id === 'logout-form-dashboard' || form.classList.contains('um-search-form') || form.classList.contains('um-delete-form') || form.classList.contains('inline-form')) {
                return;
            }
            const formData = new FormData(form);
            const state = new URLSearchParams(formData).toString();
            form.setAttribute('data-initial-state', state);
        };

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('form').forEach(form => {
                if (!form.classList.contains('um-modal-form')) {
                    window.markFormState(form);
                }
            });
        });

        document.addEventListener('submit', (e) => {
            const form = e.target;
            
            // Apply only to forms that are explicitly "edit" operations
            // Detect edit forms if they have a _method=PUT/PATCH, OR if they are update forms
            const methodInput = form.querySelector('input[name="_method"]');
            const isPutOrPatch = methodInput && ['PUT', 'PATCH'].includes(methodInput.value.toUpperCase());
            const isUpdateAction = form.action && form.action.includes('update');
            const isEditForm = isPutOrPatch || isUpdateAction;
            
            if (isEditForm && form.hasAttribute('data-initial-state')) {
                const initialState = form.getAttribute('data-initial-state');
                const currentState = new URLSearchParams(new FormData(form)).toString();
                
                let hasFilesChanged = false;
                form.querySelectorAll('input[type="file"]').forEach(input => {
                    if (input.files && input.files.length > 0) hasFilesChanged = true;
                });
                
                if (initialState === currentState && !hasFilesChanged) {
                    e.preventDefault();
                    alert('Tidak ada data yang dirubah. Silakan rubah data terlebih dahulu atau klik Batal.');
                }
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
