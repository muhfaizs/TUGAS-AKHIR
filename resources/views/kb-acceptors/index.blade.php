@extends('layouts.dashboard')

@section('title', 'Daftar Pasien KB - SatuKIA')
@section('page_title', 'Daftar Pasien KB')
@section('page_subtitle', 'Kelola data pasien Keluarga Berencana')

@section('content')

<style>
    /* â”€â”€ Top actions bar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .action-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .search-group {
        display: flex;
        gap: 10px;
        flex: 1;
        max-width: 600px;
        flex-wrap: wrap;
    }

    .search-wrap {
        position: relative;
        flex: 1;
        min-width: 180px;
    }
    .search-icon {
        position: absolute;
        top: 50%; left: 11px;
        transform: translateY(-50%);
        color: #9ca3af;
        pointer-events: none;
        display: flex; align-items: center;
    }
    .search-icon svg { width: 15px; height: 15px; }

    .search-input {
        width: 100%;
        padding: 9px 12px 9px 36px;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        color: #111827;
        background: #f9fafb;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }
    .search-input:focus {
        border-color: #117a65;
        box-shadow: 0 0 0 3px rgba(17,122,101,0.10);
        background: #fff;
    }
    .search-input::placeholder { color: #9ca3af; }

    .filter-select {
        padding: 9px 12px;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        color: #374151;
        background: #f9fafb;
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s;
        min-width: 140px;
    }
    .filter-select:focus { border-color: #117a65; }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        background: linear-gradient(135deg, #0f5a4a, #16a085);
        color: #fff;
        font-size: 13.5px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        text-decoration: none;
        transition: opacity 0.2s, transform 0.15s;
        box-shadow: 0 3px 10px rgba(17,122,101,0.28);
        white-space: nowrap;
    }
    .btn-primary:hover { opacity: 0.88; transform: translateY(-1px); }
    .btn-primary svg { width: 16px; height: 16px; }

    /* â”€â”€ Table card â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .table-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
    }

    .data-table thead tr {
        background: #f9fafb;
        border-bottom: 1px solid #f3f4f6;
    }
    .data-table th {
        padding: 12px 18px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #9ca3af;
    }
    .data-table th.center { text-align: center; }

    .data-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #f9fafb;
        color: #374151;
        vertical-align: middle;
    }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover { background: #f9fafb; transition: background 0.15s; }
    .data-table td.center { text-align: center; }

    /* User avatar cell */
    .user-cell { display: flex; align-items: center; gap: 10px; }
    .user-avatar {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }
    .user-name  { font-weight: 600; color: #111827; font-size: 13.5px; }
    .user-sub   { font-size: 11.5px; color: #9ca3af; margin-top: 2px; }

    /* Status badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; }
    .s-active   { background: #dcfce7; color: #166534; }
    .s-inactive { background: #f3f4f6; color: #6b7280; }
    .s-transferred { background: #dbeafe; color: #1e40af; }
    .s-graduated   { background: #f3e8ff; color: #7e22ce; }

    /* Action buttons */
    .action-btns { display: flex; align-items: center; justify-content: center; gap: 6px; flex-wrap: nowrap; }

    .btn-icon {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 11px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: opacity 0.18s, transform 0.15s;
        white-space: nowrap;
    }
    .btn-icon:hover { opacity: 0.82; transform: translateY(-1px); }
    .btn-icon svg { width: 13px; height: 13px; }

    .btn-view   { background: #fff7ed; color: #c2410c; }
    .btn-edit   { background: #eff6ff; color: #1d4ed8; }
    .btn-send   { background: #f0fdf4; color: #166534; }
    .btn-delete { background: #fff1f2; color: #be123c; }

    /* Empty state */
    .empty-state {
        padding: 56px 24px;
        text-align: center;
    }
    .empty-icon {
        width: 56px; height: 56px;
        background: #f3f4f6;
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 14px;
        color: #9ca3af;
    }
    .empty-icon svg { width: 26px; height: 26px; }
    .empty-title { font-size: 15px; font-weight: 600; color: #374151; margin-bottom: 5px; }
    .empty-sub   { font-size: 13px; color: #9ca3af; }

    /* Pagination */
    .pagination-wrap { padding: 16px 20px; border-top: 1px solid #f3f4f6; }

    /* Alert success */
    .alert-ok {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13.5px;
        color: #166534;
        font-weight: 500;
    }
    .alert-ok-icon {
        width: 22px; height: 22px;
        background: #22c55e;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        color: #fff;
    }
    .alert-ok-icon svg { width: 13px; height: 13px; }

    /* Modal styles */
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        display: none; align-items: center; justify-content: center;
        z-index: 1000;
    }
    .modal-overlay.visible { display: flex; }
    .modal-card {
        background: #fff; width: 400px; padding: 24px; border-radius: 16px;
        text-align: center;
    }
    .modal-icon {
        width: 48px; height: 48px; background: #fee2e2; color: #ef4444;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }
    .modal-icon svg { width: 24px; height: 24px; }
    .modal-title { font-size: 18px; font-weight: 700; color: #111827; margin-bottom: 8px; }
    .modal-desc { font-size: 14px; color: #6b7280; margin-bottom: 24px; }
    .modal-btns { display: flex; gap: 12px; }
    .modal-btn-cancel { flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #d1d5db; background: #fff; color: #374151; font-weight: 600; cursor: pointer; }
    .modal-btn-confirm { flex: 1; padding: 10px; border-radius: 8px; border: none; background: #ef4444; color: #fff; font-weight: 600; cursor: pointer; }
</style>

@if (session('success'))
<div class="alert-ok">
    <div class="alert-ok-icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
    </div>
    {{ session('success') }}
</div>
@endif

<!-- Action bar -->
<div class="action-bar">
    <form action="{{ route('kb-acceptors.index') }}" method="GET" class="search-group">
        <div class="search-wrap">
            <span class="search-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </span>
            <input type="text" name="search" class="search-input" id="searchInput"
                   placeholder="Cari NIK, Nama, dan No.Hp..."
                   value="{{ request('search') }}"
                   oninput="clearTimeout(this.delay); this.delay = setTimeout(() => { this.form.submit() }, 500);">
        </div>

        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="active"      {{ request('status') === 'active'      ? 'selected' : '' }}>Aktif</option>
            <option value="inactive"    {{ request('status') === 'inactive'    ? 'selected' : '' }}>Tidak Aktif</option>
            <option value="transferred" {{ request('status') === 'transferred' ? 'selected' : '' }}>Pindah</option>
            <option value="graduated"   {{ request('status') === 'graduated'   ? 'selected' : '' }}>Lulus</option>
        </select>
    </form>

    @if(auth()->check() && in_array(auth()->user()->role, ['kader', 'bidan', 'admin', 'super_admin']))
    <a href="{{ route('kb-acceptors.create') }}" class="btn-primary">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Pasien
    </a>
    @endif
</div>

<!-- Table Card -->
<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Puskesmas</th>
                <th class="center">Status</th>
                <th class="center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($acceptors as $acceptor)
            @php
                $colors = [
                    'bg-gradient-to-br from-teal-400 to-teal-600',
                    'bg-gradient-to-br from-pink-400 to-pink-600',
                    'bg-gradient-to-br from-orange-400 to-orange-600',
                    'bg-gradient-to-br from-indigo-400 to-indigo-600',
                    'bg-gradient-to-br from-blue-400 to-blue-600'
                ];
                $color  = $colors[$loop->index % count($colors)];
                $initials = strtoupper(substr($acceptor->full_name, 0, 2));
            @endphp
            <tr class="group">
                <!-- NIK -->
                <td style="font-family:monospace; font-size:12.5px; color:#6b7280;">
                    {{ $acceptor->nik }}
                </td>

                <!-- Nama -->
                <td>
                    <div class="user-cell">
                        <div class="w-10 h-10 rounded-[12px] {{ $color }} text-white flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-sm border border-white/20 group-hover:scale-105 transition-transform">{{ $initials }}</div>
                        <div>
                            <div class="font-bold text-gray-800 truncate group-hover:text-teal-600 transition-colors">{{ $acceptor->full_name }}</div>
                            <div class="text-[11.5px] text-gray-500 truncate mt-0.5">{{ $acceptor->age }} tahun</div>
                        </div>
                    </div>
                </td>

                <!-- Telepon -->
                <td style="color:#6b7280; font-size:13px;">
                    {{ $acceptor->phone ?? '-' }}
                </td>

                <!-- Puskesmas -->
                <td style="font-size:13px;">
                    {{ $acceptor->puskesmas->name ?? 'N/A' }}
                </td>

                <!-- Status -->
                <td class="center">
                    @if($acceptor->status === 'active')
                        <span class="status-badge s-active">
                            <span class="status-dot" style="background:#22c55e;"></span> Aktif
                        </span>
                    @elseif($acceptor->status === 'inactive')
                        <span class="status-badge s-inactive">
                            <span class="status-dot" style="background:#9ca3af;"></span> Tidak Aktif
                        </span>
                    @elseif($acceptor->status === 'transferred')
                        <span class="status-badge s-transferred">
                            <span class="status-dot" style="background:#3b82f6;"></span> Pindah
                        </span>
                    @elseif($acceptor->status === 'graduated')
                        <span class="status-badge s-graduated">
                            <span class="status-dot" style="background:#8b5cf6;"></span> Lulus
                        </span>
                    @else
                        <span class="status-badge s-inactive">{{ ucfirst($acceptor->status) }}</span>
                    @endif
                </td>

                <!-- Aksi -->
                <td class="center">
                    <div class="action-btns">
                        <a href="{{ route('kb-acceptors.show', $acceptor) }}" class="btn-icon btn-view">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Lihat
                        </a>

                        @if(auth()->check() && in_array(auth()->user()->role, ['kader', 'bidan', 'admin', 'super_admin']))
                        <a href="{{ route('kb-acceptors.edit', $acceptor) }}" class="btn-icon btn-edit">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        @endif

                        @if(auth()->check() && in_array(auth()->user()->role, ['kader', 'bidan', 'admin', 'super_admin']) && !$acceptor->verification_requested_at && !$acceptor->is_verified)
                        <form action="{{ route('kb-acceptors.submit', $acceptor) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn-icon btn-send">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Kirim
                            </button>
                        </form>
                        @endif

                        @if(auth()->check() && in_array(auth()->user()->role, ['kader', 'bidan', 'admin', 'super_admin']))
                        <button type="button" class="btn-icon btn-delete" onclick="showDeleteModal('{{ route('kb-acceptors.destroy', $acceptor) }}')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                            </svg>
                        </div>
                        <div class="empty-title">Belum ada data akseptor KB</div>
                        <div class="empty-sub">Klik tombol "Tambah Akseptor" untuk menambahkan data baru.</div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($acceptors->hasPages())
    <div class="pagination-wrap">
        {{ $acceptors->links() }}
    </div>
    @endif
</div>

<!-- DELETE MODAL -->
<div id="deleteModal" class="modal-overlay" onclick="if(event.target===this)hideDeleteModal()">
    <div class="modal-card">
        <div class="modal-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h2 class="modal-title">Konfirmasi Hapus</h2>
        <p class="modal-desc">Apakah Anda yakin ingin menghapus pasien?</p>

        <div class="modal-btns">
            <button class="modal-btn-cancel" onclick="hideDeleteModal()">Tidak</button>
            <form id="deleteForm" action="" method="POST" style="flex:1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="modal-btn-confirm" style="width:100%;">Ya</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput && searchInput.value.length > 0) {
            searchInput.focus();
            let len = searchInput.value.length;
            searchInput.setSelectionRange(len, len);
        }
    });

    function showDeleteModal(url) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteModal').classList.add('visible');
    }
    function hideDeleteModal() {
        document.getElementById('deleteModal').classList.remove('visible');
    }
</script>

@endsection

