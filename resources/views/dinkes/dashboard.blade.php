@extends('layouts.dashboard')

@section('title', 'Dashboard Dinkes - SatuKIA')
@section('page_title', 'Dashboard Eksekutif Dinkes')
@section('page_subtitle', 'Pemantauan Indikator Utama Layanan Ibu Hamil, Bayi & KB')

@section('content')
    <!-- Welcome Banner -->
    <div class="bg-teal-700 rounded-3xl p-8 mb-8 text-white relative overflow-hidden shadow-lg">
        <div class="relative z-10">
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, Tim Dinas Kesehatan!</h2>
            <p class="text-teal-100 max-w-2xl text-sm leading-relaxed">
                Pantau rekapitulasi data layanan Ibu Hamil, Gizi & Imunisasi Bayi, serta Akseptor KB di seluruh wilayah secara real-time.
            </p>
        </div>
        <!-- Decorative shapes -->
        <div class="absolute right-0 top-0 w-64 h-64 bg-teal-600/50 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="absolute right-32 bottom-0 w-48 h-48 bg-teal-800/50 rounded-full blur-2xl -mb-10"></div>
    </div>

    <!-- Stats Cards - Ibu Hamil -->
    <h3 class="text-lg font-bold text-slate-800 mb-4">Indikator Ibu Hamil</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Total Ibu Hamil Terdaftar -->
        <a href="{{ route('dinkes.laporan') }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-cyan-400 transition-all hover:-translate-y-1 hover:shadow-md group">
            <div class="w-12 h-12 bg-cyan-50 rounded-xl flex items-center justify-center text-cyan-600 mb-6 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $totalIbuHamil ?? 0 }}</h3>
                <p class="text-slate-500 font-medium text-sm group-hover:text-cyan-600 transition-colors">Total Ibu Hamil Terdaftar</p>
            </div>
        </a>

        <!-- Card 2: Ibu Hamil Berisiko -->
        <a href="{{ route('dinkes.laporan', ['risiko' => 'tinggi']) }}" class="block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden border-t-4 border-t-rose-400 transition-all hover:-translate-y-1 hover:shadow-md group">
            <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500 mb-6 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $ibuHamilBerisiko ?? 0 }}</h3>
                <p class="text-slate-500 font-medium text-sm group-hover:text-rose-600 transition-colors">Ibu Hamil Berisiko Tinggi</p>
            </div>
        </a>

        <!-- Card 3: Ibu Hamil Meninggal -->
        <div class="bg-slate-800 rounded-3xl p-6 shadow-sm relative overflow-hidden transition-all hover:-translate-y-1 hover:shadow-md group">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-slate-700/80 rounded-xl flex items-center justify-center text-rose-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4M12 4v16" />
                    </svg>
                </div>
                <p class="text-white font-bold text-sm uppercase tracking-wider">Ibu Hamil Meninggal</p>
            </div>
            <div>
                <h3 class="text-4xl font-extrabold text-white mb-1">{{ $ibuHamilMeninggal ?? 0 }} <span class="text-sm font-medium text-slate-400 lowercase">pasien</span></h3>
            </div>
            
            @if(isset($ibuHamilMeninggalList) && $ibuHamilMeninggalList->count() > 0)
            <div class="mt-4 pt-4 border-t border-slate-700">
                <p class="text-xs text-slate-400 mb-2">Daftar Pasien:</p>
                <ul class="text-sm text-white space-y-1">
                    @foreach($ibuHamilMeninggalList as $meninggal)
                        <li class="flex items-center gap-2 truncate">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 flex-shrink-0"></span>
                            <span class="truncate">{{ $meninggal->nama_lengkap }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @else
            <div class="mt-4 pt-4 border-t border-slate-700">
                <p class="text-xs text-slate-500 italic">Belum ada data pasien.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Stats Cards - Anak & Bayi -->
    <h3 class="text-lg font-bold text-slate-800 mb-4">Indikator Anak & Bayi</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative border-t-4 border-t-emerald-400 hover:-translate-y-1 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform">
                <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $totalAnak ?? 0 }}</h3>
            <p class="text-slate-500 font-medium text-sm group-hover:text-emerald-600 transition-colors">Total Bayi Terdaftar</p>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative border-t-4 border-t-orange-400 hover:-translate-y-1 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600 mb-6 group-hover:scale-110 transition-transform">
                <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
            </div>
            <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $anakBerisiko ?? 0 }}</h3>
            <p class="text-slate-500 font-medium text-sm group-hover:text-orange-600 transition-colors">Bayi Berisiko (Stunting/Gizi)</p>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative border-t-4 border-t-blue-400 hover:-translate-y-1 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 transition-transform">
                <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor"><path d="M11 2v4h2V2h-2zm0 14h2v6h-2v-6zm3-11v2h2v2h-2v2h2v2h-2v2h2v2h-2v2h4V5h-4zm-8 4v2h2V9H6zm0 4v2h2v-2H6z"/></svg>
            </div>
            <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $persentaseImunisasi ?? 0 }}%</h3>
            <p class="text-slate-500 font-medium text-sm group-hover:text-blue-600 transition-colors">Cakupan Imunisasi</p>
        </div>
    </div>

    <!-- Stats Cards - Keluarga Berencana (KB) -->
    <h3 class="text-lg font-bold text-slate-800 mb-4">Indikator Keluarga Berencana (KB)</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative border-t-4 border-t-purple-400 hover:-translate-y-1 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 mb-6 group-hover:scale-110 transition-transform">
                <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $totalAkseptor ?? 0 }}</h3>
            <p class="text-slate-500 font-medium text-sm group-hover:text-purple-600 transition-colors">Total Akseptor KB</p>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative border-t-4 border-t-pink-400 hover:-translate-y-1 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-pink-50 rounded-xl flex items-center justify-center text-pink-600 mb-6 group-hover:scale-110 transition-transform">
                <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
            </div>
            <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $akseptorAktif ?? 0 }}</h3>
            <p class="text-slate-500 font-medium text-sm group-hover:text-pink-600 transition-colors">Akseptor KB Aktif</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Chart Risiko Kehamilan -->
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 flex flex-col">
            <h3 class="text-lg font-bold text-slate-800 mb-1">Risiko Kehamilan</h3>
            <p class="text-[11px] text-slate-500 mb-6">Distribusi berdasarkan data pemeriksaan terakhir.</p>
            <div class="flex-grow relative w-full min-h-[200px]">
                <canvas id="risikoKehamilanChart"></canvas>
            </div>
        </div>

        <!-- Chart Status Risiko Bayi -->
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 flex flex-col">
            <h3 class="text-lg font-bold text-slate-800 mb-1">Status Gizi & Risiko Bayi</h3>
            <p class="text-[11px] text-slate-500 mb-6">Distribusi bayi normal vs bayi yang memerlukan perhatian.</p>
            <div class="flex-grow relative w-full min-h-[200px]">
                <canvas id="statusBayiChart"></canvas>
            </div>
        </div>

        <!-- Chart Status Akseptor KB -->
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 flex flex-col">
            <h3 class="text-lg font-bold text-slate-800 mb-1">Status Akseptor KB</h3>
            <p class="text-[11px] text-slate-500 mb-6">Distribusi status keaktifan akseptor KB di seluruh faskes.</p>
            <div class="flex-grow relative w-full min-h-[200px]">
                <canvas id="statusKbChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Inbox Laporan Section -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 mb-8 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Inbox Laporan Periodik (Anak)</h3>
                <p class="text-sm text-slate-500">Daftar laporan rekapitulasi yang dikirimkan oleh Bidan Puskesmas/Posyandu.</p>
            </div>
        </div>

        @if(isset($laporanDinkes) && $laporanDinkes->isEmpty())
            <div class="text-center p-12 text-slate-500">
                <svg viewBox="0 0 24 24" class="w-12 h-12 fill-slate-300 mx-auto mb-3"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h-2v5H6v2h2v5h2v-5h2v-2z"/></svg>
                <p class="text-sm font-semibold mb-1">Belum Ada Laporan Masuk</p>
                <p class="text-xs">Laporan dari Bidan akan muncul di sini setelah di-submit.</p>
            </div>
        @elseif(isset($laporanDinkes))
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="p-4 text-xs font-semibold uppercase text-slate-500 border-b border-slate-100">Tanggal Submit</th>
                            <th class="p-4 text-xs font-semibold uppercase text-slate-500 border-b border-slate-100">Asal Puskesmas</th>
                            <th class="p-4 text-xs font-semibold uppercase text-slate-500 border-b border-slate-100">Bidan Pengirim</th>
                            <th class="p-4 text-xs font-semibold uppercase text-slate-500 border-b border-slate-100">Periode Laporan</th>
                            <th class="p-4 text-xs font-semibold uppercase text-slate-500 border-b border-slate-100">Status</th>
                            <th class="p-4 text-xs font-semibold uppercase text-slate-500 border-b border-slate-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporanDinkes as $lap)
                            <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                                <td class="p-4 text-sm font-medium text-slate-800">
                                    {{ $lap->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="p-4 text-sm font-bold text-teal-600">
                                    {{ $lap->nama_puskesmas }}
                                </td>
                                <td class="p-4 text-sm text-slate-600">
                                    {{ $lap->bidan->name ?? 'Bidan' }}
                                </td>
                                <td class="p-4 text-sm text-slate-600">
                                    {{ \Carbon\Carbon::parse($lap->periode_awal)->format('d M Y') }} - {{ \Carbon\Carbon::parse($lap->periode_akhir)->format('d M Y') }}
                                </td>
                                <td class="p-4">
                                    <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-md text-xs font-semibold uppercase">{{ $lap->status }}</span>
                                </td>
                                <td class="p-4">
                                    <a href="{{ route('dinkes.laporan.show', $lap->id) }}" class="px-3 py-1.5 bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold hover:bg-slate-200 transition-colors">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('risikoKehamilanChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Rendah', 'Sedang', 'Tinggi', 'Sangat Tinggi'],
                datasets: [{
                    label: 'Jumlah Ibu Hamil',
                    data: [{{ $risikoRendah ?? 0 }}, 0, {{ $risikoTinggi ?? 0 }}, {{ $risikoSangatTinggi ?? 0 }}], // Data Asli dari DB (Kategori 'Sedang' tidak ada di DB)
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Emerald-500 (Rendah)
                        'rgba(245, 158, 11, 0.8)',  // Amber-500 (Sedang)
                        'rgba(244, 63, 94, 0.8)',   // Rose-500 (Tinggi)
                        'rgba(159, 18, 57, 0.8)'    // Rose-900 (Sangat Tinggi)
                    ],
                    borderColor: [
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(244, 63, 94)',
                        'rgb(159, 18, 57)'
                    ],
                    borderWidth: 1,
                    borderRadius: 8,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { size: 13, family: "'Inter', sans-serif" },
                        bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false,
                        },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 12 },
                            color: '#64748b'
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

        // Chart Status Bayi (Pie Chart)
        const ctxBayi = document.getElementById('statusBayiChart').getContext('2d');
        new Chart(ctxBayi, {
            type: 'pie',
            data: {
                labels: ['Normal', 'Beresiko'],
                datasets: [{
                    data: [{{ $anakNormal ?? 0 }}, {{ $anakBerisiko ?? 0 }}],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Emerald-500 (Normal)
                        'rgba(244, 63, 94, 0.8)'    // Rose-500 (Beresiko)
                    ],
                    borderColor: [
                        '#ffffff',
                        '#ffffff'
                    ],
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { family: "'Inter', sans-serif", size: 12 },
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { size: 13, family: "'Inter', sans-serif" },
                        bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
                        padding: 12,
                        cornerRadius: 8,
                    }
                }
            }
        });

        // Chart Status Akseptor KB (Doughnut Chart)
        const ctxKb = document.getElementById('statusKbChart').getContext('2d');
        new Chart(ctxKb, {
            type: 'doughnut',
            data: {
                labels: ['Aktif', 'Menunggu Verifikasi', 'Tidak Aktif / Drop Out'],
                datasets: [{
                    data: [{{ $akseptorAktif ?? 0 }}, {{ $kbPending ?? 0 }}, {{ $kbInactive ?? 0 }}],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Emerald-500 (Aktif)
                        'rgba(245, 158, 11, 0.8)',  // Amber-500 (Pending)
                        'rgba(100, 116, 139, 0.8)'  // Slate-500 (Inactive)
                    ],
                    borderColor: [
                        '#ffffff',
                        '#ffffff',
                        '#ffffff'
                    ],
                    borderWidth: 2,
                    cutout: '65%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { family: "'Inter', sans-serif", size: 12 },
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { size: 13, family: "'Inter', sans-serif" },
                        bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
                        padding: 12,
                        cornerRadius: 8,
                    }
                }
            }
        });
    });
</script>
@endpush

