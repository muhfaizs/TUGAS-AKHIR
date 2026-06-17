@extends('layouts.app')

@section('title', 'Kelola Dinkes - SatuKIA')
@section('header_title', 'Kelola Dinkes')
@section('header_subtitle', 'Tambah, edit, dan hapus pengguna sistem (Dinkes)')

@section('content')
    <!-- Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800">Data Pengguna Terdaftar</h3>
            <div class="flex gap-3">
                <a href="{{ route('dinkes.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl transition-colors shadow-sm shadow-teal-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Dinkes
                </a>
            </div>
        </div>

        <div class="p-6 md:p-8 pt-4">
            <table id="dinkes-table" class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Pengguna</th>
                        <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Role</th>
                        <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Kontak</th>
                        <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Status</th>
                        <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">Terdaftar</th>
                        <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($penggunas as $pengguna)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="py-4 border-b border-slate-50">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full {{ $pengguna->role === 'dinkes' ? 'bg-teal-100 text-teal-700' : 'bg-indigo-100 text-indigo-700' }} flex items-center justify-center font-bold">
                                    {{ substr($pengguna->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $pengguna->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $pengguna->email }}</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $pengguna->role === 'dinkes' ? 'NIP: ' . ($pengguna->nip ?? '-') : 'NIK: ' . ($pengguna->nik ?? '-') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 border-b border-slate-50">
                            @if($pengguna->role === 'dinkes')
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-teal-50 text-teal-700 border border-teal-100">Dinkes</span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">Ibu Hamil</span>
                            @endif
                        </td>
                        <td class="py-4 border-b border-slate-50 text-slate-600">{{ $pengguna->phone ?? '-' }}</td>
                        <td class="py-4 border-b border-slate-50">
                            @if(($pengguna->status ?? 'aktif') === 'aktif')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-green-50 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    Non-Aktif
                                </span>
                            @endif
                        </td>
                        <td class="py-4 border-b border-slate-50 text-slate-600">{{ $pengguna->created_at->format('d M, Y') }}</td>
                        <td class="py-4 border-b border-slate-50 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ $pengguna->role === 'dinkes' ? route('dinkes.edit', $pengguna->id) : route('ortu.edit', $pengguna->id) }}" class="p-2 text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <form action="{{ $pengguna->role === 'dinkes' ? route('dinkes.destroy', $pengguna->id) : route('ortu.destroy', $pengguna->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = new simpleDatatables.DataTable("#dinkes-table", {
            searchable: true,
            fixedHeight: true,
            perPage: 10,
            labels: {
                placeholder: "Cari nama, email, NIP...",
                perPage: "Data per halaman",
                noRows: "Tidak ada data yang ditemukan",
                info: "Menampilkan {start} - {end} dari {rows} data",
            }
        });
        
        // Custom styling for Simple DataTables elements to match Tailwind
        const wrapper = document.querySelector('.dataTable-wrapper');
        if(wrapper) {
            const input = wrapper.querySelector('.dataTable-input');
            if(input) {
                input.classList.add('px-4', 'py-2.5', 'border', 'border-slate-200', 'rounded-xl', 'text-sm', 'focus:ring-teal-500', 'focus:border-teal-500', 'bg-slate-50', 'w-64');
            }
            
            const selector = wrapper.querySelector('.dataTable-selector');
            if(selector) {
                selector.classList.add('px-3', 'py-2', 'border', 'border-slate-200', 'rounded-lg', 'text-sm', 'bg-white', 'mr-2');
            }
            
            const search = wrapper.querySelector('.dataTable-search');
            if(search) {
                search.classList.add('mb-4');
            }
            
            const top = wrapper.querySelector('.dataTable-top');
            if(top) {
                top.classList.add('flex', 'flex-col', 'md:flex-row', 'justify-between', 'items-start', 'md:items-center', 'mb-6');
            }
        }
    });
</script>
<style>
    /* Additional overrides for Simple-DataTables */
    .dataTable-table > thead > tr > th {
        border-bottom: 1px solid #f1f5f9 !important;
        padding-bottom: 1rem;
    }
    .dataTable-pagination a {
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        margin: 0 0.125rem;
        font-size: 0.875rem;
        color: #64748b;
        transition: all 0.2s;
    }
    .dataTable-pagination a:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }
    .dataTable-pagination .active a,
    .dataTable-pagination .active a:hover {
        background-color: #0d9488;
        color: white;
    }
</style>
@endpush
