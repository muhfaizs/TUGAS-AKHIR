@extends('layouts.dashboard')

@section('title', 'Detail Pemeriksaan ANC')
@section('page_title', 'Detail Rekam Medis ANC')
@section('page_subtitle', 'Data detail pemeriksaan terpadu Anda')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Tanggal Pemeriksaan: {{ \Carbon\Carbon::parse($anc->tanggal_pemeriksaan)->translatedFormat('d F Y') }}</h2>
    </div>
    <a href="{{ route('ortu.pemeriksaan') }}" class="text-teal-600 hover:text-teal-700 font-medium text-sm flex items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Daftar Pemeriksaan
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Kolom 1 -->
    <div class="space-y-6">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">Informasi Dasar</h3>
            <table class="w-full text-sm">
                <tr><td class="py-2 text-slate-500 w-1/3">Trimester</td><td class="py-2 font-bold">{{ $anc->trimester ?: '-' }}</td></tr>
                <tr><td class="py-2 text-slate-500">Keluhan Utama</td><td class="py-2 font-bold">{{ $anc->keluhan_utama ?: 'Tidak ada keluhan' }}</td></tr>
            </table>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-teal-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">Pemeriksaan Fisik & Kebidanan</h3>
            <table class="w-full text-sm">
                <tr><td class="py-2 text-slate-500 w-1/3">Berat Badan</td><td class="py-2 font-bold">{{ $anc->berat_badan ?: '-' }} kg</td></tr>
                <tr><td class="py-2 text-slate-500">Tinggi Badan</td><td class="py-2 font-bold">{{ $anc->tinggi_badan ?: '-' }} cm</td></tr>
                <tr><td class="py-2 text-slate-500">Tekanan Darah</td><td class="py-2 font-bold">{{ $anc->tekanan_darah ?: '-' }}</td></tr>
                <tr><td class="py-2 text-slate-500">LiLA</td><td class="py-2 font-bold">{{ $anc->lingkar_lengan_atas ?: '-' }} cm</td></tr>
                <tr><td class="py-2 text-slate-500">Tinggi Fundus</td><td class="py-2 font-bold">{{ $anc->tinggi_fundus_uteri ?: '-' }} cm</td></tr>
                <tr><td class="py-2 text-slate-500">Letak Janin</td><td class="py-2 font-bold">{{ $anc->letak_janin ?: '-' }}</td></tr>
                <tr><td class="py-2 text-slate-500">DJJ</td><td class="py-2 font-bold">{{ $anc->denyut_jantung_janin ?: '-' }} bpm</td></tr>
            </table>
        </div>
        
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-indigo-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">Imunisasi & Suplemen</h3>
            <table class="w-full text-sm">
                <tr><td class="py-2 text-slate-500 w-1/3">Diberikan TT</td><td class="py-2 font-bold">{{ $anc->diberikan_imunisasi_tt ? 'Ya' : 'Tidak' }}</td></tr>
                <tr><td class="py-2 text-slate-500">Status TT</td><td class="py-2 font-bold">{{ $anc->status_imunisasi_tt ?: '-' }}</td></tr>
                <tr><td class="py-2 text-slate-500">Diberikan TTD</td><td class="py-2 font-bold">{{ $anc->diberikan_tablet_tambah_darah ? 'Ya' : 'Tidak' }}</td></tr>
                <tr><td class="py-2 text-slate-500">Jumlah TTD</td><td class="py-2 font-bold">{{ $anc->jumlah_tablet_darah ?: '-' }} tablet</td></tr>
                <tr><td class="py-2 text-slate-500">Risiko Anemia</td><td class="py-2 font-bold">
                    @if($anc->risiko_anemia === 'Ringan')
                        <span class="text-amber-600">Ringan</span>
                    @elseif($anc->risiko_anemia === 'Sedang')
                        <span class="text-orange-600">Sedang</span>
                    @elseif($anc->risiko_anemia === 'Tinggi')
                        <span class="text-red-600">Tinggi</span>
                    @else
                        -
                    @endif
                </td></tr>
            </table>
        </div>
    </div>

    <!-- Kolom 2 -->
    <div class="space-y-6">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-rose-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">Laboratorium & USG</h3>
            <div class="mb-4">
                <span class="px-3 py-1 {{ $anc->rujuk_laboratorium ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-600' }} rounded-full text-xs font-bold">
                    {{ $anc->rujuk_laboratorium ? 'Dirujuk ke Laboratorium' : 'Tidak Dirujuk ke Laboratorium' }}
                </span>
            </div>
            
            <table class="w-full text-sm mb-4">
                <tr><td class="py-2 text-slate-500 w-1/3">Hemoglobin</td><td class="py-2 font-bold">{{ $anc->lab_hb ?: '-' }} g/dl</td></tr>
                <tr><td class="py-2 text-slate-500">Protein Urine</td><td class="py-2 font-bold">{{ $anc->lab_protein_urine ?: '-' }}</td></tr>
                <tr><td class="py-2 text-slate-500">Golongan Darah</td><td class="py-2 font-bold">{{ $anc->lab_golongan_darah ?: '-' }}</td></tr>
                <tr><td class="py-2 text-slate-500">Sifilis</td><td class="py-2 font-bold">{{ $anc->lab_sifilis ?: '-' }}</td></tr>
                <tr><td class="py-2 text-slate-500">HIV</td><td class="py-2 font-bold">{{ $anc->lab_hiv ?: '-' }}</td></tr>
                <tr><td class="py-2 text-slate-500">Hepatitis B</td><td class="py-2 font-bold">{{ $anc->lab_hepatitis_b ?: '-' }}</td></tr>
            </table>
            
            <div>
                <p class="text-slate-500 text-sm mb-1">Hasil USG Bidan:</p>
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 text-sm font-medium">
                    {{ $anc->hasil_usg ?: 'Tidak ada catatan USG.' }}
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-amber-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">Tatalaksana & Konseling</h3>
            <div class="mb-4">
                <span class="px-3 py-1 {{ $anc->ditemukan_risiko ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }} rounded-full text-xs font-bold">
                    {{ $anc->ditemukan_risiko ? 'âš  Ditemukan Risiko Kehamilan' : 'âœ“ Tidak Ditemukan Risiko Kehamilan' }}
                </span>
            </div>
            
            <div class="space-y-4">
                <div>
                    <p class="text-slate-500 text-sm mb-1">Tatalaksana Kasus:</p>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 text-sm font-medium">
                        {{ $anc->tatalaksana_kasus ?: '-' }}
                    </div>
                </div>
                <div>
                    <p class="text-slate-500 text-sm mb-1">Temu Wicara / Konseling (Nasihat):</p>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 text-sm font-medium">
                        {{ $anc->nasihat ?: '-' }}
                    </div>
                </div>
                <div>
                    <p class="text-slate-500 text-sm mb-1">Skrining Jiwa:</p>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 text-sm font-medium">
                        {{ $anc->skrining_jiwa ?: '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

