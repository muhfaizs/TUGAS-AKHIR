@extends('layouts.dashboard')

@section('title', 'Dashboard Eksekutif Dinkes')
@section('page_title', 'Dashboard Eksekutif Dinkes')
@section('page_subtitle', 'Pemantauan Indikator Utama Layanan KIA & Gizi Balita')

@section('content')
    <!-- Welcome Banner -->
    <div class="welcome-banner" id="welcome-banner">
        <h2 class="welcome-title">Selamat Datang, Tim Dinas Kesehatan! 👋</h2>
        <p class="welcome-text">
            Pantau rekapitulasi data posyandu, status gizi balita, dan cakupan imunisasi di seluruh wilayah secara real-time.
        </p>
    </div>

    <!-- Summary Cards -->
    <div class="dash-grid" id="summary-cards">
        <div class="dash-card dash-card--indigo" id="card-total-posyandu">
            <div class="dash-card-header">
                <div class="dash-card-icon dash-card-icon--indigo">
                    <svg viewBox="0 0 24 24"><path d="M12 2L2 22h20L12 2zm0 3.8l6.32 12.2H5.68L12 5.8zM11 10h2v4h-2v-4zm0 6h2v2h-2v-2z"/></svg>
                </div>
            </div>
            <div class="dash-card-value">{{ $totalPosyandu }}</div>
            <div class="dash-card-label">Total Posyandu Aktif</div>
        </div>

        <div class="dash-card dash-card--teal" id="card-total-anak">
            <div class="dash-card-header">
                <div class="dash-card-icon dash-card-icon--teal">
                    <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
            </div>
            <div class="dash-card-value">{{ $totalAnak }}</div>
            <div class="dash-card-label">Total Balita Terdaftar</div>
        </div>

        <div class="dash-card dash-card--coral" id="card-anak-berisiko">
            <div class="dash-card-header">
                <div class="dash-card-icon dash-card-icon--coral">
                    <svg viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                </div>
            </div>
            <div class="dash-card-value">{{ $anakBerisiko }}</div>
            <div class="dash-card-label">Balita Berisiko (Stunting/Gizi Buruk)</div>
        </div>

        <div class="dash-card dash-card--amber" id="card-cakupan-imunisasi">
            <div class="dash-card-header">
                <div class="dash-card-icon dash-card-icon--amber">
                    <svg viewBox="0 0 24 24"><path d="M11 2v4h2V2h-2zm0 14h2v6h-2v-6zm3-11v2h2v2h-2v2h2v2h-2v2h2v2h-2v2h4V5h-4zm-8 4v2h2V9H6zm0 4v2h2v-2H6z"/></svg>
                </div>
            </div>
            <div class="dash-card-value">{{ $persentaseImunisasi }}%</div>
            <div class="dash-card-label">Cakupan Imunisasi</div>
        </div>
    </div>

    <!-- Chart Section -->
    <div style="background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(13,148,136,0.04); border: 1px solid rgba(15,23,42,0.06); padding: 32px; margin-top: 32px; margin-bottom: 32px;">
        <h3 style="font-size: 18px; font-weight: 700; color: #0F172A; margin-top: 0; margin-bottom: 8px;">Distribusi Status Gizi Anak</h3>
        <p style="font-size: 14px; color: #64748B; margin-bottom: 24px;">Berdasarkan pengukuran terakhir dari seluruh posyandu terdaftar.</p>
        
        <div style="position: relative; height: 350px; width: 100%;">
            <canvas id="giziChart"></canvas>
        </div>
    </div>

    <!-- Inbox Laporan Section -->
    <div style="background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(13,148,136,0.04); border: 1px solid rgba(15,23,42,0.06); margin-bottom: 32px; overflow: hidden;">
        <div style="padding: 24px 28px; border-bottom: 1px solid rgba(15,23,42,0.06);">
            <h3 style="font-size: 18px; font-weight: 700; color: #0F172A; margin: 0 0 4px;">Inbox Laporan Periodik</h3>
            <p style="font-size: 14px; color: #64748B; margin: 0;">Daftar laporan rekapitulasi yang dikirimkan oleh Bidan Puskesmas/Posyandu.</p>
        </div>

        @if($laporanDinkes->isEmpty())
            <div style="text-align: center; padding: 48px 24px; color: #64748B;">
                <svg viewBox="0 0 24 24" style="width: 48px; height: 48px; fill: #CBD5E1; margin: 0 auto 12px; display: block;"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h-2v5H6v2h2v5h2v-5h2v-2z"/></svg>
                <p style="font-size: 15px; font-weight: 600; margin: 0 0 4px;">Belum Ada Laporan Masuk</p>
                <p style="font-size: 13px; margin: 0;">Laporan dari Bidan akan muncul di sini setelah di-submit.</p>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 900px; text-align: left;">
                    <thead>
                        <tr>
                            <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Tanggal Submit</th>
                            <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Asal Puskesmas / Posyandu</th>
                            <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Bidan Pengirim</th>
                            <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Periode Laporan</th>
                            <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Status</th>
                            <th style="padding: 14px 24px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: #64748B; background: rgba(240,253,250,0.5); border-bottom: 1px solid rgba(15,23,42,0.06);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporanDinkes as $lap)
                            <tr style="border-bottom: 1px solid rgba(15,23,42,0.04);">
                                <td style="padding: 16px 24px; font-size: 14px; color: #0F172A; font-weight: 500;">
                                    {{ $lap->created_at->format('d M Y H:i') }}
                                </td>
                                <td style="padding: 16px 24px; font-size: 14px; font-weight: 600; color: #0D9488;">
                                    {{ $lap->nama_puskesmas }}
                                </td>
                                <td style="padding: 16px 24px; font-size: 14px; color: #475569;">
                                    {{ $lap->bidan->nama_lengkap ?? 'Bidan' }}
                                </td>
                                <td style="padding: 16px 24px; font-size: 14px; color: #475569;">
                                    {{ \Carbon\Carbon::parse($lap->periode_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($lap->periode_akhir)->format('d M Y') }}
                                </td>
                                <td style="padding: 16px 24px;">
                                    <span style="background: rgba(16, 185, 129, 0.1); color: #059669; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase;">{{ $lap->status }}</span>
                                </td>
                                <td style="padding: 16px 24px;">
                                    <button onclick="alert('Fitur Lihat Detail/Export JSON Laporan ID: {{ $lap->id }}')" style="padding: 6px 12px; background: #F1F5F9; color: #334155; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                        Lihat Detail Laporan
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('giziChart').getContext('2d');
            
            // Data from Controller
            const labels = {!! json_encode($chartLabels) !!};
            const dataCounts = {!! json_encode($chartData) !!};
            
            // Define color palette based on UI theme
            const backgroundColors = [
                'rgba(13, 148, 136, 0.7)', // Teal (Gizi Baik / Normal)
                'rgba(245, 158, 11, 0.7)', // Amber (Gizi Kurang)
                'rgba(239, 68, 68, 0.7)',  // Red (Gizi Buruk / Stunting)
                'rgba(99, 102, 241, 0.7)', // Indigo (Risiko Lebih)
                'rgba(148, 163, 184, 0.7)' // Slate (Lainnya)
            ];
            
            const borderColors = [
                'rgb(13, 148, 136)', 
                'rgb(245, 158, 11)', 
                'rgb(239, 68, 68)',  
                'rgb(99, 102, 241)', 
                'rgb(148, 163, 184)' 
            ];

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Anak',
                        data: dataCounts,
                        backgroundColor: backgroundColors.slice(0, labels.length),
                        borderColor: borderColors.slice(0, labels.length),
                        borderWidth: 1,
                        borderRadius: 6,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Hide legend for single dataset bar chart
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleFont: { size: 14, family: "'Inter', sans-serif" },
                            bodyFont: { size: 14, family: "'Inter', sans-serif" },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(15, 23, 42, 0.05)',
                                drawBorder: false,
                            },
                            ticks: {
                                font: { family: "'Inter', sans-serif", size: 12 },
                                color: '#64748B',
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                font: { family: "'Inter', sans-serif", size: 13, weight: '500' },
                                color: '#475569'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
