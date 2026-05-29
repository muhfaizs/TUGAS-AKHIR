@extends('layouts.dashboard')

@section('title', 'Riwayat Kesehatan Anak')
@section('page_title', 'Riwayat Kesehatan Terintegrasi')
@section('page_subtitle', 'Timeline medis, pengukuran, dan imunisasi untuk ' . $anak->nama_anak)

@section('content')
@php
    $routePrefix = auth()->user()->isOrangTua() ? 'orangtua' : (auth()->user()->isBidan() ? 'bidan' : 'admin');
@endphp

<div class="header-actions">
    <a href="{{ route($routePrefix . '.anak.index') }}" class="btn-back">
        <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
        Kembali ke Data Anak
    </a>
</div>

<div class="profile-card">
    <div class="profile-header">
        <div class="profile-avatar profile-avatar--{{ strtolower($anak->jenis_kelamin) == 'laki-laki' ? 'boy' : 'girl' }}">
            {{ strtoupper(substr($anak->nama_anak, 0, 2)) }}
        </div>
        <div class="profile-info">
            <h2>{{ $anak->nama_anak }}</h2>
            <p>NIK: {{ $anak->nik_anak ?? '-' }} • {{ $anak->tanggal_lahir->format('d M Y') }} ({{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} tahun)</p>
        </div>
    </div>
    <div class="profile-stats">
        <div class="stat-item">
            <span class="stat-label">Golongan Darah</span>
            <span class="stat-value">{{ $anak->golongan_darah ?: '-' }}</span>
        </div>
        <div class="stat-item">
            <span class="stat-label">BB Lahir</span>
            <span class="stat-value">{{ $anak->berat_lahir }} kg</span>
        </div>
        <div class="stat-item">
            <span class="stat-label">TB Lahir</span>
            <span class="stat-value">{{ $anak->panjang_lahir }} cm</span>
        </div>
    </div>
</div>

<div class="timeline-container">
    <h3 class="timeline-title">Timeline Rekam Medis</h3>

    @if($timeline->isEmpty())
        <div class="empty-state">
            <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
            <p>Belum ada riwayat kesehatan yang tercatat untuk anak ini.</p>
        </div>
    @else
        <div class="timeline">
            @foreach($timeline as $item)
                <div class="timeline-item">
                    <div class="timeline-marker timeline-marker--{{ $item['type'] }}">
                        @if($item['type'] == 'pengukuran')
                            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                        @elseif($item['type'] == 'tindakan')
                            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h-2v5H6v2h2v5h2v-5h2v-2z"/></svg>
                        @elseif($item['type'] == 'imunisasi')
                            <svg viewBox="0 0 24 24"><path d="M11 2v4h2V2h-2zm0 14h2v6h-2v-6zm3-11v2h2v2h-2v2h2v2h-2v2h2v2h-2v2h4V5h-4zm-8 4v2h2V9H6zm0 4v2h2v-2H6z"/></svg>
                        @endif
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <span class="timeline-date">{{ \Carbon\Carbon::parse($item['date'])->format('d M Y') }}</span>
                            <span class="timeline-badge timeline-badge--{{ $item['type'] }}">
                                {{ ucfirst($item['type']) }}
                            </span>
                        </div>
                        
                        <div class="timeline-body">
                            @if($item['type'] == 'pengukuran')
                                <div class="data-grid">
                                    <div class="data-box">
                                        <div class="data-val">{{ $item['data']->berat_badan }} <span>kg</span></div>
                                        <div class="data-lbl">Berat Badan</div>
                                    </div>
                                    <div class="data-box">
                                        <div class="data-val">{{ $item['data']->tinggi_badan }} <span>cm</span></div>
                                        <div class="data-lbl">Tinggi Badan</div>
                                    </div>
                                    <div class="data-box">
                                        <div class="data-val">{{ $item['data']->lingkar_kepala ?? '-' }} <span>cm</span></div>
                                        <div class="data-lbl">Lingkar Kepala</div>
                                    </div>
                                </div>
                                @if($item['data']->status_stunting || $item['data']->status_gizi)
                                <div class="status-grid mt-3">
                                    <div class="status-badge {{ str_contains(strtolower($item['data']->status_stunting), 'stunting') ? 'status-bad' : 'status-good' }}">
                                        {{ $item['data']->status_stunting ?: 'Status Stunting N/A' }}
                                    </div>
                                    <div class="status-badge {{ str_contains(strtolower($item['data']->status_gizi), 'kurang') || str_contains(strtolower($item['data']->status_gizi), 'buruk') ? 'status-bad' : 'status-good' }}">
                                        {{ $item['data']->status_gizi ?: 'Status Gizi N/A' }}
                                    </div>
                                </div>
                                @endif
                            @elseif($item['type'] == 'tindakan')
                                <h4>Pemeriksaan / Tindakan Medis</h4>
                                @if($item['data']->diagnosa)
                                    <div class="diagnosa-box">
                                        <strong>Diagnosa:</strong> {{ $item['data']->diagnosa }}
                                    </div>
                                @endif
                                @if($item['data']->catatan_pemeriksaan)
                                    <p class="catatan-text">{{ $item['data']->catatan_pemeriksaan }}</p>
                                @endif
                            @elseif($item['type'] == 'imunisasi')
                                <h4>Pemberian Vaksin: <span class="text-primary">{{ $item['data']->nama_vaksin }}</span></h4>
                            @endif
                        </div>
                        
                        <div class="timeline-footer">
                            <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                            Oleh: {{ $item['actor'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.header-actions { margin-bottom: 24px; }
.btn-back {
    display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px;
    background: #fff; color: #475569; border-radius: 12px; border: 1px solid rgba(15,23,42,0.1);
    font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s;
}
.btn-back:hover { background: #F8FAFC; color: #0F172A; }
.btn-back svg { width: 16px; height: 16px; fill: currentColor; }

.profile-card {
    background: #fff; border-radius: 20px; padding: 24px; margin-bottom: 32px;
    box-shadow: 0 4px 20px rgba(13,148,136,0.06); border: 1px solid rgba(15,23,42,0.06);
    display: flex; flex-direction: column; gap: 24px;
}
@media(min-width: 768px) {
    .profile-card { flex-direction: row; align-items: center; justify-content: space-between; }
}
.profile-header { display: flex; align-items: center; gap: 20px; }
.profile-avatar {
    width: 72px; height: 72px; border-radius: 20px; display: grid; place-items: center;
    color: #fff; font-size: 24px; font-weight: 800;
}
.profile-avatar--boy { background: linear-gradient(135deg, #3B82F6, #1D4ED8); }
.profile-avatar--girl { background: linear-gradient(135deg, #EC4899, #BE185D); }
.profile-info h2 { margin: 0 0 4px; font-size: 20px; font-weight: 700; color: #0F172A; }
.profile-info p { margin: 0; color: #64748B; font-size: 14px; }

.profile-stats { display: flex; gap: 24px; }
.stat-item { display: flex; flex-direction: column; gap: 4px; }
.stat-label { font-size: 12px; color: #64748B; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; }
.stat-value { font-size: 16px; font-weight: 700; color: #1E293B; }

.timeline-container {
    background: #fff; border-radius: 20px; padding: 32px;
    box-shadow: 0 4px 20px rgba(13,148,136,0.06); border: 1px solid rgba(15,23,42,0.06);
}
.timeline-title { margin: 0 0 32px; font-size: 18px; font-weight: 700; color: #0F172A; }

.empty-state { text-align: center; padding: 48px 0; color: #94A3B8; }
.empty-state svg { width: 48px; height: 48px; fill: currentColor; margin-bottom: 16px; }

.timeline { position: relative; padding-left: 24px; }
.timeline::before {
    content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 2px;
    background: #E2E8F0; border-radius: 2px;
}
.timeline-item { position: relative; margin-bottom: 32px; }
.timeline-item:last-child { margin-bottom: 0; }
.timeline-marker {
    position: absolute; left: -35px; top: 0; width: 24px; height: 24px;
    border-radius: 50%; display: grid; place-items: center; border: 3px solid #fff;
    box-shadow: 0 0 0 1px #E2E8F0; z-index: 1;
}
.timeline-marker svg { width: 12px; height: 12px; fill: #fff; }
.timeline-marker--pengukuran { background: #3B82F6; }
.timeline-marker--tindakan { background: #EF4444; }
.timeline-marker--imunisasi { background: #10B981; }

.timeline-content {
    background: #F8FAFC; border-radius: 16px; padding: 20px;
    border: 1px solid #E2E8F0;
}
.timeline-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
.timeline-date { font-weight: 600; color: #334155; font-size: 15px; }
.timeline-badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
.timeline-badge--pengukuran { background: rgba(59,130,246,0.1); color: #2563EB; }
.timeline-badge--tindakan { background: rgba(239,68,68,0.1); color: #DC2626; }
.timeline-badge--imunisasi { background: rgba(16,185,129,0.1); color: #059669; }

.timeline-body h4 { margin: 0 0 12px; font-size: 15px; color: #0F172A; }
.text-primary { color: var(--kia-primary); }

.data-grid { display: flex; gap: 12px; flex-wrap: wrap; }
.data-box { background: #fff; border: 1px solid #E2E8F0; border-radius: 12px; padding: 12px 16px; flex: 1; min-width: 120px; }
.data-val { font-size: 18px; font-weight: 800; color: #0F172A; }
.data-val span { font-size: 12px; font-weight: 600; color: #64748B; }
.data-lbl { font-size: 11px; color: #64748B; margin-top: 4px; font-weight: 500; text-transform: uppercase; }

.mt-3 { margin-top: 12px; }
.status-grid { display: flex; gap: 8px; }
.status-badge { padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; }
.status-good { background: rgba(16,185,129,0.1); color: #059669; border: 1px solid rgba(16,185,129,0.2); }
.status-bad { background: rgba(239,68,68,0.1); color: #DC2626; border: 1px solid rgba(239,68,68,0.2); }

.diagnosa-box { background: rgba(239,68,68,0.05); border-left: 3px solid #EF4444; padding: 12px 16px; border-radius: 4px 8px 8px 4px; margin-bottom: 12px; font-size: 14px; color: #1E293B; }
.catatan-text { margin: 0; font-size: 14px; color: #475569; line-height: 1.5; }

.timeline-footer { margin-top: 16px; padding-top: 16px; border-top: 1px dashed #E2E8F0; display: flex; align-items: center; gap: 6px; font-size: 13px; color: #64748B; font-weight: 500; }
.timeline-footer svg { width: 14px; height: 14px; fill: currentColor; }
</style>
@endsection
