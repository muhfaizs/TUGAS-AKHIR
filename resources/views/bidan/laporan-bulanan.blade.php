@extends('layouts.dashboard')

@section('title', 'Laporan Bulanan Dinkes - SatuKIA')
@section('page_title', 'Laporan Bulanan Dinkes')
@section('page_subtitle', 'Laporan rekapitulasi pemeriksaan ANC per bulan')

@section('content')
    <!-- Filter Section -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 mb-8">
        <form action="{{ route('bidan.laporan-bulanan') }}" method="GET" class="flex flex-col md:flex-row md:items-end gap-6">
            <div class="flex-1">
                <label for="bulan" class="block text-sm font-semibold text-slate-700 mb-2">Bulan</label>
                <select id="bulan" name="bulan" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-teal-500 focus:border-teal-500">
                    @php
                        $months = [
                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                        ];
                    @endphp
                    @foreach($months as $key => $name)
                        <option value="{{ $key }}" {{ request('bulan', date('m')) == $key ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1">
                <label for="tahun" class="block text-sm font-semibold text-slate-700 mb-2">Tahun</label>
                <select id="tahun" name="tahun" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-teal-500 focus:border-teal-500">
                    @php
                        $currentYear = date('Y');
                    @endphp
                    @for($y = $currentYear; $y >= $currentYear - 5; $y--)
                        <option value="{{ $y }}" {{ request('tahun', $currentYear) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            
            <div class="flex gap-3 mt-4 md:mt-0">
                <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl transition-colors shadow-sm shadow-teal-500/20 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Tampilkan Laporan
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="mb-8">
        <h3 class="text-xl font-bold text-slate-800 mb-4">Ringkasan Indikator (Berdasarkan Filter)</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            
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
    </div>

    <!-- Results Section -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Laporan Bulanan</h3>
                <p class="text-sm text-slate-500 mt-1">Bulan {{ $months[request('bulan', date('m'))] }} {{ request('tahun', date('Y')) }} â€¢ {{ $ibuHamils->count() }} data pemeriksaan</p>
            </div>
            <div class="flex gap-3">
                @if($ibuHamils->count() > 0)
                <a href="{{ route('bidan.laporan-export', ['type' => 'bulanan', 'format' => 'pdf', 'bulan' => request('bulan', date('m')), 'tahun' => request('tahun', date('Y'))]) }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm">
                @else
                <a href="#" onclick="event.preventDefault(); alert('Tidak ada data pemeriksaan yang bisa didownload!');" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm opacity-80 cursor-not-allowed">
                @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export PDF
                </a>
                
                @if($ibuHamils->count() > 0)
                <a href="{{ route('bidan.laporan-export', ['type' => 'bulanan', 'format' => 'excel', 'bulan' => request('bulan', date('m')), 'tahun' => request('tahun', date('Y'))]) }}" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm shadow-green-500/20">
                @else
                <a href="#" onclick="event.preventDefault(); alert('Tidak ada data pemeriksaan yang bisa didownload!');" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm shadow-green-500/20 opacity-80 cursor-not-allowed">
                @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </a>
                
                @if($ibuHamils->count() > 0)
                <form action="{{ route('bidan.laporan-kirim') }}" method="POST" class="m-0">
                    @csrf
                    <input type="hidden" name="periode" value="Bulan {{ $months[request('bulan', date('m'))] }} Tahun {{ request('tahun', date('Y')) }}">
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm shadow-blue-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Kirim ke Dinkes
                    </button>
                </form>
                @else
                <button type="button" onclick="alert('Tidak ada data pemeriksaan yang bisa dikirim!');" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2 shadow-sm shadow-blue-500/20 opacity-80 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Kirim ke Dinkes
                </button>
                @endif
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr>
                        <th class="pb-4 pt-2 px-4 font-bold text-slate-400 text-xs tracking-wider uppercase border-b border-slate-100">Tanggal</th>
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
                        @foreach($pasien->pemeriksaanAncs as $anc)
                        <tr class="hover:bg-slate-50 transition-colors border-b border-slate-50">
                            <td class="py-4 px-4 font-medium text-slate-700 whitespace-nowrap">{{ $anc->tanggal_pemeriksaan ? $anc->tanggal_pemeriksaan->format('d M y') : '-' }}</td>
                            <td class="py-4 px-4">
                                <p class="font-bold text-slate-800 whitespace-nowrap">{{ $pasien->nama_lengkap }}</p>
                                <p class="text-[10px] text-slate-500">Usia: {{ $pasien->umur }} thn</p>
                            </td>
                            <td class="py-4 px-4 text-center">
                                {!! ($pasien->usia_kehamilan <= 12) ? '<span class="text-teal-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                            </td>
                            <td class="py-4 px-4 text-center">
                                {!! ($anc->lab_hiv || $anc->lab_sifilis || $anc->lab_hepatitis_b) ? '<span class="text-indigo-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                            </td>
                            <td class="py-4 px-4 text-center">
                                {!! ($anc->lingkar_lengan_atas && $anc->lingkar_lengan_atas < 23.5) ? '<span class="text-orange-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                            </td>
                            <td class="py-4 px-4 text-center">
                                {!! ($anc->lab_hb && $anc->lab_hb < 11) ? '<span class="text-red-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                            </td>
                            <td class="py-4 px-4 text-center">
                                {!! ($pasien->umur < 20 || $pasien->umur > 35 || ($anc->tinggi_badan && $anc->tinggi_badan < 145)) ? '<span class="text-purple-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                            </td>
                            <td class="py-4 px-4 text-center">
                                {!! ($pasien->status_risiko_kehamilan == 'Sangat Tinggi') ? '<span class="text-pink-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                            </td>
                            <td class="py-4 px-4 text-center">
                                {!! ($pasien->status_risiko_kehamilan == 'Sangat Tinggi') ? '<span class="text-amber-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                            </td>
                            <td class="py-4 px-4 text-center">
                                {!! ($anc->jumlah_tablet_darah >= 90) ? '<span class="text-emerald-600 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                            </td>
                            <td class="py-4 px-4 text-center">
                                {!! ($pasien->status_ibu_meninggal == 'Meninggal') ? '<span class="text-slate-800 font-bold">&check;</span>' : '<span class="text-slate-300">-</span>' !!}
                            </td>
                        </tr>
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-slate-500">
                            Belum ada data laporan untuk periode tersebut.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

