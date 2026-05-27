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
                @if (auth()->user()->isSuperAdmin() || auth()->user()->isBidan() || auth()->user()->isKader())

                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'sidebar-link--active' : '' }}" id="nav-dashboard">
                        <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                        Dashboard
                    </a>

                    @if(!auth()->user()->isSuperAdmin())
                    <a href="{{ route('admin.anak.index') }}" class="sidebar-link {{ request()->routeIs('admin.anak.*') ? 'sidebar-link--active' : '' }}" id="nav-admin-anak">
                        <svg viewBox="0 0 24 24"><path d="M13 2v8h8c0-4.42-3.58-8-8-8zm6.32 13.89C20.37 14.54 21 12.84 21 11H6.44l-.95-2H2v2h2.22s1.89 4.07 2.12 4.42C5.24 16.01 4.5 17.17 4.5 18.5 4.5 20.43 6.07 22 8 22c1.76 0 3.22-1.3 3.46-3h2.08c.24 1.7 1.7 3 3.46 3 1.93 0 3.5-1.57 3.5-3.5 0-1.04-.46-1.97-1.18-2.61zM8 20c-.83 0-1.5-.67-1.5-1.5S7.17 17 8 17s1.5.67 1.5 1.5S8.83 20 8 20zm9 0c-.83 0-1.5-.67-1.5-1.5S16.17 17 17 17s1.5.67 1.5 1.5S17.83 20 17 20z"/></svg>
                        Kelola Data Anak
                    </a>
                    @endif

                    @if (auth()->user()->role === 'super admin' || auth()->user()->role === 'bidan')
                    @if (auth()->user()->role === 'super admin')
                    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'sidebar-link--active' : '' }}" id="nav-users">
                        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        Kelola Pengguna
                    </a>
                    @endif
                    <a href="{{ route('admin.profile.edit') }}" class="sidebar-link {{ request()->routeIs('admin.profile.*') ? 'sidebar-link--active' : '' }}" id="nav-admin-profile">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Profil Saya
                    </a>
                @elseif (auth()->user()->role === 'kader')

                    <a href="{{ route('kader.pengukuran.create') }}" class="sidebar-link {{ request()->routeIs('kader.pengukuran.*') ? 'sidebar-link--active' : '' }}" id="nav-kader-pengukuran">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h-2v5H6v2h2v5h2v-5h2v-2z"/></svg>
                        Input Pengukuran
                    </a>
                    <a href="{{ route('kader.profile.edit') }}" class="sidebar-link {{ request()->routeIs('kader.profile.*') ? 'sidebar-link--active' : '' }}" id="nav-kader-profile">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Profil Saya
                    </a>
                @elseif (auth()->user()->role === 'orang tua')             @endif
                @endif

                @if (auth()->user()->isOrangTua())

                    <a href="{{ route('orangtua.dashboard') }}" class="sidebar-link {{ request()->routeIs('orangtua.dashboard') ? 'sidebar-link--active' : '' }}" id="nav-ot-dashboard">
                        <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                        Dashboard
                    </a>

                    <a href="{{ route('orangtua.profile.edit') }}" class="sidebar-link {{ request()->routeIs('orangtua.profile.*') ? 'sidebar-link--active' : '' }}" id="nav-ot-profile">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Profil Saya
                    </a>

                    <a href="{{ route('orangtua.anak.index') }}" class="sidebar-link {{ request()->routeIs('orangtua.anak.*') ? 'sidebar-link--active' : '' }}" id="nav-ot-anak">
                        <svg viewBox="0 0 24 24"><path d="M13 2v8h8c0-4.42-3.58-8-8-8zm6.32 13.89C20.37 14.54 21 12.84 21 11H6.44l-.95-2H2v2h2.22s1.89 4.07 2.12 4.42C5.24 16.01 4.5 17.17 4.5 18.5 4.5 20.43 6.07 22 8 22c1.76 0 3.22-1.3 3.46-3h2.08c.24 1.7 1.7 3 3.46 3 1.93 0 3.5-1.57 3.5-3.5 0-1.04-.46-1.97-1.18-2.61zM8 20c-.83 0-1.5-.67-1.5-1.5S7.17 17 8 17s1.5.67 1.5 1.5S8.83 20 8 20zm9 0c-.83 0-1.5-.67-1.5-1.5S16.17 17 17 17s1.5.67 1.5 1.5S17.83 20 17 20z"/></svg>
                        Data Anak
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

                <div class="topbar-right">
                    <div class="topbar-user">
                        <div class="topbar-avatar" style="{{ auth()->user()->foto_profil ? 'background-image: url(' . asset('storage/' . auth()->user()->foto_profil) . '); background-size: cover; background-position: center; color: transparent;' : '' }}">
                            {{ auth()->user()->foto_profil ? '' : strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}
                        </div>
                        <div class="topbar-user-info">
                            <span class="topbar-user-name">{{ auth()->user()->nama_lengkap }}</span>
                            <span class="topbar-user-role">{{ auth()->user()->role }}</span>
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
</body>
</html>
