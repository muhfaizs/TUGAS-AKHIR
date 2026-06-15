@extends('layouts.app')

@section('title', 'Kelola Pengguna - SatuKIA')
@section('header_title', 'Kelola Pengguna')
@section('header_subtitle', 'Tambah, edit, dan hapus pengguna sistem')

@section('content')
<div class="max-w-[1100px] mx-auto">
    <!-- Card Container -->
    <div class="bg-white rounded-[16px] shadow-sm border border-gray-100 p-6">
        
        <!-- Top actions -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <form method="GET" action="{{ route('users.index') }}" class="flex items-center gap-3 flex-1 max-w-2xl">
                <!-- Search Input -->
                <div class="relative w-full max-w-[280px]">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full h-12 pl-11 pr-4 border border-solid border-gray-300 shadow-sm rounded-xl text-[13.5px] bg-white focus:outline-none focus:ring-0 focus:border-[#0d9488] transition-colors text-gray-700 placeholder-gray-400" placeholder="Cari nama, username, NIK..." autocomplete="off">
                </div>
                
                <!-- Role Dropdown -->
                <select name="role" class="h-12 px-4 border border-solid border-gray-300 shadow-sm rounded-xl text-[13.5px] bg-white focus:outline-none focus:ring-0 focus:border-[#0d9488] text-gray-700 min-w-[200px] cursor-pointer" onchange="this.form.submit()">
                    <option value="">Semua Role</option>
                    <option value="Bidan" {{ request('role') == 'Bidan' ? 'selected' : '' }}>Bidan</option>
                    <option value="Dinas Kesehatan" {{ request('role') == 'Dinas Kesehatan' ? 'selected' : '' }}>Dinas Kesehatan</option>
                    <option value="Kader" {{ request('role') == 'Kader' ? 'selected' : '' }}>Kader</option>
                    <option value="Pasien" {{ request('role') == 'Pasien' ? 'selected' : '' }}>Pasien</option>
                </select>
            </form>

            <div class="flex items-center gap-3">
                <a href="{{ route('users.create') }}" class="h-10 bg-[#117a65] hover:bg-[#0f5a4a] text-white px-5 rounded-lg text-[13.5px] font-semibold transition-colors flex items-center justify-center gap-2 border-none outline-none shadow-sm no-underline hover:no-underline">
                    <span>+</span> Tambah Pengguna
                </a>
            </div>
        </div>

        <div class="mb-4 text-sm font-semibold text-gray-800">Data Pengguna Terdaftar</div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full table-fixed align-middle text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="py-4 px-4 text-[12px] font-semibold uppercase text-[#9CA3AF] tracking-wide w-[30%]">Pengguna</th>
                        <th class="py-4 px-4 text-[12px] font-semibold uppercase text-[#9CA3AF] tracking-wide w-[15%]">Username</th>
                        <th class="py-4 px-4 text-[12px] font-semibold uppercase text-[#9CA3AF] tracking-wide w-[18%]">Role</th>
                        <th class="py-4 px-4 text-[12px] font-semibold uppercase text-[#9CA3AF] tracking-wide w-[15%]">Kontak</th>
                        <th class="py-4 px-4 text-[12px] font-semibold uppercase text-[#9CA3AF] tracking-wide w-[12%]">Status</th>
                        <th class="py-4 px-4 text-[12px] font-semibold uppercase text-[#9CA3AF] tracking-wide w-[10%] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-[13.5px]">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 px-4 align-middle">
                            <a href="{{ route('users.edit', $user->id) }}" class="flex items-center gap-3 group no-underline">
                                @php
                                    $colors = [
                                        'bg-gradient-to-br from-teal-400 to-teal-600',
                                        'bg-gradient-to-br from-pink-400 to-pink-600',
                                        'bg-gradient-to-br from-orange-400 to-orange-600',
                                        'bg-gradient-to-br from-indigo-400 to-indigo-600',
                                        'bg-gradient-to-br from-blue-400 to-blue-600'
                                    ];
                                    $initials = strtoupper(substr($user->name, 0, 2));
                                    $color = $colors[$loop->index % count($colors)];
                                @endphp
                                <div class="w-10 h-10 rounded-[12px] {{ $color }} text-white flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-sm border border-white/20 group-hover:scale-105 transition-transform">
                                    {{ $initials }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-bold text-gray-800 truncate group-hover:text-[#0d9488] transition-colors">{{ $user->name }}</div>
                                    <div class="text-[11px] text-gray-500 truncate mt-0.5">NIK: {{ $user->nik ?? '-' }}</div>
                                </div>
                            </a>
                        </td>
                        <td class="py-4 px-4 align-middle text-gray-500 font-mono text-xs truncate">
                            {{ $user->username }}
                        </td>
                        <td class="py-4 px-4 align-middle">
                            @if($user->role == 'Bidan')
                                <span class="px-3 py-1 rounded-full text-[12px] font-medium bg-[#ecfdf5] text-[#059669]">Bidan</span>
                            @elseif($user->role == 'Dinas Kesehatan')
                                <span class="px-3 py-1 rounded-full text-[12px] font-medium bg-[#fdf2f8] text-[#db2777]">Dinas Kesehatan</span>
                            @elseif($user->role == 'Kader')
                                <span class="px-3 py-1 rounded-full text-[12px] font-medium bg-[#fff7ed] text-[#ea580c]">Kader</span>
                            @elseif($user->role == 'Super Admin' || $user->role == 'super_admin')
                                <span class="px-3 py-1 rounded-full text-[12px] font-medium bg-gray-100 text-gray-700">Super Admin</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-[12px] font-medium bg-gray-100 text-gray-600">{{ $user->role }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 align-middle text-gray-600 truncate">
                            {{ $user->phone ?? '-' }}
                        </td>
                        <td class="py-4 px-4 align-middle">
                            @if($user->is_active ?? true)
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-green-50 text-green-600">Aktif</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-red-50 text-red-600">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 align-middle">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="w-9 h-9 flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 rounded-[10px] transition-colors border-none outline-none focus:outline-none" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L5.39 18.25l1.047-3.26a4.5 4.5 0 011.13-1.897l8.932-8.931zM16.862 4.487L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block m-0 p-0" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-[10px] transition-colors border-none outline-none focus:outline-none cursor-pointer" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                Tidak ada pengguna ditemukan.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="pt-6 mt-2 border-t border-gray-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    // Auto-submit form when typing in search box (with debouncing)
    let searchTimeout;
    const searchInput = document.querySelector('input[name="search"]');
    if(searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 600);
        });
        
        // Put cursor at the end of the input if it has value
        const val = searchInput.value;
        if(val) {
            searchInput.focus();
            searchInput.setSelectionRange(val.length, val.length);
        }
    }
</script>
@endsection
