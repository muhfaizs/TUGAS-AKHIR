@extends('layouts.dashboard')

@section('title', 'Dashboard Pasien KB - SatuKIA')
@section('page_title', 'Dashboard Pasien KB')
@section('page_subtitle', 'Pantau jadwal kontrol dan riwayat pelayanan KB Anda')

@section('content')
<div class="min-h-screen bg-transparent">
    <div class="bg-gradient-to-r from-[#105448] to-[#1c7c6b] rounded-2xl p-8 mb-8 shadow-lg text-white relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-teal-100 max-w-2xl text-sm leading-relaxed">
                Ini adalah dashboard pemantauan pelayanan Keluarga Berencana Anda.
            </p>
        </div>
    </div>

    @if($acceptor)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Riwayat Pelayanan Anda</h3>
            
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
                        @forelse($services as $service)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-4 font-medium text-teal-700">{{ $service->service_method }}</td>
                                <td class="px-6 py-4">{{ $service->created_at->format('d F Y') }}</td>
                                <td class="px-6 py-4">{{ $service->bidan->name ?? '-' }}</td>
                                <td class="px-6 py-4 font-bold text-red-600">{{ $service->follow_up_date ? \Carbon\Carbon::parse($service->follow_up_date)->format('d F Y') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada riwayat pelayanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Data Belum Terhubung</h3>
            <p class="text-slate-500">Anda telah terdaftar sebagai Pasien KB, namun data rekam medis Anda belum dihubungkan oleh bidan. Silakan hubungi bidan Anda di Puskesmas.</p>
        </div>
    @endif
</div>
@endsection
