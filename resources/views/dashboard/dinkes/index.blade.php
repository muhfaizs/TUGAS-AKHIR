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
