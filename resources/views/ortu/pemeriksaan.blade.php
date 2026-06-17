@extends('layouts.dashboard')

@section('title', 'Data Pemeriksaan - SatuKIA')
@section('page_title', 'Data Pemeriksaan')
@section('page_subtitle', 'Riwayat lengkap pemeriksaan kehamilan Anda')

@section('content')
<div class="max-w-[85rem] mx-auto">
    <!-- Tombol Kembali -->
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-teal-600 transition-colors mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Dashboard
    </a>

    <!-- Riwayat Pemeriksaan ANC -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Daftar Riwayat Pemeriksaan
            </h3>
            @if(isset($ibuHamil) && $ibuHamil && $ibuHamil->pemeriksaanAncs && $ibuHamil->pemeriksaanAncs->count() > 0)
            <a href="{{ route('ortu.download-rekap') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-sm shadow-teal-600/30 transition-all active:scale-95 group text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download Rekap PDF
            </a>
            @else
            <a href="#" onclick="event.preventDefault(); alert('Tidak ada data pemeriksaan yang bisa didownload!');" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-sm shadow-teal-600/30 transition-all active:scale-95 group text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download Rekap PDF
            </a>
            @endif
        </div>
        <div class="p-0 overflow-x-auto">
            @if(isset($ibuHamil) && $ibuHamil && $ibuHamil->pemeriksaanAncs && $ibuHamil->pemeriksaanAncs->count() > 0)
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="py-3 px-6 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Tanggal</th>
                            <th class="py-3 px-6 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Trimester</th>
                            <th class="py-3 px-6 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Keluhan Utama</th>
                            <th class="py-3 px-6 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">BB/Tensi</th>
                            <th class="py-3 px-6 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Nasihat/Tindakan</th>
                            <th class="py-3 px-6 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ibuHamil->pemeriksaanAncs as $anc)
                        <tr class="hover:bg-slate-50 transition-colors border-b border-slate-50">
                            <td class="py-4 px-6 font-bold text-slate-800">
                                {{ $anc->tanggal_pemeriksaan->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 text-slate-600">{{ $anc->trimester ?: '-' }}</td>
                            <td class="py-4 px-6 text-slate-600"><span class="block max-w-[200px] truncate" title="{{ $anc->keluhan_utama }}">{{ $anc->keluhan_utama ?: '-' }}</span></td>
                            <td class="py-4 px-6 text-slate-600">{{ $anc->berat_badan ?: '-' }}kg / {{ $anc->tekanan_darah ?: '-' }}</td>
                            <td class="py-4 px-6 text-slate-600"><span class="block max-w-[250px] truncate" title="{{ $anc->nasihat }}">{{ $anc->nasihat ?: '-' }}</span></td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('ortu.pemeriksaan.show', $anc->id) }}" class="inline-flex items-center gap-1 text-teal-600 hover:text-teal-700 font-bold text-xs bg-teal-50 px-3 py-1.5 rounded-lg transition-colors border border-teal-100">
                                    Detail Lengkap
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12 px-6">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium">Belum ada riwayat pemeriksaan ANC.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

