<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SatuKIA')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false,
            },
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#117a65',
                        'primary-light': '#16a085',
                        'bg-main': '#eef7f5',
                        teal: {
                            50:'#f0fdf9', 100:'#ccfbf1', 200:'#99f6e4',
                            500:'#14b8a6', 600:'#0d9488', 700:'#0f766e',
                            800:'#115e59', 900:'#134e4a'
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal-900: #0d4f40;
            --teal-800: #0f5a4a;
            --teal-700: #117a65;
            --teal-600: #16a085;
            --teal-500: #1abc9c;
            --teal-100: #d1f5ef;
            --teal-50:  #f0fdf9;
            --bg:       #cdebe5; /* Changed base bg to darker mint green */
            --white:    #ffffff;
            --gray-50:  #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        html, body { height: 100%; }
        
        /* Reset default styles */
        button { border: none; background: transparent; outline: none; padding: 0; margin: 0; cursor: pointer; }
        input:focus, select:focus, textarea:focus { outline: none !important; box-shadow: none !important; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ebf6f5;
            background-image: radial-gradient(#117a6522 1px, transparent 1px);
            background-size: 24px 24px;
            background-attachment: fixed;
            display: flex;
            height: 100vh;
            overflow: hidden;
            color: var(--gray-800);
        }

        /* ─── SIDEBAR ─────────────────────────────── */
        .sidebar {
            width: 260px;
            flex-shrink: 0;
            background: linear-gradient(135deg, #105448 0%, #1c7c6b 100%);
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 22px 20px 18px;
        }
        .sidebar-logo-badge {
            width: 38px; height: 38px;
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            color: #fff;
            flex-shrink: 0;
        }
        .sidebar-logo-text { color: #fff; }
        .sidebar-logo-text .name  { font-size: 16px; font-weight: 700; line-height: 1.2; }
        .sidebar-logo-text .sub   { font-size: 10px; color: rgba(255,255,255,0.6); font-weight: 400; }

        .sidebar-divider {
            height: 1px;
            background: rgba(255,255,255,0.08);
            margin: 0 16px;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.45);
            padding: 0 10px;
            margin-top: 16px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        .nav-section-label:first-child { margin-top: 0; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: background 0.18s, color 0.18s;
            margin-bottom: 2px;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .nav-item.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
            font-weight: 600;
            border-left: 3px solid rgba(255,255,255,0.7);
            padding-left: 7px;
        }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; opacity: 0.85; }

        /* Logout button */
        .sidebar-footer {
            padding: 14px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin-top: auto;
        }
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 9px 12px;
            background: rgba(255,255,255,0.08);
            border: none;
            border-radius: 10px;
            color: rgba(255,255,255,0.8);
            font-size: 13.5px;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background 0.18s, color 0.18s;
            text-align: left;
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }
        .logout-btn svg { width: 18px; height: 18px; }

        /* ─── MAIN AREA ────────────────────────────── */
        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: transparent;
        }

        /* ─── HEADER ───────────────────────────────── */
        .topbar {
            height: 66px;
            flex-shrink: 0;
            background: #ffffff;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }

        .topbar-title h1 {
            font-size: 16px;
            font-weight: 700;
            color: var(--gray-800);
            line-height: 1.2;
        }
        .topbar-title p {
            font-size: 12px;
            color: var(--gray-500);
            margin-top: 2px;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .topbar-user-text { text-align: right; }
        .topbar-user-text .uname { font-size: 13.5px; font-weight: 700; color: var(--gray-800); }
        .topbar-user-text .urole { font-size: 11px; color: var(--gray-500); }
        .topbar-avatar {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #2dd4bf 0%, #0f766e 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* ─── CONTENT ──────────────────────────────── */
        .page-content {
            flex: 1;
            overflow-y: auto;
            padding: 28px;
        }

        /* Success alert */
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            color: #166534;
            font-weight: 500;
        }
        .alert-success-icon {
            width: 24px; height: 24px;
            background: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .alert-success-icon svg { width: 14px; height: 14px; color: #fff; }

        /* ─── LOGOUT MODAL ─────────────────────────── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 100;
            background: rgba(15,30,26,0.5);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.visible { display: flex; }

        .modal-card {
            background: var(--white);
            border-radius: 20px;
            width: 100%;
            max-width: 380px;
            padding: 36px 32px 28px;
            text-align: center;
            box-shadow: 0 24px 64px rgba(0,0,0,0.18);
            animation: modalIn 0.22s ease;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.94) translateY(10px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        .modal-icon {
            width: 60px; height: 60px;
            background: #fff1f2;
            border-radius: 50%;
            border: 1px solid #fecdd3;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            color: #f43f5e;
        }
        .modal-icon svg { width: 28px; height: 28px; }

        .modal-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 8px;
        }
        .modal-desc {
            font-size: 13.5px;
            color: var(--gray-500);
            line-height: 1.6;
            margin-bottom: 26px;
        }

        .modal-btns {
            display: flex;
            gap: 10px;
        }
        .modal-btn-cancel {
            flex: 1;
            padding: 11px;
            background: var(--white);
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: var(--gray-700);
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background 0.18s;
        }
        .modal-btn-cancel:hover { background: var(--gray-50); }

        .modal-btn-confirm {
            flex: 1;
            padding: 11px;
            background: #f43f5e;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: var(--white);
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background 0.18s;
        }
        .modal-btn-confirm:hover { background: #e11d48; }
    </style>
</head>
<body>

    <!-- ═══ SIDEBAR ════════════════════════════════ -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-badge">SK</div>
            <div class="sidebar-logo-text">
                <div class="name">SatuKIA</div>
                <div class="sub">Monitoring KIA</div>
            </div>
        </div>
        <div class="sidebar-divider"></div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Menu Utama</div>

            @if(auth()->check() && in_array(auth()->user()->role, ['super_admin', 'admin']))
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                    Kelola Pengguna
                </a>
            @elseif(auth()->user()->role === 'patient')
                <a href="{{ route('patient.dashboard') }}" class="nav-item {{ request()->routeIs('patient.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Pasien
                </a>
            @elseif(auth()->user()->role === 'dinas_kesehatan')
                <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Laporan R1 KB
                </a>
            @else
                @if(auth()->user()->role !== 'kader')
                    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        Dashboard
                    </a>
                @endif

                <a href="{{ route('kb-acceptors.index') }}" class="nav-item {{ request()->routeIs('kb-acceptors.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Data Pasien KB
                </a>

                @if(auth()->user()->role !== 'kader')
                    <a href="{{ route('kb-services.create') }}" class="nav-item {{ request()->routeIs('kb-services.create') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Input Pelayanan KB
                    </a>

                    <a href="{{ route('kb-services.index') }}" class="nav-item {{ request()->routeIs('kb-services.index', 'kb-services.show', 'kb-services.edit') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Riwayat Pelayanan KB
                    </a>
                    <a href="{{ route('followups.index') }}" class="nav-item {{ request()->routeIs('followups.*') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Jadwal Kontrol
                    </a>

                    <a href="{{ route('notifications.index') }}" class="nav-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        Reminder Kontrol
                    </a>

                    <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Laporan R1 KB
                    </a>
                @endif
            @endif
        </nav>

        <div class="sidebar-footer">
            <button class="logout-btn" onclick="showLogoutModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </div>
    </aside>

    <!-- ═══ MAIN AREA ══════════════════════════════ -->
    <div class="main-area">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-title">
                <h1>@yield('header_title', 'Dashboard')</h1>
                <p>@yield('header_subtitle', '')</p>
            </div>
            <div class="topbar-user">
                @if(auth()->check() && (auth()->user()->role === 'patient' || auth()->user()->role === 'Pasien'))
                    @php
                        $patientAcceptor = \App\Models\KBAcceptor::where('user_id', auth()->id())->first();
                        $hasNotification = false;
                        if ($patientAcceptor) {
                            $nextFollowUp = \App\Models\KBService::where('kb_acceptor_id', $patientAcceptor->id)
                                ->whereNotNull('follow_up_date')
                                ->where(function($q) {
                                    $q->whereNull('status')->orWhere('status', '!=', 'selesai');
                                })
                                ->orderBy('follow_up_date', 'asc')
                                ->first();
                                
                            if ($nextFollowUp) {
                                $daysToFollowUp = \Carbon\Carbon::parse($nextFollowUp->follow_up_date)->startOfDay()->diffInDays(now()->startOfDay(), false);
                                if ($daysToFollowUp >= -1) {
                                    $hasNotification = true;
                                }
                            }
                        }
                    @endphp
                    
                    <div class="relative mr-4 cursor-pointer" title="Notifikasi" onclick="window.location.href='{{ route('patient.dashboard') }}'">
                        @if($hasNotification)
                            <svg class="w-6 h-6 text-yellow-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
                        @else
                            <svg class="w-6 h-6 text-gray-400 hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @endif
                    </div>
                @endif
                <div class="topbar-user-text">
                    <div class="uname">{{ auth()->user()->name ?? 'Super Administrator' }}</div>
                    <div class="urole">{{ auth()->user()->role ?? 'Super Admin' }}</div>
                </div>
                <div class="topbar-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'SU', 0, 2)) }}
                </div>
            </div>
        </header>

        <!-- Page content -->
        <main class="page-content">
            @if(session('success'))
            <div class="alert-success">
                <div class="alert-success-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                {{ session('success') }}
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- ═══ LOGOUT MODAL ═══════════════════════════ -->
    <div id="logoutModal" class="modal-overlay" onclick="if(event.target===this)hideLogoutModal()">
        <div class="modal-card">
            <div class="modal-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </div>
            <h2 class="modal-title">Konfirmasi Keluar</h2>
            <p class="modal-desc">Apakah Anda yakin ingin keluar dari aplikasi? Anda harus masuk kembali untuk mengakses dashboard.</p>

            <div class="modal-btns">
                <button class="modal-btn-cancel" onclick="hideLogoutModal()">Batal</button>
                <form action="{{ route('logout') }}" method="POST" style="flex:1;">
                    @csrf
                    <button type="submit" class="modal-btn-confirm" style="width:100%;">Ya, Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showLogoutModal() {
            document.getElementById('logoutModal').classList.add('visible');
        }
        function hideLogoutModal() {
            document.getElementById('logoutModal').classList.remove('visible');
        }
    </script>

</body>
</html>
