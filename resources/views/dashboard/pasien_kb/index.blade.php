@extends('layouts.dashboard')

@section('title', 'Dashboard Pasien KB - SatuKIA')
@section('page_title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-transparent">
    <!-- Welcome Banner -->
    <div class="bg-teal-700 rounded-3xl p-8 mb-8 text-white relative overflow-hidden shadow-lg">
        <div class="relative z-10">
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-teal-100 max-w-2xl text-sm leading-relaxed">
                Ini adalah dashboard pemantauan pelayanan Keluarga Berencana Anda. Pastikan untuk selalu memeriksa jadwal kontrol berikutnya.
            </p>
        </div>
    </div>

    <!-- Data Diri Akseptor -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-teal-50 p-2 rounded-lg text-teal-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Data Diri Akseptor</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</div>
                <div class="text-slate-800 font-medium">{{ Auth::user()->name }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">NIK</div>
                <div class="text-slate-800 font-medium">{{ Auth::user()->nik ?? '-' }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Lahir</div>
                <div class="text-slate-800 font-medium">{{ optional($acceptor)->tanggal_lahir ? \Carbon\Carbon::parse($acceptor->tanggal_lahir)->format('d M Y') . ' (' . \Carbon\Carbon::parse($acceptor->tanggal_lahir)->age . ' thn)' : '- (- thn)' }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat</div>
                <div class="text-slate-800 font-medium">{{ Auth::user()->address ?? '-' }}</div>
            </div>
        </div>
    </div>

    @php
        $latestService = $services->first();
        $nextControl = $latestService ? $latestService->follow_up_date : null;
    @endphp

    <!-- Jadwal Kontrol Berikutnya -->
    <div class="rounded-2xl shadow-sm p-6 mb-6 text-white relative overflow-hidden" style="background-color: #2B6D5D;">
        <div class="relative z-10">
            <h3 class="text-base font-bold text-teal-100 mb-1">Jadwal Kontrol Berikutnya</h3>
            @if($nextControl)
                <div class="text-2xl font-bold text-white">{{ \Carbon\Carbon::parse($nextControl)->format('d F Y') }}</div>
            @else
                <div class="text-lg font-bold text-white">Tidak ada jadwal terdekat</div>
            @endif
        </div>
        <!-- Decorative icon -->
        <div class="absolute right-6 top-1/2 -translate-y-1/2 w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center">
            <!-- Decorative box -->
        </div>
    </div>

    <!-- Riwayat Pelayanan KB -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8">
        <h3 class="text-lg font-bold text-slate-800 mb-6">Riwayat Pelayanan KB</h3>
        
        @if($services->isEmpty())
            <div class="flex flex-col items-center justify-center py-10 text-center">
                <div class="bg-slate-50 p-4 rounded-full text-slate-400 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <h4 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Riwayat</h4>
                <p class="text-sm text-slate-500">Anda belum memiliki riwayat pelayanan KB yang tercatat.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="text-slate-800 font-bold border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4">Metode KB</th>
                            <th class="px-6 py-4">Tanggal Pelayanan</th>
                            <th class="px-6 py-4">Bidan / Petugas</th>
                            <th class="px-6 py-4">Jadwal Kontrol Berikutnya</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($services as $service)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-4 font-medium text-teal-700">{{ $service->service_method }}</td>
                                <td class="px-6 py-4">{{ $service->created_at->format('d F Y') }}</td>
                                <td class="px-6 py-4">{{ $service->bidan->name ?? '-' }}</td>
                                <td class="px-6 py-4 font-bold text-red-600">{{ $service->follow_up_date ? \Carbon\Carbon::parse($service->follow_up_date)->format('d F Y') : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
