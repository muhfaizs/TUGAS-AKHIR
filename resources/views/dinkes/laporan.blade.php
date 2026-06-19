@extends('layouts.dashboard')

@section('title', 'Laporan Rekapitulasi Dinkes - SatuKIA')
@section('page_title', 'Laporan Rekapitulasi')
@section('page_subtitle', 'Filter dan unduh data riwayat pemeriksaan ibu hamil')

@section('content')
    <!-- Filter Section -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 mb-8">
        <form action="#" method="GET" class="flex flex-col md:flex-row md:items-end gap-6">
            <div class="flex-1">
                <label for="puskesmas" class="block text-sm font-semibold text-slate-700 mb-2">Puskesmas</label>
                <select id="puskesmas" name="puskesmas" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-teal-500 focus:border-teal-500">
                    <option value="Bojongsoang" selected>Puskesmas Bojongsoang</option>
                </select>
            </div>
            
            <div class="flex-1">
                <label for="start_date" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Awal</label>
                <div class="relative">
                    <input type="date" id="start_date" name="start_date" value="2026-05-01" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
            </div>
            
            <div class="flex-1">
                <label for="end_date" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Akhir</label>
                <div class="relative">
                    <input type="date" id="end_date" name="end_date" value="2026-05-31" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
            </div>
            
            <div class="flex gap-3 mt-4 md:mt-0">
                <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl transition-colors shadow-sm shadow-teal-500/20 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Tampilkan Laporan
                </button>
                <a href="{{ route('dinkes.laporan') }}" class="px-6 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold rounded-xl transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="mb-8">
        <h3 class="text-xl font-bold text-slate-800 mb-4">Ringkasan Indikator Layanan KIA (Ibu Hamil, Bayi & KB)</h3>

        <h4 class="text-md font-bold text-slate-700 mb-3 border-b pb-2">Kesehatan Ibu Hamil</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
            
            <!-- K1 -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">K1 (Trimester 1)</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $metrics['k1'] }}</p>
                </div>
            </div>

            <!-- Triple Eliminasi -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Triple Eliminasi</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $metrics['triple_eliminasi'] }}</p>
                </div>
            </div>

            <!-- KEK -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Gizi Buruk (KEK)</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $metrics['kek'] }}</p>
                </div>
            </div>

            <!-- Anemia -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kasus Anemia</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $metrics['anemia'] }}</p>
                </div>
            </div>

            <!-- Faktor Risiko -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Faktor Risiko</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $metrics['faktor_risiko'] }}</p>
                </div>
            </div>

            <!-- Komplikasi Kebidanan -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-pink-50 flex items-center justify-center text-pink-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Komplikasi</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $metrics['komplikasi'] }}</p>
                </div>
            </div>

            <!-- Rujukan FKRTL -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Rujukan FKRTL</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $metrics['rujukan'] }}</p>
                </div>
            </div>

            <!-- Pemberian TTD -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">TTD >= 90</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $metrics['ttd_90'] }}</p>
                </div>
            </div>

            <!-- Kematian -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-800 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kematian Ibu</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $metrics['kematian'] }}</p>
                </div>
            </div>

        </div>

        <h4 class="text-md font-bold text-slate-700 mt-6 mb-3 border-b pb-2">Kesehatan Bayi & Cakupan Imunisasi</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Bayi -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4 border-l-4 border-l-emerald-400">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Bayi</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalAnak ?? 0 }}</p>
                </div>
            </div>

            <!-- Bayi Berisiko -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4 border-l-4 border-l-orange-400">
                <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 shrink-0">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Berisiko Stunting</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $anakBerisiko ?? 0 }}</p>
                </div>
            </div>

            <!-- Total Imunisasi -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4 border-l-4 border-l-blue-400">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M11 2v4h2V2h-2zm0 14h2v6h-2v-6zm3-11v2h2v2h-2v2h2v2h-2v2h2v2h-2v2h4V5h-4zm-8 4v2h2V9H6zm0 4v2h2v-2H6z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Imunisasi</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalImunisasi ?? 0 }}</p>
                </div>
            </div>
        </div>

        <h4 class="text-md font-bold text-slate-700 mt-6 mb-3 border-b pb-2">Keluarga Berencana (KB)</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Total KB -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4 border-l-4 border-l-purple-400">
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 shrink-0">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Akseptor</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalKb ?? 0 }}</p>
                </div>
            </div>

            <!-- KB Aktif -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4 border-l-4 border-l-pink-400">
                <div class="w-12 h-12 rounded-xl bg-pink-50 flex items-center justify-center text-pink-600 shrink-0">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Akseptor Aktif</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $kbAktif ?? 0 }}</p>
                </div>
            </div>

            <!-- Akseptor Risiko Tinggi -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4 border-l-4 border-l-red-400">
                <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Risiko Tinggi</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $kbRisikoTinggi ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 border-b pb-4">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Detail Pasien Ibu Hamil</h3>
                <p class="text-sm text-slate-500 mt-1">Menampilkan {{ $ibuHamils->count() }} data pemeriksaan ibu hamil</p>
            </div>
            <div class="flex gap-3">
                @if($ibuHamils->count() > 0)
                <a href="{{ route('dinkes.export-pdf') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm">
                @else
                <a href="#" onclick="event.preventDefault(); alert('Tidak ada data pemeriksaan yang bisa didownload!');" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm opacity-80 cursor-not-allowed">
                @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export PDF
                </a>
                
                @if($ibuHamils->count() > 0)
                <a href="{{ route('dinkes.export-excel') }}" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm shadow-green-500/20">
                @else
                <a href="#" onclick="event.preventDefault(); alert('Tidak ada data pemeriksaan yang bisa didownload!');" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm shadow-green-500/20 opacity-80 cursor-not-allowed">
                @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Tanggal</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Bidan/Faskes</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Pasien</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100 text-center">K1</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100 text-center">Trp Eliminasi</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100 text-center">KEK</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100 text-center">Anemia</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100 text-center">F. Risiko</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100 text-center">Komplikasi</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100 text-center">Rujukan</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100 text-center">TTD>=90</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100 text-center">Kematian</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($ibuHamils as $pasien)
                    @php 
                        $hasK1 = false;
                        $hasTripleEliminasi = false;
                        $hasKek = false;
                        $hasAnemia = false;
                        $hasTtd90 = false;
                        $hasFaktorRisiko = ($pasien->umur < 20 || $pasien->umur > 35);
                        
                        foreach ($pasien->pemeriksaanAncs as $anc) {
                            if ($anc->usia_kehamilan_minggu <= 12) $hasK1 = true;
                            if ($anc->lab_hiv || $anc->lab_sifilis || $anc->lab_hepatitis_b) $hasTripleEliminasi = true;
                            if ($anc->lingkar_lengan_atas && $anc->lingkar_lengan_atas < 23.5) $hasKek = true;
                            if ($anc->lab_hb && $anc->lab_hb < 11) $hasAnemia = true;
                            if ($anc->tinggi_badan && $anc->tinggi_badan < 145) $hasFaktorRisiko = true;
                            if ($anc->jumlah_tablet_darah >= 90) $hasTtd90 = true;
                        }
                        
                        $hasKomplikasi = ($pasien->status_risiko_kehamilan == 'Sangat Tinggi');
                        $hasRujukan = ($pasien->status_risiko_kehamilan == 'Sangat Tinggi');
                        $hasKematian = ($pasien->status_ibu_meninggal == 'Meninggal');
                        $latestAnc = $pasien->pemeriksaanAncs->first(); 
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors border-b border-slate-50">
                        <td class="py-4 px-4 font-medium text-slate-700 whitespace-nowrap">{{ $pasien->tanggal_registrasi_pasien ? $pasien->tanggal_registrasi_pasien->format('d M y') : '-' }}</td>
                        <td class="py-4 px-4">
                            <p class="font-bold text-slate-800">{{ $pasien->bidan->name ?? '-' }}</p>
                        </td>
                        <td class="py-4 px-4">
                            <p class="font-bold text-slate-800 whitespace-nowrap">{{ $pasien->nama_lengkap }}</p>
                            <p class="text-[10px] text-slate-500">Usia: {{ $pasien->umur }} thn</p>
                        </td>
                        <td class="py-4 px-4 text-center">
                            {!! $hasK1 ? '<span class="text-teal-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                        </td>
                        <td class="py-4 px-4 text-center">
                            {!! $hasTripleEliminasi ? '<span class="text-indigo-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                        </td>
                        <td class="py-4 px-4 text-center">
                            {!! $hasKek ? '<span class="text-orange-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                        </td>
                        <td class="py-4 px-4 text-center">
                            {!! $hasAnemia ? '<span class="text-red-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                        </td>
                        <td class="py-4 px-4 text-center">
                            {!! $hasFaktorRisiko ? '<span class="text-purple-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                        </td>
                        <td class="py-4 px-4 text-center">
                            {!! $hasKomplikasi ? '<span class="text-pink-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                        </td>
                        <td class="py-4 px-4 text-center">
                            {!! $hasRujukan ? '<span class="text-amber-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                        </td>
                        <td class="py-4 px-4 text-center">
                            {!! $hasTtd90 ? '<span class="text-emerald-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                        </td>
                        <td class="py-4 px-4 text-center">
                            {!! $hasKematian ? '<span class="text-slate-800 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-slate-500">
                            Belum ada data pemeriksaan ibu hamil yang masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detail Pasien Anak -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 mt-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 border-b pb-4">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Detail Layanan Bayi & Imunisasi</h3>
                <p class="text-sm text-slate-500 mt-1">Menampilkan {{ $anaks->count() }} data layanan bayi</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('dinkes.export-bayi-pdf') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export PDF
                </a>
                
                <a href="{{ route('dinkes.export-bayi-excel') }}" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm shadow-green-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Tanggal</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Nama Anak</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Posyandu</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">BB / TB</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Status Gizi</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Tindakan & Imunisasi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($laporanAnak as $data)
                    <tr class="hover:bg-slate-50 transition-colors border-b border-slate-50">
                        <td class="py-4 px-4 font-medium text-slate-700 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        <td class="py-4 px-4">
                            <p class="font-bold text-slate-800">{{ $data->anak->nama_anak ?? '-' }}</p>
                            <p class="text-[10px] text-slate-500">NIK: {{ $data->anak->nik_anak ?? '-' }}</p>
                        </td>
                        <td class="py-4 px-4">
                            <p class="font-bold text-slate-800 whitespace-nowrap">{{ $data->posyandu }}</p>
                            @if(count($data->pelaksana) > 0)
                                <p class="text-[10px] text-slate-500 mt-1">{{ implode(', ', $data->pelaksana) }}</p>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-slate-700">
                            @if($data->pengukuran)
                                <span class="font-semibold">{{ $data->pengukuran->berat_badan }} kg</span> / <span class="font-semibold">{{ $data->pengukuran->tinggi_badan }} cm</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            @if($data->pengukuran)
                                @if(str_contains(strtolower($data->pengukuran->status_stunting), 'stunting'))
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-md text-xs font-bold">{{ $data->pengukuran->status_stunting }}</span><br>
                                @endif
                                @if(str_contains(strtolower($data->pengukuran->status_gizi), 'kurang') || str_contains(strtolower($data->pengukuran->status_gizi), 'buruk'))
                                    <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-md text-xs font-bold mt-1 inline-block">{{ $data->pengukuran->status_gizi }}</span>
                                @else
                                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-md text-xs font-bold mt-1 inline-block">{{ $data->pengukuran->status_gizi }}</span>
                                @endif
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            <div class="space-y-1">
                                @if($data->tindakan || $data->imunisasi)
                                    @if($data->imunisasi)
                                        <div class="text-[11px] text-blue-600 bg-blue-50 px-2 py-1 rounded-md mb-1"><span class="font-bold">Vaksin:</span> {{ $data->imunisasi->nama_vaksin }}</div>
                                    @endif
                                    @if($data->tindakan)
                                        <div class="text-[11px] text-red-600 bg-red-50 px-2 py-1 rounded-md mb-1"><span class="font-bold">Tindakan:</span> {{ \Illuminate\Support\Str::limit($data->tindakan->diagnosa, 20) }}</div>
                                    @endif
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">
                            Belum ada data layanan bayi yang masuk sesuai filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detail KB -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 mt-8 mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 border-b pb-4">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Detail Layanan KB</h3>
                <p class="text-sm text-slate-500 mt-1">Menampilkan {{ $kbAkseptors->count() }} data layanan KB</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('dinkes.export-kb-pdf') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export PDF
                </a>
                
                <a href="{{ route('dinkes.export-kb-excel') }}" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm shadow-green-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Nama Akseptor</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">NIK</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Metode KB</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Kunjungan Terakhir</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Status</th>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Tingkat Risiko</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($kbAkseptors as $kb)
                    <tr class="hover:bg-slate-50 transition-colors border-b border-slate-50">
                        <td class="py-4 px-4 font-medium text-slate-700 whitespace-nowrap">{{ $kb->full_name ?? '-' }}</td>
                        <td class="py-4 px-4 font-medium text-slate-700 whitespace-nowrap">{{ $kb->nik ?? '-' }}</td>
                        <td class="py-4 px-4 font-medium text-slate-700 whitespace-nowrap">{{ $kb->lastService()->service_method ?? '-' }}</td>
                        <td class="py-4 px-4 font-medium text-slate-700 whitespace-nowrap">
                            {{ $kb->lastService() && $kb->lastService()->service_date ? \Carbon\Carbon::parse($kb->lastService()->service_date)->translatedFormat('d M Y') : '-' }}
                        </td>
                        <td class="py-4 px-4">
                            @if(strtolower($kb->status) == 'active' || strtolower($kb->status) == 'aktif')
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-md text-xs font-bold uppercase">Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-slate-100 text-slate-700 rounded-md text-xs font-bold uppercase">{{ $kb->status }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            @php
                                $lastService = $kb->lastService();
                            @endphp
                            @if($lastService && $lastService->risk_level == 'Tinggi')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-red-50 text-red-700 border border-red-100 uppercase tracking-wide">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span> Risiko Tinggi
                                </span>
                            @elseif($lastService && $lastService->risk_level == 'Sedang')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-50 text-yellow-700 border border-yellow-100 uppercase tracking-wide">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5"></span> Risiko Sedang
                                </span>
                            @elseif($lastService)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-green-50 text-green-700 border border-green-100 uppercase tracking-wide">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span> Risiko Rendah
                                </span>
                            @else
                                <span class="text-slate-400 text-xs italic">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">
                            Belum ada data akseptor KB yang masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

