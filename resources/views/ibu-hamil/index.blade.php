@extends('layouts.dashboard')

@section('title', 'Data Ibu Hamil - SatuKIA')
@section('page_title', 'Data Ibu Hamil')
@section('page_subtitle', 'Cari profil dan kelola data rekam medis ibu hamil')

@section('content')
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Daftar Pasien Ibu Hamil</h3>
                <p class="text-sm text-slate-500">Gunakan kotak pencarian untuk fitur Cari Profil Ibu Hamil (berdasarkan Nama/NIK)</p>
            </div>
            
            <a href="{{ route('ibu-hamil.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl transition-colors shadow-sm shadow-teal-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Pasien Baru
            </a>
        </div>

        <div class="p-6 md:p-8 pt-4">
            <!-- Form Pencarian -->
            <form action="{{ route('ibu-hamil.index') }}" method="GET" class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex w-full md:w-auto gap-2">
                    <div class="relative w-full md:w-80">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan Nama atau NIK pasien..." class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-teal-500 focus:border-teal-500 bg-slate-50">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    @if(request('search'))
                        <a href="{{ route('ibu-hamil.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition-colors flex items-center gap-1" title="Reset Pencarian">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </a>
                    @endif
                </div>
                <button type="submit" class="hidden">Cari</button>
            </form>

            <table id="ibuhamil-table" class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Pasien (Nama & NIK)</th>
                        <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Umur</th>
                        <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Riwayat (G/P/A)</th>
                        <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Total TTD (Tablet)</th>
                        <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Status Kehamilan & Risiko</th>
                        <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($ibuHamils as $pasien)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="py-4 border-b border-slate-50">
                            <a href="{{ route('ibu-hamil.show', $pasien->id) }}" class="flex items-center gap-4 group/profile hover:opacity-80 transition-opacity">
                                <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-700 flex items-center justify-center font-bold">
                                    {{ substr($pasien->nama_lengkap, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 group-hover/profile:text-teal-600 transition-colors">{{ $pasien->nama_lengkap }}</p>
                                    <p class="text-xs text-slate-500">NIK: {{ $pasien->nik }}</p>
                                </div>
                            </a>
                        </td>
                        <td class="py-4 border-b border-slate-50 text-slate-600 font-medium">{{ $pasien->umur }} Thn</td>
                        <td class="py-4 border-b border-slate-50">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                G{{ $pasien->gravida }} P{{ $pasien->paritas }} A{{ $pasien->abortus }}
                            </span>
                        </td>
                        <td class="py-4 border-b border-slate-50 text-slate-600 font-medium text-center">
                            @if(($pasien->pemeriksaan_ancs_sum_jumlah_tablet_darah ?? 0) > 0)
                                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-bold border border-indigo-100">{{ $pasien->pemeriksaan_ancs_sum_jumlah_tablet_darah }} Tablet</span>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="py-4 border-b border-slate-50">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-semibold text-slate-700">{{ $pasien->status_kehamilan_terakhir ?: 'Sedang Hamil' }}</span>
                                <div>
                                    @if($pasien->status_risiko_kehamilan == 'Rendah')
                                        <span class="inline-flex px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold tracking-wide">RISIKO RENDAH</span>
                                    @elseif($pasien->status_risiko_kehamilan == 'Tinggi')
                                        <span class="inline-flex px-2 py-0.5 bg-amber-100 text-amber-700 rounded text-[10px] font-bold tracking-wide">RISIKO TINGGI</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 bg-red-100 text-red-700 rounded text-[10px] font-bold tracking-wide">SANGAT TINGGI</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 border-b border-slate-50 text-right">
                            <div class="flex items-center justify-end gap-2 transition-opacity">
                                <a href="{{ route('ibu-hamil.show', $pasien->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-teal-700 bg-teal-50 border border-teal-200 hover:bg-teal-100 rounded-md transition-colors">
                                    Lihat Detail
                                </a>
                                <a href="{{ route('pemeriksaan-anc.create', ['ibu_hamil_id' => $pasien->id]) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-white bg-teal-600 hover:bg-teal-700 rounded-md transition-colors shadow-sm">
                                    Input ANC
                                </a>
                                <form action="{{ route('ibu-hamil.destroy', $pasien->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data pasien ini permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-500 bg-red-50 hover:bg-red-100 rounded-md transition-colors" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-lg font-bold text-slate-700 mb-1">Data Tidak Tersedia</h3>
                                <p class="text-slate-500 text-sm">Tidak ada profil pasien yang cocok dengan pencarian Anda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<style>
    /* Pagination link styling for server-side pagination if needed */
    .pagination a {
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        margin: 0 0.125rem;
        font-size: 0.875rem;
        color: #64748b;
        transition: all 0.2s;
    }
</style>
@endpush

