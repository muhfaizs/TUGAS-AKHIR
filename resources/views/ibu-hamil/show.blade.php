@extends('layouts.app')

@section('title', 'Profil Ibu Hamil - SatuKIA')
@section('header_title', 'Profil Pasien Ibu Hamil')
@section('header_subtitle', 'Detail rekam medis dan informasi kehamilan')

@section('content')
<div class="max-w-5xl">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('ibu-hamil.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-teal-600 transition-colors font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Daftar
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('ibu-hamil.cetak-rekap', $ibuHamil->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-600 hover:bg-amber-100 font-semibold rounded-lg transition-colors border border-amber-200 shadow-sm text-sm" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                </svg>
                Cetak Rekap PDF
            </a>
            <form action="{{ route('ibu-hamil.send-rekap', $ibuHamil->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 font-semibold rounded-lg transition-colors border border-blue-200 shadow-sm text-sm" onclick="return confirm('Kirim berkas PDF Rekap Medis dan Pengingat Jadwal Pemeriksaan Selanjutnya ke email pasien?')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Kirim ke Email
                </button>
            </form>
            <a href="{{ route('ibu-hamil.edit', $ibuHamil->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 text-slate-600 hover:bg-slate-100 font-semibold rounded-lg transition-colors border border-slate-200 shadow-sm text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Edit Data
            </a>
        </div>
    </div>

    <!-- Header Profil -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden mb-6 relative">
        <div class="h-32 bg-teal-600 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="absolute right-0 top-0 w-64 h-64 bg-teal-500 rounded-full blur-3xl -mr-20 -mt-20"></div>
        </div>
        
        <div class="px-8 pb-8 flex flex-col md:flex-row gap-6 items-start relative">
            <div class="w-24 h-24 rounded-2xl bg-white p-2 shadow-lg -mt-12 relative z-10 border border-slate-100">
                <div class="w-full h-full bg-pink-100 rounded-xl flex items-center justify-center text-pink-600 text-3xl font-extrabold">
                    {{ substr($ibuHamil->nama_lengkap, 0, 2) }}
                </div>
            </div>
            
            <div class="pt-3 md:pt-4 flex-1">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                            {{ $ibuHamil->nama_lengkap }}
                            @if($ibuHamil->status_pasien == 'Aktif')
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold uppercase tracking-wider">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[10px] font-bold uppercase tracking-wider">Nonaktif</span>
                            @endif
                        </h2>
                        <p class="text-slate-500 font-medium">NIK: {{ $ibuHamil->nik }} &bull; BPJS: {{ $ibuHamil->nomor_bpjs ?? '-' }} &bull; Rekam Medis: <span class="text-teal-600 font-bold">{{ $ibuHamil->nomor_rekam_medis }}</span></p>
                    </div>
                    
                    <div class="flex items-center gap-4 text-sm bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                        <div>
                            <p class="text-slate-400 text-xs font-semibold uppercase">Usia Kandungan</p>
                            <p class="font-bold text-slate-800">{{ $ibuHamil->usia_kehamilan }} Minggu</p>
                        </div>
                        <div class="w-px h-8 bg-slate-200"></div>
                        <div>
                            <p class="text-slate-400 text-xs font-semibold uppercase">HPL</p>
                            <p class="font-bold text-slate-800">{{ $ibuHamil->hpl->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten Profil 3 Kolom -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Identitas & Kontak -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Identitas Pasien
                    </h3>
                </div>
                <div class="p-6 space-y-4 text-sm">
                    <div>
                        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Nomor BPJS</p>
                        <p class="font-bold text-slate-800">{{ $ibuHamil->nomor_bpjs ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</p>
                        <p class="font-bold text-slate-800">{{ $ibuHamil->tempat_lahir }}, {{ $ibuHamil->tanggal_lahir->format('d F Y') }} <span class="text-slate-500 font-medium">({{ $ibuHamil->umur }} Thn)</span></p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Golongan Darah</p>
                        <p class="font-bold text-slate-800">{{ $ibuHamil->golongan_darah }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Nama Suami</p>
                        <p class="font-bold text-slate-800">{{ $ibuHamil->nama_suami }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Pekerjaan</p>
                        <p class="font-bold text-slate-800">{{ $ibuHamil->pekerjaan ?? '-' }}</p>
                    </div>
                    <hr class="border-slate-100">
                    <div>
                        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Nomor Telepon</p>
                        <p class="font-bold text-slate-800">{{ $ibuHamil->nomor_telepon }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Email</p>
                        <p class="font-bold text-slate-800">{{ $ibuHamil->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Alamat Domisili</p>
                        <p class="font-medium text-slate-700 leading-relaxed">{{ $ibuHamil->alamat }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Tengah & Kanan: Kehamilan & Riwayat -->
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Data Kehamilan Dasar
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
                        <div class="bg-pink-50 rounded-xl p-4 text-center">
                            <p class="text-pink-600 text-[10px] font-bold uppercase tracking-wider mb-1">Gravida</p>
                            <p class="text-2xl font-black text-pink-700">{{ $ibuHamil->gravida }}</p>
                        </div>
                        <div class="bg-pink-50 rounded-xl p-4 text-center">
                            <p class="text-pink-600 text-[10px] font-bold uppercase tracking-wider mb-1">Paritas</p>
                            <p class="text-2xl font-black text-pink-700">{{ $ibuHamil->paritas }}</p>
                        </div>
                        <div class="bg-pink-50 rounded-xl p-4 text-center">
                            <p class="text-pink-600 text-[10px] font-bold uppercase tracking-wider mb-1">Abortus</p>
                            <p class="text-2xl font-black text-pink-700">{{ $ibuHamil->abortus }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-wider mb-1">Kehamilan Ke</p>
                            <p class="text-2xl font-black text-slate-800">{{ $ibuHamil->kehamilan_ke }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                        <div>
                            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">HPHT</p>
                            <p class="font-bold text-slate-800">{{ $ibuHamil->hpht->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Risiko Kehamilan</p>
                            @if($ibuHamil->status_risiko_kehamilan == 'Rendah')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Rendah</span>
                            @elseif($ibuHamil->status_risiko_kehamilan == 'Tinggi')
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">Tinggi</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Sangat Tinggi</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Riwayat & Administratif
                    </h3>
                    <a href="{{ route('ibu-hamil.edit', ['ibu_hamil' => $ibuHamil->id, 'section' => 'riwayat']) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 bg-indigo-50 px-3 py-1.5 rounded-lg transition-colors border border-indigo-100 hover:bg-indigo-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit
                    </a>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                            <p class="text-indigo-400 text-xs font-bold uppercase tracking-wider mb-1">Total Kunjungan ANC</p>
                            <p class="text-2xl font-black text-indigo-700">{{ $ibuHamil->jumlah_pemeriksaan_anc }} Kali</p>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Pemeriksaan Terakhir</p>
                                <p class="font-bold text-slate-800">{{ $ibuHamil->pemeriksaan_terakhir ? $ibuHamil->pemeriksaan_terakhir->format('d M Y') : 'Belum pernah' }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Status Kehamilan Terakhir</p>
                                <p class="font-bold text-slate-800">{{ $ibuHamil->status_kehamilan_terakhir ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="border-slate-100 my-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Bidan Penanggung Jawab</p>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="w-6 h-6 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-[10px]">
                                    {{ substr($ibuHamil->bidan->name ?? 'B', 0, 1) }}
                                </div>
                                <p class="font-bold text-slate-800">{{ $ibuHamil->bidan->name ?? 'Tidak diketahui' }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Tanggal Registrasi</p>
                            <p class="font-bold text-slate-800">{{ $ibuHamil->tanggal_registrasi_pasien->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Grafik Perkembangan Janin -->
    <div class="mt-6 bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                </svg>
                Grafik Perkembangan Kehamilan
            </h3>
        </div>
        <div class="p-6">
            @if($ibuHamil->pemeriksaanAncs && $ibuHamil->pemeriksaanAncs->count() > 0)
                <div class="h-80 w-full relative">
                    <canvas id="perkembanganChart"></canvas>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-slate-500 text-sm">Grafik akan muncul setelah riwayat ANC ditambahkan.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Riwayat Pemeriksaan ANC -->
    <div class="mt-6 bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Riwayat Pemeriksaan ANC
            </h3>
            <a href="{{ route('pemeriksaan-anc.create', ['ibu_hamil_id' => $ibuHamil->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 text-white hover:bg-teal-700 font-bold rounded-xl transition-colors shadow-sm shadow-teal-200 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Input Pemeriksaan ANC Baru
            </a>
        </div>
        <div class="p-0 overflow-x-auto">
            @if($ibuHamil->pemeriksaanAncs && $ibuHamil->pemeriksaanAncs->count() > 0)
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="py-3 px-6 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Tanggal</th>
                            <th class="py-3 px-6 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Trimester</th>
                            <th class="py-3 px-6 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Keluhan</th>
                            <th class="py-3 px-6 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">BB/Tensi</th>
                            <th class="py-3 px-6 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Risiko</th>
                            <th class="py-3 px-6 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ibuHamil->pemeriksaanAncs as $anc)
                        <tr class="hover:bg-slate-50 transition-colors border-b border-slate-50">
                            <td class="py-4 px-6 font-bold text-slate-800">
                                {{ $anc->tanggal_pemeriksaan->format('d M Y') }}
                                @if($anc->status === 'draft')
                                    <span class="ml-2 px-2 py-0.5 bg-amber-100 text-amber-700 rounded text-[10px] font-bold uppercase tracking-wider">Draft</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-600">{{ $anc->trimester ?: '-' }}</td>
                            <td class="py-4 px-6 text-slate-600"><span class="block max-w-[150px] truncate" title="{{ $anc->keluhan_utama }}">{{ $anc->keluhan_utama ?: '-' }}</span></td>
                            <td class="py-4 px-6 text-slate-600">{{ $anc->berat_badan ?: '-' }}kg / {{ $anc->tekanan_darah ?: '-' }}</td>
                            <td class="py-4 px-6">
                                @if($anc->ditemukan_risiko)
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold">Ya</span>
                                @else
                                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded text-xs font-bold">Tidak</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right flex items-center justify-end gap-2">
                                @php
                                    $noHp = preg_replace('/[^0-9]/', '', $ibuHamil->nomor_telepon);
                                    if(strpos($noHp, '0') === 0) {
                                        $noHp = '62' . substr($noHp, 1);
                                    }
                                    
                                    $usiaMinggu = $ibuHamil->usia_kehamilan;
                                    $hariTambahan = 28; // Default 4 minggu
                                    if ($usiaMinggu >= 36) {
                                        $hariTambahan = 7; // 1 minggu
                                    } elseif ($usiaMinggu >= 28) {
                                        $hariTambahan = 14; // 2 minggu
                                    }
                                    
                                    $tanggalBerikutnya = $anc->tanggal_pemeriksaan->copy()->addDays($hariTambahan)->isoFormat('D MMMM Y');
                                    
                                    $waText = "Halo Ibu " . $ibuHamil->nama_lengkap . ",\n\nJadwal pemeriksaan ANC berikutnya adalah pada tanggal *" . $tanggalBerikutnya . "*. \n\nSilakan login ke aplikasi SatuKIA untuk mengunduh hasil rekap pemeriksaan ANC Anda melalui tautan berikut:\n" . route('login') . "\n\nTerima kasih.";
                                @endphp
                                <a href="https://wa.me/{{ $noHp }}?text={{ urlencode($waText) }}" target="_blank" class="inline-flex items-center gap-1 text-green-600 hover:text-green-700 font-bold text-xs bg-green-50 px-3 py-1.5 rounded-lg transition-colors border border-green-100" title="Kirim Pengingat WA">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.128.552 4.195 1.6 6.02L.098 24l6.103-1.597A11.956 11.956 0 0012.031 24c6.645 0 12.031-5.384 12.031-12.031S18.677 0 12.031 0zm0 22.015c-1.802 0-3.565-.484-5.11-1.401l-.367-.217-3.805.996.996-3.805-.218-.367A9.972 9.972 0 011.984 12.03c0-5.545 4.516-10.06 10.047-10.06 5.545 0 10.047 4.515 10.047 10.06 0 5.545-4.516 10.06-10.047 10.06zm5.518-7.535c-.302-.152-1.785-.882-2.062-.983-.278-.101-.482-.152-.685.152-.203.303-.783.983-.96 1.185-.178.203-.355.228-.658.076-2.123-1.063-3.664-2.28-4.326-4.558-.061-.208.202-.191.498-.787.102-.202.051-.379-.025-.531-.076-.152-.685-1.644-.937-2.253-.245-.591-.493-.51-.685-.52-.178-.008-.381-.008-.584-.008-.203 0-.533.076-.812.379-.278.304-1.064 1.037-1.064 2.528 0 1.491 1.09 2.934 1.242 3.136.152.203 2.138 3.264 5.177 4.575 2.053.886 2.802.759 3.336.632.709-.168 1.785-.733 2.038-1.442.253-.709.253-1.316.177-1.442-.075-.126-.278-.202-.581-.354z"/>
                                    </svg>
                                    WA
                                </a>
                                @php
                                    $isoDate = $anc->tanggal_pemeriksaan->copy()->addDays($hariTambahan)->format('Y-m-d');
                                    // Remove markdown bold asterisks for plain text email notes
                                    $emailText = str_replace('*', '', $waText);
                                    $emailTextJs = str_replace("\n", "\\n", addslashes($emailText));
                                @endphp
                                <form action="{{ route('ibu-hamil.send-rekap', $ibuHamil->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Kirim berkas PDF Rekap Medis dan Pengingat Jadwal Pemeriksaan Selanjutnya ke email pasien?')" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 font-bold text-xs bg-blue-50 px-3 py-1.5 rounded-lg transition-colors border border-blue-100" title="Kirim Pengingat Email">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Email
                                    </button>
                                </form>

                                @if($anc->status === 'draft')
                                    <a href="{{ route('pemeriksaan-anc.edit', $anc->id) }}" class="inline-flex items-center gap-1 text-amber-600 hover:text-amber-700 font-bold text-xs bg-amber-50 px-3 py-1.5 rounded-lg transition-colors border border-amber-100">
                                        Lanjutkan
                                    </a>
                                @else
                                    <a href="{{ route('pemeriksaan-anc.show', $anc->id) }}" class="inline-flex items-center gap-1 text-teal-600 hover:text-teal-700 font-bold text-xs bg-teal-50 px-3 py-1.5 rounded-lg transition-colors border border-teal-100">
                                        Detail
                                    </a>
                                @endif
                                <form action="{{ route('pemeriksaan-anc.destroy', $anc->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ANC ini? Data tidak dapat dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 text-red-600 hover:text-red-700 font-bold text-xs bg-red-50 px-3 py-1.5 rounded-lg transition-colors border border-red-100" title="Hapus Data">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
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

@push('scripts')
@if($ibuHamil->pemeriksaanAncs && $ibuHamil->pemeriksaanAncs->count() > 0)
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
    function confirmSelesai(url) {
        document.getElementById('form-selesai').action = url;
        document.getElementById('selesai-modal').classList.remove('hidden');
    }

    function closeSelesaiModal() {
        document.getElementById('selesai-modal').classList.add('hidden');
    }
</script>

@if(session('print_lab_id'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const printUrl = "{{ route('pemeriksaan-anc.cetak-rujukan-lab', session('print_lab_id')) }}";
        // Bypassing popup blockers by setting location.href directly, since the PDF is a download attachment.
        window.location.href = printUrl;
    });
</script>
@endif

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
                            tension: 0.3,
                            yAxisID: 'y'
                        },
                        {
                            label: 'DJJ (bpm)',
                            data: {!! $dataDjj !!},
                            borderColor: '#0d9488', // teal-600
                            backgroundColor: '#99f6e4', // teal-200
                            borderWidth: 2,
                            tension: 0.3,
                            yAxisID: 'y1'
                        },
                        {
                            label: 'Berat Badan Ibu (kg)',
                            data: {!! $dataBb !!},
                            borderColor: '#f59e0b', // amber-500
                            backgroundColor: '#fde68a', // amber-200
                            borderWidth: 2,
                            tension: 0.3,
                            borderDash: [5, 5],
                            yAxisID: 'y'
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
                                boxWidth: 8
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 12,
                            titleFont: { size: 13 },
                            bodyFont: { size: 13 },
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'TFU (cm) / BB (kg)',
                                font: { size: 10 }
                            },
                            suggestedMin: 0
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'DJJ (bpm)',
                                font: { size: 10 }
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
