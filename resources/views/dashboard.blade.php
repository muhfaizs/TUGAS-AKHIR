@extends('layouts.dashboard')

@section('title', 'Dashboard - SatuKIA')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ringkasan sistem monitoring layanan KIA dan KB')

@section('content')
    <!-- Welcome Banner -->
    <div class="bg-teal-700 rounded-3xl p-8 mb-8 text-white relative overflow-hidden shadow-lg">
        <div class="relative z-10">
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }}! 👋</h2>
            <p class="text-teal-100 max-w-2xl text-sm leading-relaxed">
                Berikut adalah ringkasan data sistem monitoring layanan KIA dan KB. Pastikan semua data ter-update untuk pelaporan yang akurat.
            </p>
        </div>
        <!-- Decorative shapes -->
        <div class="absolute right-0 top-0 w-64 h-64 bg-teal-600/50 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="absolute right-32 bottom-0 w-48 h-48 bg-teal-800/50 rounded-full blur-2xl -mb-10"></div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @if(Auth::user()->isSuperAdmin())
            <!-- Card 1: Total Bidan -->
            <a href="{{ route('bidan.index', ['role' => 'bidan']) }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-teal-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center text-teal-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $totalBidan ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-teal-600 transition-colors">Total Bidan Terdaftar</p>
                </div>
            </a>

            <!-- Card 2: Bidan Aktif -->
            <a href="{{ route('bidan.index', ['role' => 'bidan', 'status' => 'aktif']) }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-emerald-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $bidanAktif ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-emerald-600 transition-colors">Bidan Aktif</p>
                </div>
            </a>

            <!-- Card 3: Bidan Non-Aktif -->
            <a href="{{ route('bidan.index', ['role' => 'bidan', 'status' => 'nonaktif']) }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-rose-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $bidanNonaktif ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-rose-600 transition-colors">Bidan Non-Aktif</p>
                </div>
            </a>

            <!-- Card 4: Ibu Hamil Terdaftar -->
            <a href="{{ route('bidan.index', ['role' => 'ortu']) }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-indigo-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $ibuHamilTerdaftar ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-indigo-600 transition-colors">Ibu Hamil Terdaftar</p>
                </div>
            </a>

            <!-- Card 5: Dinkes Aktif -->
            <a href="{{ route('bidan.index', ['role' => 'dinkes', 'status' => 'aktif']) }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-purple-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $dinkesAktif ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-purple-600 transition-colors">Dinkes Aktif</p>
                </div>
            </a>

            <!-- Card 6: Dinkes Non-Aktif -->
            <a href="{{ route('bidan.index', ['role' => 'dinkes', 'status' => 'nonaktif']) }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-fuchsia-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-fuchsia-50 rounded-xl flex items-center justify-center text-fuchsia-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $dinkesNonaktif ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-fuchsia-600 transition-colors">Dinkes Non-Aktif</p>
                </div>
            </a>
        @elseif(Auth::user()->isBidanOnly())
            <!-- Card 1: Total Pasien Ibu Hamil -->
            <a href="{{ route('ibu-hamil.index') }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-teal-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center text-teal-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $totalPasien ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-teal-600 transition-colors">Total Pasien Ibu Hamil</p>
                </div>
            </a>

            <!-- Card 2: Pasien Aktif -->
            <a href="{{ route('ibu-hamil.index', ['status' => 'aktif']) }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-emerald-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $pasienAktif ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-emerald-600 transition-colors">Pasien Aktif</p>
                </div>
            </a>

            <!-- Card 3: Pasien Berisiko Tinggi -->
            <a href="{{ route('ibu-hamil.index', ['risiko' => 'tinggi']) }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-rose-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500 mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $pasienRisikoTinggi ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-rose-600 transition-colors">Pasien Berisiko Tinggi</p>
                </div>
            </a>

            <!-- Card 4: Ibu Hamil Meninggal -->
            <div class="bg-slate-800 rounded-3xl p-6 shadow-sm relative overflow-hidden transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-slate-700/80 rounded-xl flex items-center justify-center text-rose-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4M12 4v16" />
                        </svg>
                    </div>
                    <p class="text-white font-bold text-sm uppercase tracking-wider">Ibu Hamil Meninggal</p>
                </div>
                <div>
                    <h3 class="text-4xl font-extrabold text-white mb-1">{{ $ibuHamilMeninggal ?? 0 }} <span class="text-sm font-medium text-slate-400 lowercase">pasien</span></h3>
                </div>
                
                @if(isset($ibuHamilMeninggalList) && $ibuHamilMeninggalList->count() > 0)
                <div class="mt-4 pt-4 border-t border-slate-700">
                    <p class="text-xs text-slate-400 mb-2">Daftar Pasien:</p>
                    <ul class="text-sm text-white space-y-1">
                        @foreach($ibuHamilMeninggalList as $meninggal)
                            <li class="flex items-center gap-2 truncate">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 flex-shrink-0"></span>
                                <span class="truncate">{{ $meninggal->nama_lengkap }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @else
                <div class="mt-4 pt-4 border-t border-slate-700">
                    <p class="text-xs text-slate-500 italic">Belum ada data pasien.</p>
                </div>
                @endif
            </div>

            <!-- Card 5: Total Anak -->
            <a href="{{ route('bidan.anak.index') }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-sky-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-sky-50 rounded-xl flex items-center justify-center text-sky-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $totalAnak ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-sky-600 transition-colors">Total Anak (Bayi)</p>
                </div>
            </a>

            <!-- Card 6: Anak Berisiko Stunting -->
            <a href="{{ route('bidan.anak.index') }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-orange-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $anakBerisiko ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-orange-600 transition-colors">Anak Berisiko</p>
                </div>
            </a>

            <!-- Card 7: Total Akseptor Aktif KB -->
            <a href="{{ route('kb-acceptors.index', ['status' => 'active']) }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-teal-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center text-teal-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $kbTotalAkseptorAktif ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-teal-600 transition-colors">Total Akseptor Aktif</p>
                </div>
            </a>

            <!-- Card 8: Pelayanan KB Hari Ini -->
            <a href="{{ route('kb-services.index') }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-emerald-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-2 14l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $kbPelayananHariIni ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-emerald-600 transition-colors">Pelayanan Hari Ini</p>
                </div>
            </a>

            <!-- Card 9: Jadwal Kontrol KB Hari Ini -->
            <a href="{{ route('kb-services.jadwal-kontrol') }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-sky-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-sky-50 rounded-xl flex items-center justify-center text-sky-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $kbJadwalKontrolHariIni ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-sky-600 transition-colors">Jadwal Kontrol Hari Ini</p>
                </div>
            </a>

            <!-- Card 10: Terlambat Kontrol KB -->
            <a href="#kb-terlambat-section" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-orange-400 transition-all hover:-translate-y-1 hover:shadow-md group">
                <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $kbTerlambatKontrol ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm group-hover:text-orange-600 transition-colors">Terlambat Kontrol KB</p>
                </div>
            </a>


        @elseif(Auth::user()->isIbuHamil())
            @if(isset($ibuHamil) && $ibuHamil)
                <!-- Card 1: Usia Kehamilan -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-teal-400">
                    <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center text-teal-600 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $ibuHamil->usia_kehamilan }} <span class="text-sm font-medium text-slate-500">Minggu</span></h3>
                        <p class="text-slate-500 font-medium text-sm">Usia Kehamilan</p>
                    </div>
                </div>

                <!-- Card 2: HPHT -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-rose-400">
                    <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-800 mb-1">{{ $ibuHamil->hpht->format('d M Y') }}</h3>
                        <p class="text-slate-500 font-medium text-sm">Hari Pertama Haid Terakhir</p>
                    </div>
                </div>

                <!-- Card 3: HPL -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-indigo-400">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-800 mb-1">{{ $ibuHamil->hpl->format('d M Y') }}</h3>
                        <p class="text-slate-500 font-medium text-sm">Hari Perkiraan Lahir</p>
                    </div>
                </div>

                <!-- Card 4: Jadwal Pemeriksaan Selanjutnya -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-amber-400">
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-800 mb-1">{{ $ibuHamil->jadwal_selanjutnya }}</h3>
                        <p class="text-slate-500 font-medium text-sm">Jadwal Pemeriksaan Selanjutnya</p>
                    </div>
                </div>
            @else
                <div class="col-span-1 md:col-span-2 lg:col-span-4 bg-white rounded-3xl p-8 shadow-sm border border-slate-100 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Data Belum Tersedia</h3>
                    <p class="text-slate-500">Rekam medis Anda belum ditambahkan oleh Bidan. Silakan hubungi Bidan Anda untuk mendaftarkan data awal kehamilan.</p>
                </div>
            @endif
        @else
            <!-- Default View -->
            <!-- Card 1: Total Pengguna -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-teal-400">
                <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center text-teal-600 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $totalPengguna ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm">Total Pengguna</p>
                </div>
            </div>

            <!-- Card 2: Bidan Aktif -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-rose-400">
                <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $bidanAktif ?? 0 }}</h3>
                    <p class="text-slate-500 font-medium text-sm">Bidan Aktif</p>
                </div>
            </div>

            <!-- Card 3: Status Sistem -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-indigo-400">
                <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                        <h3 class="text-lg font-extrabold text-green-500">Aktif</h3>
                    </div>
                    <p class="text-slate-500 font-medium text-sm mt-3">Status Sistem</p>
                </div>
            </div>
        @endif
    </div>

    @if(Auth::user()->isBidanOnly())
        <!-- Alert Box KB removed and replaced with a table below -->

        <!-- Pasien Prioritas / Berisiko Table -->
        <div style="background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(13,148,136,0.04); border: 1px solid rgba(15,23,42,0.06); overflow: hidden; margin-top: 24px; margin-bottom: 32px;" id="pasien-prioritas-section">
            <div style="padding: 24px 28px; border-bottom: 1px solid rgba(15,23,42,0.06); display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(251,113,133,0.1); display: grid; place-items: center;">
                        <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: #FB7185;"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                    </div>
                    <div>
                        <h3 style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0;">Anak Berisiko Stunting / Prioritas</h3>
                        <p style="font-size: 13px; color: #64748B; margin: 2px 0 0;">Anak dengan flag risiko berdasarkan data pengukuran</p>
                    </div>
                </div>
                <span style="display: inline-flex; padding: 6px 14px; border-radius: 999px; font-size: 12px; font-weight: 600; background: rgba(251,113,133,0.1); color: #E11D48;">
                    {{ $anakPrioritasList->count() }} Anak
                </span>
            </div>

            @if($anakPrioritasList->isEmpty())
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
                                <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Tgl Ukur</th>
                                <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Status</th>
                                <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anakPrioritasList as $anak)
                                @php
                                    $latestPengukuran = $anak->latestPengukuran;
                                    
                                    $tglLahir = \Carbon\Carbon::parse($anak->tanggal_lahir);
                                    $now = \Carbon\Carbon::now();
                                    $diff = $tglLahir->diff($now);
                                    
                                    if ($diff->y > 0) {
                                        $usiaText = $diff->y . ' Thn ' . $diff->m . ' Bln';
                                    } else {
                                        $usiaText = $diff->m . ' Bln';
                                    }
                                @endphp
                                <tr style="transition: background 0.2s;" onmouseover="this.style.background='rgba(248,250,252,0.5)';" onmouseout="this.style.background='transparent';">
                                    <td style="padding: 16px 24px; border-bottom: 1px solid rgba(15,23,42,0.04);">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #0D9488; color: white; display: grid; place-items: center; font-weight: 700; font-size: 14px; flex-shrink: 0;">
                                                {{ substr($anak->nama_anak, 0, 1) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 600; font-size: 14px; color: #0F172A;">{{ $anak->nama_anak }}</div>
                                                <div style="font-size: 12px; color: #64748B; margin-top: 2px;">{{ $anak->jenis_kelamin }}</div>
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

                                            @if(($anak->nomor_kontak_darurat) || ($anak->orangTua && $anak->orangTua->phone))
                                                <!-- Panggilan Sistem -->
                                                <form action="{{ route('bidan.anak.send-system', $anak->id_anak) }}" method="POST" style="display:inline;" title="Kirim notifikasi panggilan via Sistem">
                                                    @csrf
                                                    <button type="submit" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: rgba(234,179,8,0.1); color: #CA8A04; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(234,179,8,0.2)';" onmouseout="this.style.background='rgba(234,179,8,0.1)';">
                                                        <svg viewBox="0 0 24 24" style="width: 14px; height: 14px; fill: currentColor;"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                                                        Panggilan Sistem
                                                    </button>
                                                </form>

                                                <!-- Kirim WA -->
                                                <form action="{{ route('bidan.anak.send-notification', $anak->id_anak) }}" method="POST" target="_blank" style="display:inline;" title="Kirim laporan via WhatsApp">
                                                    @csrf
                                                    <button type="submit" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: rgba(34,197,94,0.1); color: #16A34A; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(34,197,94,0.2)';" onmouseout="this.style.background='rgba(34,197,94,0.1)';">
                                                        <svg viewBox="0 0 24 24" style="width: 14px; height: 14px; fill: currentColor;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                                        Kirim Notif WA
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

        <!-- Priority Patients Table -->
        @if(isset($pasienPrioritasList) && $pasienPrioritasList->count() > 0)
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 mt-8 mb-8 relative overflow-hidden">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Pasien Prioritas / Berisiko</h3>
                    <p class="text-sm text-slate-500">Ibu hamil dengan flag risiko tinggi berdasarkan data pemeriksaan</p>
                </div>
                <div class="ml-auto">
                    <span class="bg-rose-50 text-rose-600 py-1 px-3 rounded-full text-xs font-bold">{{ $pasienPrioritasList->count() }} Pasien</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">NAMA IBU HAMIL</th>
                            <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">USIA</th>
                            <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">STATUS</th>
                            <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">TINDAK MEDIS</th>
                            <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($pasienPrioritasList as $pasien)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="py-4 border-b border-slate-50">
                                <a href="{{ route('ibu-hamil.show', $pasien->id) }}" class="flex items-center gap-3 group/profile hover:opacity-80 transition-opacity">
                                    <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center font-bold">
                                        {{ substr($pasien->nama_lengkap, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 group-hover/profile:text-teal-600 transition-colors">{{ $pasien->nama_lengkap }}</p>
                                        <p class="text-xs text-slate-500">Pekerjaan: {{ $pasien->pekerjaan ?? '-' }}</p>
                                    </div>
                                </a>
                            </td>
                            <td class="py-4 border-b border-slate-50 text-slate-600 font-medium">{{ $pasien->umur }} Thn</td>
                            <td class="py-4 border-b border-slate-50">
                                <span class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-md text-xs font-bold inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    {{ $pasien->status_risiko_kehamilan }}
                                </span>
                            </td>
                            <td class="py-4 border-b border-slate-50 text-slate-600">
                                <span class="truncate block max-w-[200px]" title="{{ $pasien->tindakan_medis }}">
                                    {{ $pasien->tindakan_medis ?: 'Belum ada tindakan medis tercatat.' }}
                                </span>
                            </td>
                            <td class="py-4 border-b border-slate-50 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('ibu-hamil.show', $pasien->id) }}" class="p-2 text-teal-600 hover:bg-teal-50 rounded-lg transition-colors" title="Lihat Riwayat">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('ibu-hamil.edit', $pasien->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit Tindakan">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('ibu-hamil.turun-risiko', $pasien->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin pasien ini sudah bukan prioritas? (Status risiko akan diturunkan menjadi Rendah)');" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus dari Prioritas">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Akseptor KB Terlambat Kontrol Table -->
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 mt-8 mb-8 relative overflow-hidden" id="kb-terlambat-section">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-orange-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Akseptor KB Terlambat Kontrol / Prioritas</h3>
                    <p class="text-sm text-slate-500">Pasien KB yang melewati jadwal tindak lanjut pelayanannya</p>
                </div>
                <div class="ml-auto">
                    <span class="bg-orange-50 text-orange-600 py-1 px-3 rounded-full text-xs font-bold">{{ isset($kbTerlambatKontrolList) ? $kbTerlambatKontrolList->count() : 0 }} Pasien</span>
                </div>
            </div>

            @if(!isset($kbTerlambatKontrolList) || $kbTerlambatKontrolList->isEmpty())
                <div class="text-center py-12 text-slate-500">
                    <svg viewBox="0 0 24 24" class="w-12 h-12 fill-slate-300 mx-auto mb-3 block"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    <p class="text-[15px] font-semibold mb-1 text-slate-700">Tidak Ada Pasien KB Terlambat Kontrol</p>
                    <p class="text-[13px] m-0">Semua akseptor KB masih dalam batas jadwal kontrol yang aman.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">NAMA AKSEPTOR</th>
                                <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">METODE KB</th>
                                <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">JADWAL KONTROL</th>
                                <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">STATUS</th>
                                <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100 text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($kbTerlambatKontrolList->take(10) as $acceptor)
                            @php
                                $latestService = $acceptor->kbServices->first();
                                $daysOverdue = $latestService && $latestService->follow_up_date ? \Carbon\Carbon::parse($latestService->follow_up_date)->diffInDays(now()) : 0;
                            @endphp
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="py-4 border-b border-slate-50">
                                    <a href="{{ route('kb-acceptors.show', $acceptor->id) }}" class="flex items-center gap-3 group/profile hover:opacity-80 transition-opacity">
                                        <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-700 flex items-center justify-center font-bold">
                                            {{ substr($acceptor->full_name, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 group-hover/profile:text-teal-600 transition-colors">{{ $acceptor->full_name }}</p>
                                            <p class="text-xs text-slate-500">NIK: {{ $acceptor->nik ?? '-' }}</p>
                                        </div>
                                    </a>
                                </td>
                                <td class="py-4 border-b border-slate-50 text-slate-600 font-medium">
                                    {{ $latestService->service_method ?? '-' }}
                                </td>
                                <td class="py-4 border-b border-slate-50 text-slate-600">
                                    {{ $latestService && $latestService->follow_up_date ? \Carbon\Carbon::parse($latestService->follow_up_date)->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="py-4 border-b border-slate-50">
                                    <span class="px-2.5 py-1 bg-orange-100 text-orange-700 rounded-md text-xs font-bold inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                        Terlambat {{ floor($daysOverdue) }} Hari
                                    </span>
                                </td>
                                <td class="py-4 border-b border-slate-50 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('kb-acceptors.show', $acceptor->id) }}" class="p-2 text-teal-600 hover:bg-teal-50 rounded-lg transition-colors" title="Lihat Riwayat">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
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
    @elseif(Auth::user()->isIbuHamil() && isset($ibuHamil) && $ibuHamil)
        <!-- Download PDF Rekap -->
        <div class="flex justify-between items-center mt-10 mb-6">
            <div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Grafik Perkembangan Janin</h3>
                <p class="text-slate-500 font-medium text-sm mt-1">Pantau perkembangan TFU, DJJ, dan Berat Badan Ibu dari waktu ke waktu.</p>
            </div>
            @if(isset($ibuHamil) && $ibuHamil && $ibuHamil->pemeriksaanAncs && $ibuHamil->pemeriksaanAncs->count() > 0)
            <a href="{{ route('ibu-hamil.cetak-rekap', $ibuHamil->id) }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-teal-600/30 transition-all active:scale-95 group" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download Rekap PDF
            </a>
            @else
            <a href="#" onclick="event.preventDefault(); alert('Tidak ada data pemeriksaan yang bisa didownload!');" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-teal-600/30 transition-all active:scale-95 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download Rekap PDF
            </a>
            @endif
        </div>

        <!-- Chart Section -->
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 mb-8 relative overflow-hidden">
            @if($ibuHamil->pemeriksaanAncs && $ibuHamil->pemeriksaanAncs->count() > 0)
                <div class="w-full h-[400px]">
                    <canvas id="perkembanganChart"></canvas>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700 mb-1">Belum ada grafik</h3>
                    <p class="text-slate-500 font-medium">Data pemeriksaan ANC belum tersedia untuk menampilkan perkembangan janin.</p>
                </div>
            @endif
        </div>

    @endif
@endsection

@push('scripts')
@if(Auth::user()->isIbuHamil() && isset($ibuHamil) && $ibuHamil && $ibuHamil->pemeriksaanAncs->count() > 0)
@php
    $ancData = $ibuHamil->pemeriksaanAncs->sortBy('tanggal_pemeriksaan')->values();
    $labels = $ancData->map(function($item) {
        return $item->tanggal_pemeriksaan->format('d M y');
    })->toJson();
    
    $dataTfu = $ancData->map(function($item) {
        return $item->tinggi_fundus_uteri ?: 0;
    })->toJson();
    
    $dataDjj = $ancData->map(function($item) {
        return $item->denyut_jantung_janin ?: 0;
    })->toJson();

    $dataBb = $ancData->map(function($item) {
        return $item->berat_badan ?: 0;
    })->toJson();
@endphp
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('perkembanganChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! $labels !!},
                    datasets: [
                        {
                            label: 'Tinggi Fundus Uteri (cm)',
                            data: {!! $dataTfu !!},
                            borderColor: '#ec4899', // pink-500
                            backgroundColor: '#fbcfe8', // pink-200
                            borderWidth: 2,
                            tension: 0.4,
                            yAxisID: 'y',
                            pointBackgroundColor: '#ec4899',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'DJJ (bpm)',
                            data: {!! $dataDjj !!},
                            borderColor: '#0d9488', // teal-600
                            backgroundColor: '#99f6e4', // teal-200
                            borderWidth: 2,
                            tension: 0.4,
                            yAxisID: 'y1',
                            pointBackgroundColor: '#0d9488',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Berat Badan Ibu (kg)',
                            data: {!! $dataBb !!},
                            borderColor: '#f59e0b', // amber-500
                            backgroundColor: '#fde68a', // amber-200
                            borderWidth: 2,
                            tension: 0.4,
                            borderDash: [5, 5],
                            yAxisID: 'y',
                            pointBackgroundColor: '#f59e0b',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8,
                                font: {
                                    family: "'Inter', sans-serif",
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.95)',
                            padding: 16,
                            titleFont: { size: 14, family: "'Inter', sans-serif" },
                            bodyFont: { size: 14, family: "'Inter', sans-serif" },
                            cornerRadius: 12,
                            boxPadding: 6
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'TFU (cm) / BB (kg)',
                                font: { size: 11, weight: 'bold', family: "'Inter', sans-serif" },
                                color: '#64748b'
                            },
                            suggestedMin: 0,
                            grid: {
                                color: '#f1f5f9',
                                borderDash: [4, 4]
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'DJJ (bpm)',
                                font: { size: 11, weight: 'bold', family: "'Inter', sans-serif" },
                                color: '#64748b'
                            },
                            grid: {
                                drawOnChartArea: false,
                            },
                            suggestedMin: 100,
                            suggestedMax: 160
                        }
                    }
                }
            });
        }
    });
</script>
@endif
@endpush

