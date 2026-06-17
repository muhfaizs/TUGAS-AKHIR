@extends('layouts.dashboard')

@section('title', 'Riwayat Pelayanan KB')
@section('page_title', 'Riwayat Pelayanan KB')
@section('page_subtitle', 'Kelola semua pelayanan KB yang telah diberikan')

@section('content')
<div class="min-h-screen bg-transparent">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-[#105448] to-[#1c7c6b] rounded-2xl p-8 mb-8 shadow-lg text-white flex flex-wrap gap-4 justify-between items-center relative overflow-hidden">
        <!-- Decorative shapes -->
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white opacity-5 rounded-full"></div>
        <div class="absolute bottom-0 right-32 -mb-12 w-32 h-32 bg-black opacity-10 rounded-full"></div>
        
        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2">Riwayat Pelayanan KB</h1>
            <p class="text-teal-100 text-sm">Kelola dan pantau semua rekam medis pelayanan kontrasepsi akseptor.</p>
        </div>
        <a href="{{ route('kb-services.create') }}" class="relative z-10 bg-white text-[#117a65] px-6 py-2.5 rounded-xl font-bold shadow hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center gap-2 no-underline">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Layanan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white p-5 rounded-2xl mb-8 border border-gray-100 shadow-sm">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pencarian</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" placeholder="Cari nama akseptor atau NIK..." value="{{ request('search') }}"
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border-none shadow-sm rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent transition-all outline-none">
                </div>
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Metode KB</label>
                <select name="method" class="w-full px-4 py-2.5 bg-gray-50 border-none shadow-sm rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent transition-all outline-none min-w-[160px]">
                    <option value="">Semua Metode</option>
                    <option value="IUD" @selected(request('method') == 'IUD')>IUD</option>
                    <option value="Implant" @selected(request('method') == 'Implant')>Implant</option>
                    <option value="Pil" @selected(request('method') == 'Pil')>Pil</option>
                    <option value="Suntik" @selected(request('method') == 'Suntik')>Suntik</option>
                    <option value="Kondom" @selected(request('method') == 'Kondom')>Kondom</option>
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2.5 bg-gray-50 border-none shadow-sm rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent transition-all outline-none min-w-[160px]">
                    <option value="">Semua Status</option>
                    <option value="verified" @selected(request('status') == 'verified')>Terverifikasi</option>
                    <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                </select>
            </div>
            
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-2.5 rounded-xl font-medium transition-colors shadow-sm h-[46px] flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Terapkan
            </button>
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($services->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Akseptor</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Metode KB</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal & Lokasi</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Follow-up</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($services as $service)
                            @if($service->acceptor)
                            <tr class="hover:bg-gray-50/80 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-100 to-teal-50 flex items-center justify-center text-[#117a65] font-bold shadow-inner flex-shrink-0">
                                            {{ strtoupper(substr($service->acceptor->full_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('kb-acceptors.show', $service->acceptor->id) }}" class="font-bold text-gray-900 hover:text-[#117a65] transition-colors no-underline">{{ $service->acceptor->full_name }}</a>
                                            <div class="text-xs text-gray-500 font-medium mt-0.5">NIK: {{ $service->acceptor->nik }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100 whitespace-nowrap">
                                        {{ $service->service_method }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 whitespace-nowrap">{{ $service->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5 max-w-[150px] truncate" title="{{ $service->puskesmasData->name ?? '-' }}">{{ $service->puskesmasData->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($service->follow_up_date)
                                        <div class="text-sm font-medium text-gray-900 whitespace-nowrap">
                                            {{ $service->follow_up_date->format('d M Y') }}
                                        </div>
                                        @if($service->follow_up_date < now() && !$service->is_verified)
                                            <span class="text-[10px] font-bold text-red-600 uppercase tracking-wide bg-red-50 px-1.5 py-0.5 rounded mt-1 inline-block">Terlewat</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400 text-sm italic">Tidak ada jadwal</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($service->is_verified)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-green-50 text-green-700 border border-green-100 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Terverifikasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-100 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('kb-services.show', $service->id) }}" 
                                           class="inline-flex items-center justify-center w-8 h-8 text-teal-600 bg-teal-50 border border-teal-100 hover:bg-teal-600 hover:text-white rounded-lg transition-colors no-underline shadow-sm" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('kb-services.edit', $service->id) }}" 
                                           class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 border border-blue-100 hover:bg-blue-600 hover:text-white rounded-lg transition-colors no-underline shadow-sm" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('kb-services.destroy', $service->id) }}" method="POST" style="display: inline;"
                                              onsubmit="return confirm('Yakin hapus layanan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 text-red-600 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-colors border border-red-100 cursor-pointer shadow-sm" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                {{ $services->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada riwayat pelayanan</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Riwayat pelayanan KB yang Anda inputkan akan muncul di sini. Mulai dengan menambahkan layanan KB baru.</p>
                <a href="{{ route('kb-services.create') }}" class="inline-flex items-center gap-2 bg-[#117a65] hover:bg-[#0f6b58] text-white px-6 py-2.5 rounded-xl font-medium transition-colors no-underline">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Layanan KB
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

