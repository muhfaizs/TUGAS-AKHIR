@extends('layouts.dashboard')

@section('title', 'Jadwal Kontrol KB')
@section('page_title', 'Jadwal Kontrol')
@section('page_subtitle', 'Daftar semua jadwal kembali akseptor KB dan status pantauannya.')

@section('content')
<div class="min-h-screen bg-transparent">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-[#105448] to-[#1c7c6b] rounded-2xl p-8 mb-8 shadow-lg text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white opacity-5 rounded-full"></div>
        <div class="absolute bottom-0 right-32 -mb-12 w-32 h-32 bg-black opacity-10 rounded-full"></div>
        
        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2">Pemantauan & Follow-Up</h1>
            <p class="text-teal-100 text-sm">Daftar semua jadwal kembali akseptor KB dan status pantauannya.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow border border-gray-100 overflow-hidden">
        @if(session('error'))
            <div class="m-6 bg-red-50 text-red-600 p-4 rounded-lg flex items-start gap-3">
                <svg viewBox="0 0 24 24" class="w-5 h-5 fill-current mt-0.5"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                <div>
                    <p class="text-sm font-semibold">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="overflow-x-auto p-2">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="text-slate-800 font-bold border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4">Akseptor</th>
                        <th scope="col" class="px-6 py-4">Metode KB Terakhir</th>
                        <th scope="col" class="px-6 py-4">Tgl Pelayanan</th>
                        <th scope="col" class="px-6 py-4">Jadwal Kembali</th>
                        <th scope="col" class="px-6 py-4">Status</th>
                        <th scope="col" class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($jadwalKontrols as $jadwal)
                        @php
                            $jadwalDate = \Carbon\Carbon::parse($jadwal->follow_up_date);
                            $isOverdue = $jadwalDate->isPast() && !$jadwalDate->isToday();
                            $isToday = $jadwalDate->isToday();
                            $daysOverdue = $jadwalDate->diffInDays(now());
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $jadwal->acceptor->full_name }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $jadwal->acceptor->nik }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-700">
                                {{ $jadwal->service_method }}
                            </td>
                            <td class="px-6 py-4 text-slate-700">
                                {{ \Carbon\Carbon::parse($jadwal->service_date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-slate-700">
                                {{ $jadwalDate->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($isOverdue)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-red-100 text-red-700">
                                        Terlewat {{ $daysOverdue }} hari
                                    </span>
                                @elseif($isToday)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-amber-100 text-amber-700">
                                        Hari ini
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-green-100 text-green-700">
                                        Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('followups.show', $jadwal->id) }}" class="px-4 py-2 bg-[#117a65] hover:bg-[#0f6b58] text-white text-sm font-medium rounded-lg transition-colors shadow-sm inline-block text-center no-underline">
                                    Tindak Lanjut
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                Tidak ada jadwal kontrol KB.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jadwalKontrols->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $jadwalKontrols->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
