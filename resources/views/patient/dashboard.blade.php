@extends('layouts.dashboard')

@section('title', 'Dasbor Pasien')

@section('content')
<div class="min-h-screen bg-transparent space-y-6">

    <!-- Header Card -->
    <div class="bg-gradient-to-r from-[#105448] to-[#1c7c6b] rounded-2xl p-8 mb-8 shadow-lg text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white opacity-5 rounded-full"></div>
        <div class="relative z-10 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Portal Pasien</h1>
                <p class="text-teal-100 text-sm">Kelola data diri dan pantau jadwal kontrol KB Anda dengan mudah.</p>
            </div>
        </div>
    </div>

    @if(!$acceptor)
    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-5 py-4 rounded-xl flex items-center gap-3">
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        <div>
            <p class="font-bold">Data Profil Belum Tersedia</p>
            <p class="text-sm">Silakan hubungi Bidan/Petugas untuk mendaftarkan data akseptor Anda agar terhubung dengan akun ini.</p>
        </div>
    </div>
    @else

    @php
        $isFollowUpNear = false;
        $followUpDays = 0;
        if ($nextFollowUp) {
            $followUpDays = \Carbon\Carbon::parse($nextFollowUp->follow_up_date)->startOfDay()->diffInDays(now()->startOfDay(), false);
            if ($followUpDays >= -1) {
                $isFollowUpNear = true;
            }
        }
    @endphp

    @if($isFollowUpNear)
        <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl flex items-center gap-4 shadow-sm mb-6 relative overflow-hidden">
            <div class="absolute inset-0 bg-red-100 opacity-20 animate-pulse"></div>
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 relative z-10">
                <svg class="w-6 h-6 text-red-600 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div class="relative z-10">
                <p class="font-bold text-red-900 text-base mb-0.5">Peringatan Jadwal Kontrol!</p>
                <p class="text-sm text-red-700">
                    @if($followUpDays == -1)
                        Jadwal kontrol Anda adalah <strong>BESOK (H-1)</strong>. Jangan lupa untuk kembali ke klinik/petugas.
                    @elseif($followUpDays == 0)
                        Jadwal kontrol Anda adalah <strong>HARI INI</strong>. Segera kunjungi klinik/petugas Anda.
                    @else
                        Jadwal kontrol Anda telah <strong>TERLEWAT {{ $followUpDays }} hari</strong>. Segera hubungi petugas medis.
                    @endif
                </p>
            </div>
        </div>
    @endif

    <div class="space-y-6">
        
        <!-- Data Diri Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h2 class="text-lg font-bold text-gray-800">Data Diri Akseptor</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</p>
                    <p class="font-medium text-gray-900">{{ $acceptor->full_name }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">NIK</p>
                    <p class="font-medium text-gray-900">{{ $acceptor->nik }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal Lahir</p>
                    <p class="font-medium text-gray-900">
                        {{ $acceptor->date_of_birth ? (is_string($acceptor->date_of_birth) ? \Carbon\Carbon::parse($acceptor->date_of_birth)->format('d M Y') : $acceptor->date_of_birth->format('d M Y')) : '-' }} 
                        ({{ $acceptor->age ?? '-' }} thn)
                    </p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Alamat</p>
                    <p class="font-medium text-gray-900">{{ $acceptor->address ?? '-' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Jadwal Kontrol Card -->
        <div class="bg-gradient-to-br from-[#117a65] to-[#0e6150] rounded-2xl shadow-xl p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-teal-50 mb-2 relative z-10">Jadwal Kontrol Berikutnya</h3>
            @if($nextFollowUp)
                <div class="text-3xl font-black mb-1 relative z-10">{{ $nextFollowUp->follow_up_date->format('d M Y') }}</div>
                <p class="text-sm text-teal-100 relative z-10">Metode: <strong>{{ $nextFollowUp->service_method }}</strong></p>
                <div class="mt-4 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-white/20 backdrop-blur-sm text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Segera kembali ke Petugas
                </div>
            @else
                <div class="text-xl font-bold mt-2 relative z-10 text-teal-100">Tidak ada jadwal terdekat</div>
            @endif
        </div>

        <!-- Riwayat Pelayanan Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800">Riwayat Pelayanan KB</h2>
                </div>
                
                @if($services->isEmpty())
                    <div class="p-10 text-center">
                        <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <h3 class="text-gray-900 font-bold mb-1">Belum Ada Riwayat</h3>
                        <p class="text-sm text-gray-500">Anda belum memiliki riwayat pelayanan KB yang tercatat.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100">
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal & Lokasi</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Metode KB</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Bidan Bertugas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($services as $service)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($service->service_date ?? $service->created_at)->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $service->puskesmasData->name ?? $service->location ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $service->service_method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $service->creator->name ?? '-' }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
        </div>
    </div>
    @endif
</div>
@endsection

