@extends('layouts.app')

@section('title', 'Dashboard Bidan - SatuKIA')
@section('header_title', 'Dashboard')
@section('header_subtitle', \Carbon\Carbon::now()->translatedFormat('l, d F Y'))

@section('content')

<style>
    /* Add modern healthcare styling */
    :root {
        --teal-700: #0f766e;
        --teal-600: #0d9488;
        --teal-50: #f0fdfa;
        --orange-500: #f97316;
        --orange-50: #fff7ed;
    }
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    @media (max-width: 1024px) {
        .kpi-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .kpi-grid { grid-template-columns: 1fr; }
    }
    .kpi-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid #f3f4f6;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .kpi-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        background: var(--teal-50);
        color: var(--teal-700);
        display: flex; align-items: center; justify-content: center;
    }
    .kpi-icon.orange {
        background: var(--orange-50);
        color: var(--orange-500);
    }
    .kpi-content h4 { font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem; font-weight: 500; }
    .kpi-content p { font-size: 1.5rem; font-weight: 700; color: #111827; }

    .charts-grid {
        display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;
    }
    @media (max-width: 1024px) { .charts-grid { grid-template-columns: 1fr; } }
    
    .panel {
        background: #fff; border-radius: 16px; padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f3f4f6;
    }
    .panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .panel-title { font-size: 1.125rem; font-weight: 700; color: #111827; }

    .late-reminder {
        background: #fff7ed; border: 1px solid #fed7aa; border-radius: 16px; padding: 1.5rem; margin-bottom: 2rem;
    }
    .late-header { display: flex; align-items: center; gap: 0.5rem; color: #c2410c; font-weight: 700; font-size: 1.125rem; margin-bottom: 1rem; }
    .late-list { list-style: none; padding: 0; margin: 0 0 1rem 0; }
    .late-list li { padding: 0.5rem 0; border-bottom: 1px solid #fed7aa; color: #9a3412; font-size: 0.875rem; display:flex; justify-content:space-between; }
    .late-list li:last-child { border-bottom: none; }
    .btn-orange { background: #ea580c; color: #fff; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.875rem; font-weight: 600; text-decoration: none; display: inline-block; }
    .btn-orange:hover { background: #c2410c; }

    .tables-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem; }
    @media (max-width: 1024px) { .tables-grid { grid-template-columns: 1fr; } }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: 0.75rem 1rem; font-size: 0.75rem; text-transform: uppercase; color: #6b7280; border-bottom: 1px solid #e5e7eb; background: #f9fafb; }
    .data-table td { padding: 1rem; font-size: 0.875rem; color: #374151; border-bottom: 1px solid #e5e7eb; }
    .data-table tr:last-child td { border-bottom: none; }
    .btn-outline { border: 1px solid #d1d5db; color: #374151; padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.75rem; font-weight: 500; text-decoration: none; transition: all 0.2s; }
    .btn-outline:hover { background: #f9fafb; border-color: #9ca3af; }

    .timeline { position: relative; padding-left: 1.5rem; margin: 0; list-style: none; }
    .timeline::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 2px; background: #e5e7eb; }
    .timeline-item { position: relative; padding-bottom: 1.5rem; }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-dot { position: absolute; left: -1.8rem; top: 0.25rem; width: 12px; height: 12px; border-radius: 50%; background: #0f766e; border: 2px solid #fff; }
    .timeline-time { font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem; }
    .timeline-text { font-size: 0.875rem; color: #374151; }

    .quick-actions { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem; }
    @media (max-width: 768px) { .quick-actions { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .quick-actions { grid-template-columns: 1fr; } }
    .action-card { background: var(--teal-50); border: 1px solid #ccfbf1; border-radius: 12px; padding: 1.5rem; text-align: center; text-decoration: none; color: var(--teal-700); transition: all 0.2s; }
    .action-card:hover { background: #ccfbf1; transform: translateY(-2px); }
    .action-icon { font-size: 2rem; margin-bottom: 0.5rem; }
    .action-title { font-size: 0.875rem; font-weight: 600; }

    .status-badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; }
    .badge-today { background: #fef3c7; color: #b45309; }
    .badge-tomorrow { background: #e0e7ff; color: #4338ca; }
    .badge-future { background: #dcfce7; color: #166534; }
</style>

{{-- SECTION 1 : RINGKASAN STATISTIK --}}
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div class="kpi-content">
            <h4>Total Akseptor Aktif</h4>
            <p>{{ $totalAkseptorAktif }}</p>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
        </div>
        <div class="kpi-content">
            <h4>Pelayanan Hari Ini</h4>
            <p>{{ $pelayananHariIni }}</p>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
        <div class="kpi-content">
            <h4>Jadwal Kontrol Hari Ini</h4>
            <p>{{ $jadwalKontrolHariIni }}</p>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon orange">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="kpi-content">
            <h4>Terlambat Kontrol</h4>
            <p>{{ $akseptorTerlambat }}</p>
        </div>
    </div>
</div>

{{-- SECTION 5 : REMINDER AKSEPTOR TERLAMBAT --}}
@if($akseptorTerlambat > 0)
<div class="late-reminder">
    <div class="late-header">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        ⚠ {{ $akseptorTerlambat }} Akseptor Terlambat Kontrol
    </div>
    <ul class="late-list">
        @foreach($daftarAkseptorTerlambat as $late)
            <li>
                <span>{{ $late->acceptor->full_name ?? $late->akseptor_name }} ({{ $late->service_method }})</span>
                <span>Jadwal: {{ $late->follow_up_date->format('d M Y') }}</span>
            </li>
        @endforeach
    </ul>
    <a href="{{ route('followups.index') }}" class="btn-orange">Lihat Detail</a>
</div>
@endif

{{-- SECTION 8 : QUICK ACTION --}}
<h3 class="text-lg font-bold text-gray-900 mb-4" style="margin-bottom:1rem; font-size:1.125rem; font-weight:700; color:#111827;">Aksi Cepat</h3>
<div class="quick-actions">
    <a href="{{ route('kb-acceptors.create') }}" class="action-card flex flex-col items-center justify-center">
        <div class="action-icon text-teal-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
        </div>
        <div class="action-title">Tambah Akseptor KB</div>
    </a>
    <a href="{{ route('kb-services.create') }}" class="action-card flex flex-col items-center justify-center">
        <div class="action-icon text-teal-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <div class="action-title">Input Pelayanan KB</div>
    </a>
    <a href="{{ route('followups.index') }}" class="action-card flex flex-col items-center justify-center">
        <div class="action-icon text-teal-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
        <div class="action-title">Jadwalkan Kontrol</div>
    </a>
    <a href="{{ route('kb-services.index') }}" class="action-card flex flex-col items-center justify-center">
        <div class="action-icon text-teal-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
        </div>
        <div class="action-title">Riwayat Pelayanan</div>
    </a>
    <a href="{{ route('reports.index') }}" class="action-card flex flex-col items-center justify-center">
        <div class="action-icon text-teal-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        </div>
        <div class="action-title">Cetak Laporan</div>
    </a>

</div>

{{-- SECTION 2 & 3 : CHARTS --}}
<div class="charts-grid">
    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title">Grafik Pelayanan KB Bulanan</h3>
        </div>
        <div style="height: 250px;">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title">Distribusi Metode KB</h3>
        </div>
        <div style="height: 250px;">
            <canvas id="methodDonutChart"></canvas>
        </div>
    </div>
</div>

{{-- SECTION 4 & 6 : JADWAL KONTROL & AKTIVITAS --}}
<div class="tables-grid">
    <!-- Jadwal Kontrol Terdekat -->
    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title">Jadwal Kontrol Terdekat</h3>
            <a href="{{ route('followups.index') }}" class="btn-outline">Lihat Semua</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama Akseptor</th>
                    <th>Metode KB</th>
                    <th>Tanggal Kontrol</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwalKontrolTerdekat as $jadwal)
                    @php
                        $diff = \Carbon\Carbon::today()->diffInDays($jadwal->follow_up_date, false);
                        if ($diff == 0) {
                            $statusLabel = 'Hari Ini';
                            $statusClass = 'badge-today';
                        } elseif ($diff == 1) {
                            $statusLabel = 'Besok';
                            $statusClass = 'badge-tomorrow';
                        } else {
                            $statusLabel = $diff . ' Hari Lagi';
                            $statusClass = 'badge-future';
                        }
                    @endphp
                    <tr>
                        <td style="font-weight:500; color:#111827;">{{ $jadwal->acceptor->full_name ?? $jadwal->akseptor_name }}</td>
                        <td>{{ $jadwal->service_method }}</td>
                        <td>{{ $jadwal->follow_up_date->format('d M Y') }}</td>
                        <td><span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; color:#6b7280; padding:1rem;">Tidak ada jadwal kontrol terdekat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Aktivitas Terbaru & Status Akseptor -->
    <div style="display:flex; flex-direction:column; gap:1.5rem;">
        <!-- SECTION 7: Status Akseptor -->
        <div class="panel">
            <div class="panel-header">
                <h3 class="panel-title">Status Akseptor</h3>
            </div>
            <div style="height: 200px;">
                <canvas id="statusDonutChart"></canvas>
            </div>
        </div>

        <!-- SECTION 6: Aktivitas Terbaru -->
        <div class="panel" style="flex:1;">
            <div class="panel-header">
                <h3 class="panel-title">Aktivitas Terbaru</h3>
            </div>
            <ul class="timeline">
                @forelse($recentActivities as $activity)
                    <li class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-time">{{ $activity['time']->format('H:i - d M Y') }}</div>
                        <div class="timeline-text">{{ $activity['text'] }}</div>
                    </li>
                @empty
                    <li style="color:#6b7280; font-size:0.875rem;">Belum ada aktivitas.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Shared Options
    const chartDefaults = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } }
        }
    };

    // 1. Grafik Pelayanan KB Bulanan (Bar Chart)
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyServicesLabels) !!},
            datasets: [{
                label: 'Jumlah Pelayanan',
                data: {!! json_encode($monthlyServicesData) !!},
                backgroundColor: '#0d9488',
                borderRadius: 4
            }]
        },
        options: {
            ...chartDefaults,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Distribusi Metode KB (Donut Chart)
    new Chart(document.getElementById('methodDonutChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($methodLabels) !!},
            datasets: [{
                data: {!! json_encode($methodCounts) !!},
                backgroundColor: ['#0f766e', '#0ea5e9', '#8b5cf6', '#ec4899', '#f59e0b', '#10b981'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            ...chartDefaults,
            cutout: '65%'
        }
    });

    // 3. Status Akseptor (Donut Chart)
    new Chart(document.getElementById('statusDonutChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statusLabels) !!},
            datasets: [{
                data: {!! json_encode($statusCounts) !!},
                backgroundColor: ['#10b981', '#6b7280', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            ...chartDefaults,
            cutout: '60%'
        }
    });
});
</script>

@endsection
