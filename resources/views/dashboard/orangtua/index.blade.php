@extends('layouts.dashboard')

@section('title', 'Orang Tua Dashboard')
@section('page_title', 'Dashboard Tumbuh Kembang')
@section('page_subtitle', 'Pantau grafik pertumbuhan KMS Digital anak Anda')

@section('content')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .print-area, .print-area * {
                visibility: visible;
            }
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>

    <!-- Welcome Banner -->
    <div class="welcome-banner" style="background: linear-gradient(135deg, #0D9488, #0F766E); color: #fff; padding: 24px; border-radius: 20px; box-shadow: 0 10px 25px rgba(13,148,136,0.2); margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 800; margin: 0 0 8px;">Halo, {{ auth()->user()->name }}! 👋</h2>
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
        <!-- Child Selector and Print Button -->
        <div class="no-print" style="margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <label for="select-anak" style="font-weight: 600; color: #475569;">Pilih Anak:</label>
                <select id="select-anak" onchange="window.location.href=this.value" style="padding: 10px 16px; border-radius: 12px; border: 1px solid #E2E8F0; font-size: 14px; font-weight: 600; color: #0F172A; background-color: #fff; outline: none; min-width: 200px; cursor: pointer; appearance: none; background-image: url('data:image/svg+xml;utf8,<svg viewBox=\"0 0 24 24\" fill=\"%2364748B\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>'); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px;">
                    @foreach ($anakList as $anak)
                        <option value="{{ route('dashboard', ['anak_id' => $anak->id_anak]) }}" {{ $selectedAnak->id_anak === $anak->id_anak ? 'selected' : '' }}>
                            {{ $anak->nama_anak }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div style="display: flex; gap: 8px;">
                <button onclick="window.print()" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #64748B; color: #fff; border: none; border-radius: 12px; font-weight: 600; font-size: 14px; cursor: pointer; transition: background 0.2s;">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: currentColor;"><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg>
                    Cetak Halaman
                </button>
                <a href="{{ route('orangtua.rekam-medis.pdf', $selectedAnak->id_anak) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #0F172A; color: #fff; border: none; border-radius: 12px; font-weight: 600; font-size: 14px; cursor: pointer; text-decoration: none; transition: background 0.2s;">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: currentColor;"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                    Download Rekam Medis (PDF)
                </a>
            </div>
        </div>

        @if(isset($jadwalTerdekat))
            <div class="no-print" style="margin-bottom: 24px;">
                <div style="background: rgba(13, 148, 136, 0.1); border-left: 4px solid #0D9488; padding: 16px; border-radius: 8px; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(13, 148, 136, 0.2); display: grid; place-items: center; flex-shrink: 0; color: #0D9488;">
                        <svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: currentColor;"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2zm-8 4H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z"/></svg>
                    </div>
                    <div>
                        <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F766E;">Jadwal Posyandu Terdekat: {{ $jadwalTerdekat->tanggal->format('d M Y') }}</h4>
                        <p style="margin: 4px 0 0 0; font-size: 14px; color: #115E59;">
                            Waktu: {{ \Carbon\Carbon::parse($jadwalTerdekat->waktu_mulai)->format('H:i') }} WIB | Lokasi: {{ $jadwalTerdekat->lokasi }}
                            @if($jadwalTerdekat->keterangan) <br><small>Catatan: {{ $jadwalTerdekat->keterangan }}</small> @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(!empty($pengingatList))
            <div class="no-print" style="margin-bottom: 24px;">
                @foreach($pengingatList as $pengingat)
                    <div style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #F59E0B; padding: 16px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(245, 158, 11, 0.2); display: grid; place-items: center; flex-shrink: 0; color: #D97706;">
                                <svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: currentColor;"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"/></svg>
                            </div>
                            <div>
                                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #92400E;">Pengingat Terjadwal: Imunisasi {{ $pengingat['vaksin'] }}</h4>
                                <p style="margin: 4px 0 0 0; font-size: 14px; color: #B45309;">
                                    Info Jadwal: Imunisasi <strong>{{ $pengingat['vaksin'] }}</strong> selanjutnya dijadwalkan pada <strong>{{ $pengingat['tanggal'] }}</strong>
                                    ({{ $pengingat['hari'] == 0 ? 'hari ini' : ($pengingat['hari'] > 0 ? $pengingat['hari'] . ' hari lagi' : abs($pengingat['hari']) . ' hari yang lalu') }}). 
                                    @if($pengingat['hari'] <= 7) Harap segera ke Posyandu/Puskesmas. @else Persiapkan kunjungan Anda pada tanggal tersebut. @endif
                                </p>
                            </div>
                        </div>
                        <form method="GET" action="{{ route('ortu.dismiss-pengingat') }}" style="margin: 0;">
                            @csrf
                            <input type="hidden" name="anak_id" value="{{ $pengingat['anak_id'] }}">
                            <input type="hidden" name="vaksin" value="{{ $pengingat['vaksin'] }}">
                            <button type="submit" title="Tandai sudah dibaca & pindahkan ke notifikasi" style="background: none; border: none; cursor: pointer; color: #10B981; padding: 8px; border-radius: 50%; transition: background 0.2s;" onmouseover="this.style.background='rgba(16, 185, 129, 0.1)';" onmouseout="this.style.background='none';">
                                <svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: currentColor;"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="print-area">
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

            <!-- Table Riwayat Tindakan Medis -->
            @if(isset($tindakanList) && $tindakanList->isNotEmpty())
            <div style="margin-top: 24px; background: #fff; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden;">
                <div style="padding: 20px 24px; border-bottom: 1px solid #E2E8F0;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0;">Riwayat Tindakan Medis & Diagnosa</h3>
                </div>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead style="background: #F8FAFC;">
                            <tr>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Tanggal</th>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Diagnosa</th>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Catatan & Resep</th>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Bidan</th>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tindakanList as $tindakan)
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 16px 24px; font-size: 14px; font-weight: 500; color: #334155;">{{ $tindakan->tanggal_pemeriksaan->format('d M Y') }}</td>
                                    <td style="padding: 16px 24px; font-size: 14px; color: #EF4444; font-weight: 600;">{{ $tindakan->diagnosa }}</td>
                                    <td style="padding: 16px 24px; font-size: 14px; color: #475569;">
                                        <div style="margin-bottom: 4px;"><strong>Suhu:</strong> {{ $tindakan->suhu_tubuh ?? '-' }} °C</div>
                                        <div style="margin-bottom: 4px;"><strong>Resep:</strong> {{ $tindakan->resep_obat ?? '-' }}</div>
                                        <div><strong>Catatan:</strong> {{ $tindakan->catatan_pemeriksaan }}</div>
                                    </td>
                                    <td style="padding: 16px 24px; font-size: 14px; color: #475569;">{{ $tindakan->bidan->name ?? '-' }}</td>
                                    <td style="padding: 16px 24px; text-align: center;">
                                        <a href="{{ route('orangtua.tindakan.pdf', $tindakan) }}" target="_blank" style="display: inline-block; padding: 6px 12px; background: #F1F5F9; color: #334155; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none;">Download PDF</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Table Riwayat Imunisasi -->
            @if(isset($imunisasiList) && $imunisasiList->isNotEmpty())
            <div style="margin-top: 24px; background: #fff; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden;">
                <div style="padding: 20px 24px; border-bottom: 1px solid #E2E8F0;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0;">Riwayat Imunisasi</h3>
                </div>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead style="background: #F8FAFC;">
                            <tr>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Tanggal</th>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Vaksin</th>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Detail</th>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase;">Bidan</th>
                                <th style="padding: 12px 24px; font-size: 12px; font-weight: 600; color: #64748B; text-transform: uppercase; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($imunisasiList as $imunisasi)
                                <tr style="border-bottom: 1px solid #F1F5F9;">
                                    <td style="padding: 16px 24px; font-size: 14px; font-weight: 500; color: #334155;">{{ $imunisasi->tanggal_pemberian->format('d M Y') }}</td>
                                    <td style="padding: 16px 24px; font-size: 14px; color: #0D9488; font-weight: 600;">{{ $imunisasi->nama_vaksin }}</td>
                                    <td style="padding: 16px 24px; font-size: 14px; color: #475569;">
                                        <div style="margin-bottom: 4px;"><strong>Batch:</strong> {{ $imunisasi->batch_vaksin ?? '-' }} | <strong>Suhu:</strong> {{ $imunisasi->suhu_tubuh ?? '-' }} °C</div>
                                        <div style="margin-bottom: 4px;"><strong>Lokasi:</strong> {{ $imunisasi->lokasi_suntikan ?? '-' }}</div>
                                        <div><strong>Catatan:</strong> {{ $imunisasi->catatan ?? '-' }}</div>
                                    </td>
                                    <td style="padding: 16px 24px; font-size: 14px; color: #475569;">{{ $imunisasi->bidan->name ?? '-' }}</td>
                                    <td style="padding: 16px 24px; text-align: center;">
                                        <a href="{{ route('orangtua.imunisasi.pdf', $imunisasi) }}" target="_blank" style="display: inline-block; padding: 6px 12px; background: #F1F5F9; color: #334155; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none;">Download PDF</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

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
        </div> <!-- End of print-area -->
    @endif
@endsection
