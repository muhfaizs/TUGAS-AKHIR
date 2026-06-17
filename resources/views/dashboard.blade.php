@extends('layouts.dashboard')

@section('title', 'Dashboard - SatuKIA')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ringkasan sistem monitoring layanan Ibu Hamil')

@section('content')
    <!-- Welcome Banner -->
    <div class="bg-teal-700 rounded-3xl p-8 mb-8 text-white relative overflow-hidden shadow-lg">
        <div class="relative z-10">
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }}! ðŸ‘‹</h2>
            <p class="text-teal-100 max-w-2xl text-sm leading-relaxed">
                Berikut adalah ringkasan data sistem monitoring layanan Ibu Hamil. Pastikan semua data ter-update untuk pelaporan yang akurat.
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

        @elseif(Auth::user()->isOrtu())
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
    @elseif(Auth::user()->isOrtu() && isset($ibuHamil) && $ibuHamil)
        <!-- Download PDF Rekap -->
        <div class="flex justify-between items-center mt-10 mb-6">
            <div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Grafik Perkembangan Janin</h3>
                <p class="text-slate-500 font-medium text-sm mt-1">Pantau perkembangan TFU, DJJ, dan Berat Badan Ibu dari waktu ke waktu.</p>
            </div>
            @if(isset($ibuHamil) && $ibuHamil && $ibuHamil->pemeriksaanAncs && $ibuHamil->pemeriksaanAncs->count() > 0)
            <a href="{{ route('ortu.download-rekap') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-teal-600/30 transition-all active:scale-95 group">
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
@if(Auth::user()->isOrtu() && isset($ibuHamil) && $ibuHamil && $ibuHamil->pemeriksaanAncs->count() > 0)
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

