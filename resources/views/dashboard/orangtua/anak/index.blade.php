@extends('layouts.dashboard')

@section('title', 'Data Anak')
@section('page_title', 'Data Anak')
@section('page_subtitle', 'Pantau dan kelola data anak Anda')

@section('content')
@php
    $routePrefix = auth()->user()->isOrangTua() ? 'orangtua' : (auth()->user()->isBidan() ? 'bidan' : 'admin');
@endphp
<div class="anak-header">
    <a href="{{ route($routePrefix . '.anak.create') }}" class="btn-add">
        <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/></svg>
        Daftarkan Anak Baru
    </a>
</div>

<div class="anak-grid">
    @forelse($anak as $a)
        <div class="anak-card">
            <div class="anak-card-header">
                <div class="anak-avatar anak-avatar--{{ strtolower($a->jenis_kelamin) == 'laki-laki' ? 'boy' : 'girl' }}">
                    {{ strtoupper(substr($a->nama_anak, 0, 2)) }}
                </div>
                <div class="anak-actions">
                    <a href="{{ route($routePrefix . '.anak.show', $a) }}" class="btn-icon btn-icon-view" title="Riwayat Kesehatan">
                        <svg viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                    </a>
                    <a href="{{ route($routePrefix . '.anak.edit', $a) }}" class="btn-icon btn-icon-edit" title="Edit">
                        <svg viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                    </a>
                    <form method="POST" action="{{ route($routePrefix . '.anak.destroy', $a) }}" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus data anak ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon btn-icon-delete" title="Hapus">
                            <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="anak-card-body">
                <h3 class="anak-name">{{ $a->nama_anak }}</h3>
                <div class="anak-detail">
                    <span class="detail-label">Tanggal Lahir</span>
                    <span class="detail-value">{{ $a->tempat_lahir }}, {{ $a->tanggal_lahir->format('d M Y') }}</span>
                </div>
                <div class="anak-detail">
                    <span class="detail-label">Jenis Kelamin</span>
                    <span class="detail-value">{{ $a->jenis_kelamin }}</span>
                </div>
                @if($a->golongan_darah)
                <div class="anak-detail">
                    <span class="detail-label">Golongan Darah</span>
                    <span class="detail-value">{{ $a->golongan_darah }}</span>
                </div>
                @endif
                @if (!auth()->user()->isOrangTua() && $a->orangTua)
                <div class="anak-detail">
                    <span class="detail-label">Orang Tua</span>
                    <span class="detail-value">{{ $a->orangTua->nama_lengkap }}</span>
                </div>
                @endif
                
                <div class="anak-stats">
                    <div class="stat-box">
                        <span class="stat-val">{{ $a->berat_lahir }}<small>kg</small></span>
                        <span class="stat-lbl">Berat Lahir</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-val">{{ $a->panjang_lahir }}<small>cm</small></span>
                        <span class="stat-lbl">Panjang Lahir</span>
                    </div>
                    @if($a->lingkar_kepala_lahir)
                    <div class="stat-box">
                        <span class="stat-val">{{ $a->lingkar_kepala_lahir }}<small>cm</small></span>
                        <span class="stat-lbl">Lingkar Kepala</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="anak-empty">
            <svg class="empty-icon" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
            <p>Belum ada data anak yang didaftarkan.</p>
            <a href="{{ route($routePrefix . '.anak.create') }}" class="btn-add">Daftarkan Sekarang</a>
        </div>
    @endforelse
</div>

<style>
.anak-header { display: flex; justify-content: flex-end; margin-bottom: 24px; }
.btn-add {
    display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px;
    background: var(--kia-primary); color: #fff; border-radius: 12px;
    font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s;
}
.btn-add:hover { background: var(--kia-primary-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(13,148,136,0.2); color: #fff; }
.btn-add svg { width: 18px; height: 18px; fill: currentColor; }

.anak-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; }

.anak-card {
    background: #fff; border-radius: 20px; padding: 24px;
    box-shadow: 0 4px 20px rgba(13,148,136,0.06); border: 1px solid rgba(15,23,42,0.06);
    transition: all 0.3s;
}
.anak-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(13,148,136,0.12); }

.anak-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; }
.anak-avatar {
    width: 56px; height: 56px; border-radius: 16px; display: grid; place-items: center;
    color: #fff; font-size: 18px; font-weight: 800;
}
.anak-avatar--boy { background: linear-gradient(135deg, #3B82F6, #1D4ED8); }
.anak-avatar--girl { background: linear-gradient(135deg, #EC4899, #BE185D); }

.anak-actions { display: flex; gap: 8px; }
.btn-icon {
    width: 32px; height: 32px; border-radius: 8px; border: none; background: none; cursor: pointer;
    display: grid; place-items: center; transition: all 0.2s; color: #94A3B8; text-decoration: none;
}
.btn-icon-view:hover { background: rgba(16,185,129,0.1); color: #059669; }
.btn-icon-edit:hover { background: rgba(14,165,233,0.1); color: #0284C7; }
.btn-icon-delete:hover { background: rgba(239,68,68,0.1); color: #DC2626; }
.btn-icon svg { width: 16px; height: 16px; fill: currentColor; }
.inline-form { margin: 0; }

.anak-name { font-size: 18px; font-weight: 700; color: #0F172A; margin: 0 0 16px; }

.anak-detail { display: flex; flex-direction: column; gap: 2px; margin-bottom: 12px; }
.detail-label { font-size: 12px; color: #64748B; font-weight: 500; }
.detail-value { font-size: 14px; color: #1E293B; font-weight: 600; }

.anak-stats { display: flex; gap: 12px; margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(15,23,42,0.06); }
.stat-box { flex: 1; background: rgba(240,253,250,0.5); padding: 12px; border-radius: 12px; display: flex; flex-direction: column; align-items: center; }
.stat-val { font-size: 18px; font-weight: 800; color: var(--kia-primary-dark); }
.stat-val small { font-size: 12px; font-weight: 600; color: #64748B; margin-left: 2px; }
.stat-lbl { font-size: 11px; color: #64748B; margin-top: 4px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; }

.anak-empty {
    grid-column: 1 / -1; background: #fff; border-radius: 20px; padding: 64px 24px;
    text-align: center; border: 1px dashed rgba(15,23,42,0.15);
}
.empty-icon { width: 48px; height: 48px; fill: #CBD5E1; margin: 0 auto 16px; display: block; }
.anak-empty p { color: #64748B; font-size: 15px; margin-bottom: 24px; }
</style>
@endsection
