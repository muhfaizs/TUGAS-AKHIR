<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SatuKIA - Monitoring KIA')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Simple DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3/dist/style.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
        }
        .bg-brand-sidebar {
            background-color: #115e59; /* teal-800 */
        }
        /* Custom scrollbar for DataTables */
        .datatable-wrapper .datatable-container {
            overflow-x: auto;
        }
        /* Hide spin buttons for input type="number" globally */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }
        input[type="number"] {
            -moz-appearance: textfield !important;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex bg-slate-50 text-slate-800">

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-brand-sidebar text-white flex flex-col fixed inset-y-0 left-0 z-50 shadow-xl transition-transform duration-300 transform -translate-x-full lg:translate-x-0">
        <!-- Logo -->
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-teal-800 font-extrabold text-lg shadow-sm">
                SK
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight leading-tight">SatuKIA</h1>
                <p class="text-[10px] text-teal-200 font-medium tracking-widest uppercase">Monitoring KIA</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 mt-6 space-y-2">
            @if(Auth::user()->isDinkes())
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard Eksekutif
            </a>
            <a href="{{ route('dinkes.laporan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('dinkes.laporan') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan Rekapitulasi
            </a>
            @else
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>
            @if(Auth::user()->isOrtu())
            <a href="{{ route('ortu.pemeriksaan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('ortu.pemeriksaan') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Data Pemeriksaan
            </a>
            @endif
            @endif

            @if(Auth::user()->isSuperAdmin())
            <a href="{{ route('bidan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('bidan.*') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Kelola Pengguna
            </a>
            @endif
            

            @if(Auth::user()->isBidanOnly())
            <a href="{{ route('ibu-hamil.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('ibu-hamil.*') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Data Ibu Hamil
            </a>
            
            <a href="{{ route('rujukan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('rujukan.*') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Surat Rujukan
            </a>
            
            <a href="{{ route('bidan.laporan-bulanan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('bidan.laporan-bulanan') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Laporan Bulanan
            </a>

            <a href="{{ route('bidan.laporan-tahunan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('bidan.laporan-tahunan') ? 'bg-white/10 text-white' : 'text-teal-100 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan Tahunan
            </a>
            @endif
        </nav>

        <!-- Bottom Actions -->
        <div class="p-4 mt-auto space-y-1">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-teal-100 hover:bg-white/10 hover:text-white font-medium transition-colors {{ request()->routeIs('profile.*') ? 'bg-white/10 text-white' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profil Saya
            </a>
            <button type="button" onclick="document.getElementById('logout-modal').classList.remove('hidden')" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-300 hover:bg-white/10 hover:text-red-100 font-medium transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-75 transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 flex-1 flex flex-col min-h-screen transition-all w-full min-w-0">
        <!-- Header -->
        <header class="min-h-24 py-4 px-4 md:px-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/60 bg-white/80 backdrop-blur-md sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button type="button" onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl bg-white text-slate-600 hover:bg-slate-50 shadow-sm border border-slate-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-slate-800 leading-tight">@yield('header_title')</h2>
                    <p class="text-xs md:text-sm text-slate-500 mt-0.5 line-clamp-1">@yield('header_subtitle')</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 self-start sm:self-auto">
                
                @if(Auth::user()->isDinkes())
                <!-- Notification Bell -->
                <div class="relative">
                    <button type="button" onclick="document.getElementById('notif-dropdown').classList.toggle('hidden')" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-200 text-slate-500 hover:text-teal-600 hover:border-teal-300 transition-colors relative focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full border-2 border-white">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                        @endif
                    </button>
                    
                    <!-- Dropdown -->
                    <div id="notif-dropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden hidden z-50">
                        <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <h3 class="font-bold text-sm text-slate-800">Notifikasi Baru</h3>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="text-xs bg-teal-100 text-teal-700 px-2 py-0.5 rounded-full font-medium">{{ Auth::user()->unreadNotifications->count() }} Baru</span>
                            @endif
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            @forelse(Auth::user()->unreadNotifications as $notification)
                            <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 border-b border-slate-50 hover:bg-slate-50 transition-colors">
                                <p class="text-sm text-slate-700">{{ $notification->data['message'] }}</p>
                                <span class="text-[10px] text-slate-400 mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                            @empty
                            <div class="px-4 py-6 text-center text-sm text-slate-500">
                                Tidak ada notifikasi baru
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                @endif

                <!-- Profile Badge -->
                <div class="flex items-center gap-3 bg-white px-3 md:px-4 py-2 rounded-2xl shadow-sm border border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-sm shrink-0">
                        {{ substr(Auth::user()->name ?? 'U', 0, 2) }}
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-sm font-bold text-slate-800 line-clamp-1">{{ Auth::user()->name ?? 'User' }}</p>
                        <p class="text-xs text-slate-500 font-semibold capitalize">
                            @if(Auth::user()->isSuperAdmin())
                                Super Administrator
                            @elseif(Auth::user()->isBidanOnly())
                                Bidan
                            @elseif(Auth::user()->isDinkes())
                                Dinkes
                            @else
                                Ibu Hamil
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-4 md:p-8 flex-1 overflow-x-hidden">
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Logout Modal -->
    <div id="logout-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl relative text-center">
            <!-- Icon -->
            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </div>
            
            <!-- Title & Text -->
            <h3 class="text-xl font-bold text-slate-800 mb-2">Konfirmasi Keluar</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                Apakah Anda yakin ingin keluar dari aplikasi? Anda harus masuk kembali untuk mengakses dashboard.
            </p>
            
            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="button" onclick="document.getElementById('logout-modal').classList.add('hidden')" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}" class="flex-1 m-0" onsubmit="return handleLogoutEffect(this);">
                    @csrf
                    <button type="submit" id="btn-confirm-logout" class="w-full h-full px-4 py-2.5 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition-all active:scale-95 flex items-center justify-center gap-2">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Simple DataTables JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        function handleLogoutEffect(form) {
            const btn = form.querySelector('#btn-confirm-logout');
            
            // Ubah tombol menjadi loading state
            btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...`;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            btn.disabled = true;

            // Efek fade out pada seluruh halaman
            document.body.style.transition = "opacity 0.8s ease-out";
            document.body.style.opacity = "0.3";

            // Submit form secara manual setelah UI berubah
            setTimeout(() => {
                form.submit();
            }, 100);

            return false; // Mencegah submit default seketika agar UI sempat merender efek
        }

        // Mencegah scroll wheel (efek spinner) merubah value pada input type number, tapi tetap biarkan halaman di-scroll
        document.addEventListener('wheel', function(event) {
            if (document.activeElement.type === 'number') {
                document.activeElement.blur();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
