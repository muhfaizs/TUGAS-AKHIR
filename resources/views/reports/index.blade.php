@extends('layouts.dashboard')

@section('title', 'Laporan Tahunan KB')
@section('page_title', 'Laporan KB')
@section('page_subtitle', 'Kelola, unduh, dan kirimkan Laporan KB.')

@section('content')
<div class="min-h-screen bg-transparent">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-[#105448] to-[#1c7c6b] rounded-2xl p-8 mb-8 shadow-lg text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white opacity-5 rounded-full"></div>
        <div class="relative z-10 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Laporan KB</h1>
                <p class="text-teal-100 text-sm">Buat, unduh, dan kirimkan Laporan KB ke Dinas Kesehatan.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Form Buat Laporan Baru -->
    @if(auth()->user()->role !== 'dinas_kesehatan')
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Buat Laporan Baru</h2>
        <form action="{{ route('reports.store') }}" method="POST" class="flex items-end gap-4">
            @csrf
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Pilih Tahun</label>
                <select name="year" id="year" required class="min-w-[200px] py-2.5 px-4 text-base rounded-md border-gray-300 shadow-sm focus:border-[#117a65] focus:ring-[#117a65]">
                    @for($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex items-end pb-0.5">
                <button type="submit" class="px-6 py-2.5 bg-[#117a65] text-white font-medium rounded-md hover:bg-[#0e6150] transition-colors flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Generate Laporan
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Daftar Laporan -->
    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 font-semibold text-sm border-b">
                        <th class="px-6 py-4">Tahun</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Bidan/Pembuat</th>
                        <th class="px-6 py-4">Verifikator</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-800">
                    @forelse($reports as $report)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">{{ $report->year }}</td>
                        <td class="px-6 py-4">
                            @if($report->status == 'draft')
                                <span class="px-3 py-1 bg-gray-200 text-gray-800 rounded-full text-xs font-bold uppercase tracking-wider">Draft</span>
                            @elseif($report->status == 'submitted')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold uppercase tracking-wider">Terkirim</span>
                            @elseif($report->status == 'verified')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold uppercase tracking-wider">Terverifikasi</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $report->submittedBy->name ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $report->verifiedBy->name ?? '-' }}</td>
                        <td class="px-6 py-4 flex justify-center gap-2">
                            <!-- Download PDF -->
                            <a href="{{ route('reports.download', $report->id) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium flex items-center gap-2 text-sm no-underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                PDF
                            </a>

                            <!-- Bidan Actions -->
                            @if(auth()->user()->role !== 'dinas_kesehatan')
                                @if($report->status == 'draft' || $report->status == 'rejected')
                                <form action="{{ route('reports.submit', $report->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin mengirimkan laporan ini ke Dinas Kesehatan?')">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                        Kirim
                                    </button>
                                </form>
                                @endif
                            @endif

                            <!-- Dinas Kesehatan Actions -->
                            @if(auth()->user()->role === 'dinas_kesehatan')
                                @if($report->status != 'verified')
                                <form action="{{ route('reports.verify', $report->id) }}" method="POST" onsubmit="return confirm('Tandai laporan ini sebagai Terverifikasi?')">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        Verifikasi
                                    </button>
                                </form>
                                @endif
                            @endif

                            <!-- Delete Action -->
                            @if(auth()->user()->role !== 'dinas_kesehatan')
                            <form action="{{ route('reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus Laporan Tahun {{ $report->year }} ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Belum ada laporan tahunan yang dibuat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

