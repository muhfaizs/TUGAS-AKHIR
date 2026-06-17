@extends('layouts.app')

@section('title', 'Pemantauan & Follow-Up KB')
@section('header_title', 'Jadwal Kontrol')
@section('header_subtitle', 'Daftar semua jadwal kembali akseptor KB dan status pantauannya.')

@section('content')
<div class="min-h-screen bg-transparent">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-[#105448] to-[#1c7c6b] rounded-2xl p-8 mb-8 shadow-lg text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white opacity-5 rounded-full"></div>
        <div class="relative z-10 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Pemantauan & Follow-Up</h1>
                <p class="text-teal-100 text-sm">Daftar semua jadwal kembali akseptor KB dan status pantauannya.</p>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 font-semibold text-sm border-b">
                        <th class="px-6 py-4">Akseptor</th>
                        <th class="px-6 py-4">Metode KB Terakhir</th>
                        <th class="px-6 py-4">Tgl Pelayanan</th>
                        <th class="px-6 py-4">Jadwal Kembali</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t border-gray-100 divide-gray-100">
                    @forelse($services as $service)
                        @php
                            $dueDate = \Carbon\Carbon::parse($service->follow_up_date);
                            $isOverdue = $dueDate->isPast();
                            $daysDiff = $dueDate->diffInDays(now(), false);
                            
                            $statusClass = '';
                            $statusText = '';
                            
                            if ($service->is_verified) {
                                $statusClass = 'bg-green-100 text-green-800';
                                $statusText = 'Selesai';
                            } elseif ($isOverdue) {
                                $statusClass = 'bg-red-100 text-red-800';
                                $statusText = 'Terlewat ' . abs(round($daysDiff)) . ' hari';
                            } elseif ($daysDiff >= -7) {
                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                $statusText = 'Kurang ' . abs(round($daysDiff)) . ' hari';
                            } else {
                                $statusClass = 'bg-blue-100 text-blue-800';
                                $statusText = 'Aman';
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $service->acceptor->full_name ?? '-' }}
                                <div class="text-xs text-gray-500 font-normal mt-0.5">{{ $service->acceptor->nik ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4">{{ $service->service_method }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $service->service_date ? $service->service_date->format('d M Y') : $service->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dueDate->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('followups.show', $service->id) }}" class="px-3 py-1.5 bg-[#117a65] text-white rounded text-sm font-medium hover:bg-[#0f6b58] transition-colors inline-block no-underline">Tindak Lanjut</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada data jadwal kembali.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection
