@extends('layouts.dashboard')

@section('title', 'Orang Tua Dashboard')
@section('page_title', 'Dashboard Tumbuh Kembang')
@section('page_subtitle', 'Pantau grafik pertumbuhan KMS Digital anak Anda')

@section('content')
    <!-- Welcome Banner -->
    <div class="welcome-banner" style="background: linear-gradient(135deg, #0D9488, #0F766E); color: #fff; padding: 24px; border-radius: 20px; box-shadow: 0 10px 25px rgba(13,148,136,0.2); margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 800; margin: 0 0 8px;">Halo, {{ auth()->user()->nama_lengkap }}! 👋</h2>
        <p style="font-size: 15px; opacity: 0.9; margin: 0;">Berikut adalah KMS Digital (Kartu Menuju Sehat) untuk memantau tumbuh kembang anak Anda.</p>
    </div>

    @if ($anakList->isEmpty())
        <div style="background: #fff; padding: 40px; border-radius: 20px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div style="width: 64px; height: 64px; background: rgba(13,148,136,0.1); color: #0D9488; border-radius: 50%; display: grid; place-items: center; margin: 0 auto 16px;">
                <svg viewBox="0 0 24 24" style="width: 32px; height: 32px; fill: currentColor;"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #0F172A; margin: 0 0 8px;">Belum Ada Data Anak</h3>
            <p style="color: #64748B; font-size: 14px; margin: 0 0 24px;">Silakan daftarkan anak Anda terlebih dahulu untuk melihat grafik pertumbuhannya.</p>
            <a href="{{ route('orangtua.anak.create') }}" style="display: inline-block; padding: 10px 20px; background: #0D9488; color: #fff; border-radius: 10px; font-weight: 600; text-decoration: none;">Daftarkan Anak</a>
        </div>
    @else
        <!-- Child Selector -->
        <div style="margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <label style="font-weight: 600; color: #475569;">Pilih Anak:</label>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                @foreach ($anakList as $anak)
                    <a href="{{ route('orangtua.dashboard', ['anak_id' => $anak->id_anak]) }}" 
                       style="padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s;
                              {{ $selectedAnak->id_anak === $anak->id_anak ? 'background: #0D9488; color: #fff; box-shadow: 0 4px 12px rgba(13,148,136,0.3);' : 'background: #fff; color: #64748B; border: 1px solid #E2E8F0;' }}">
                        {{ $anak->nama_anak }}
                    </a>
                @endforeach
            </div>
        </div>

        @if ($pengukuranList->isEmpty())
            <div style="background: #fff; padding: 40px; border-radius: 20px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <p style="color: #64748B; font-size: 15px; margin: 0;">Belum ada data pengukuran (antropometri) untuk <strong>{{ $selectedAnak->nama_anak }}</strong>.</p>
            </div>
        @else
            <!-- Chart Container -->
            <div style="background: #fff; padding: 24px; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <h3 style="font-size: 18px; font-weight: 700; color: #0F172A; margin: 0 0 20px;">Grafik KMS Digital - {{ $selectedAnak->nama_anak }}</h3>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="kmsChart"></canvas>
                </div>
            </div>

            <!-- Table Riwayat -->
            <div style="margin-top: 24px; background: #fff; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden;">
                <div style="padding: 20px 24px; border-bottom: 1px solid #E2E8F0;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0;">Riwayat Pengukuran</h3>
                </div>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead style="background: #F8FAFC;">
                            <tr>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Tanggal</th>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Berat (kg)</th>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Tinggi (cm)</th>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">IMT</th>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengukuranList->reverse() as $pengukuran)
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 16px 24px; font-size: 14px; font-weight: 500; color: #334155;">{{ $pengukuran->tanggal_pengukuran->format('d M Y') }}</td>
                                    <td style="padding: 16px 24px; font-size: 14px; color: #475569;">{{ $pengukuran->berat_badan }}</td>
                                    <td style="padding: 16px 24px; font-size: 14px; color: #475569;">{{ $pengukuran->tinggi_badan }}</td>
                                    <td style="padding: 16px 24px; font-size: 14px; color: #475569;">{{ $pengukuran->imt }}</td>
                                    <td style="padding: 16px 24px;">
                                        @if($pengukuran->flag_risiko)
                                            <span style="background: rgba(239,68,68,0.1); color: #EF4444; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">Perlu Perhatian</span>
                                        @else
                                            <span style="background: rgba(16,185,129,0.1); color: #10B981; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">Normal</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Chart.js Script -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('kmsChart').getContext('2d');
                    
                    const dataPengukuran = @json($pengukuranList);
                    
                    const labels = dataPengukuran.map(item => {
                        const d = new Date(item.tanggal_pengukuran);
                        return d.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
                    });
                    
                    const beratData = dataPengukuran.map(item => item.berat_badan);
                    const tinggiData = dataPengukuran.map(item => item.tinggi_badan);
                    
                    // Point colors based on flag_risiko
                    const pointColors = dataPengukuran.map(item => item.flag_risiko ? '#EF4444' : '#10B981');
                    const pointRadii = dataPengukuran.map(item => item.flag_risiko ? 6 : 4);

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Berat Badan (kg)',
                                    data: beratData,
                                    borderColor: '#0D9488',
                                    backgroundColor: 'rgba(13,148,136,0.1)',
                                    pointBackgroundColor: pointColors,
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: pointRadii,
                                    fill: true,
                                    tension: 0.4,
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'Tinggi Badan (cm)',
                                    data: tinggiData,
                                    borderColor: '#6366F1',
                                    backgroundColor: 'transparent',
                                    pointBackgroundColor: pointColors,
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: pointRadii,
                                    borderDash: [5, 5],
                                    tension: 0.4,
                                    yAxisID: 'y1'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: { font: { family: "'Inter', sans-serif", weight: '500' } }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                    titleFont: { family: "'Inter', sans-serif" },
                                    bodyFont: { family: "'Inter', sans-serif" },
                                    padding: 12,
                                    cornerRadius: 8
                                }
                            },
                            scales: {
                                y: {
                                    type: 'linear',
                                    display: true,
                                    position: 'left',
                                    title: { display: true, text: 'Berat (kg)', font: { family: "'Inter', sans-serif", size: 12 } },
                                    grid: { color: '#F1F5F9' }
                                },
                                y1: {
                                    type: 'linear',
                                    display: true,
                                    position: 'right',
                                    title: { display: true, text: 'Tinggi (cm)', font: { family: "'Inter', sans-serif", size: 12 } },
                                    grid: { drawOnChartArea: false }
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: { font: { family: "'Inter', sans-serif" } }
                                }
                            }
                        }
                    });
                });
            </script>
        @endif
    @endif
@endsection
