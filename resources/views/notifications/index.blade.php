@extends('layouts.dashboard')

@section('title', 'Notifikasi & Pengingat KB')
@section('page_title', 'Reminder Kontrol')
@section('page_subtitle', 'Daftar akseptor dengan jadwal kunjungan ulang terdekat atau terlewat.')

@section('content')
<div class="min-h-screen bg-transparent">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-[#105448] to-[#1c7c6b] rounded-2xl p-8 mb-8 shadow-lg text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white opacity-5 rounded-full"></div>
        <div class="relative z-10 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Notifikasi Jadwal Kembali</h1>
                <p class="text-teal-100 text-sm">Daftar akseptor dengan jadwal kunjungan ulang terdekat atau terlewat.</p>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-8">
        @if($notifications->count() > 0)
            <div class="space-y-4">
                @foreach($notifications as $notif)
                    @php
                        $dueDate = \Carbon\Carbon::parse($notif->follow_up_date);
                        $isOverdue = $dueDate->isPast();
                    @endphp
                    <div class="p-4 rounded-lg border-l-4 {{ $isOverdue ? 'border-red-500 bg-red-50' : 'border-yellow-500 bg-yellow-50' }} flex justify-between items-center">
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 text-xs font-bold rounded-full {{ $isOverdue ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800' }}">
                                    {{ $isOverdue ? 'TERLEWAT' : 'AKAN DATANG' }}
                                </span>
                                <h3 class="font-bold text-gray-900">{{ $notif->acceptor->full_name ?? 'Akseptor Dihapus' }}</h3>
                            </div>
                            <p class="text-sm text-gray-700 mt-1">
                                Layanan Terakhir: {{ $notif->service_method }} <br>
                                Jadwal Kembali: <span class="font-semibold">{{ $dueDate->format('d M Y') }}</span> 
                                ({{ $dueDate->diffForHumans() }})
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('followups.show', $notif->id) }}" class="px-4 py-2 bg-[#117a65] text-white rounded text-sm font-medium hover:bg-[#0f6b58] transition-colors inline-block no-underline">
                                Tindak Lanjut
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10">
                <div class="inline-block p-4 rounded-full bg-green-100 text-green-600 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Semua Jadwal Aman</h3>
                <p class="text-gray-500 mt-1">Tidak ada akseptor yang mendekati atau melewati batas jadwal kunjungan ulang.</p>
            </div>
        @endif
</div>
@endsection

