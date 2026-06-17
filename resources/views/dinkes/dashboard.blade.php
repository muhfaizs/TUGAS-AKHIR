@extends('layouts.dashboard')

@section('title', 'Dashboard Dinkes - SatuKIA')
@section('page_title', 'Dashboard Eksekutif Dinkes')
@section('page_subtitle', 'Pemantauan Indikator Utama Layanan Ibu Hamil')

@section('content')
    <!-- Welcome Banner -->
    <div class="bg-teal-700 rounded-3xl p-8 mb-8 text-white relative overflow-hidden shadow-lg">
        <div class="relative z-10">
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, Tim Dinas Kesehatan! ðŸ‘‹</h2>
            <p class="text-teal-100 max-w-2xl text-sm leading-relaxed">
                Pantau data rekapitulasi ibu hamil dan tingkat risiko kehamilan secara real-time.
            </p>
        </div>
        <!-- Decorative shapes -->
        <div class="absolute right-0 top-0 w-64 h-64 bg-teal-600/50 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="absolute right-32 bottom-0 w-48 h-48 bg-teal-800/50 rounded-full blur-2xl -mb-10"></div>
    </div>

    <!-- Stats Cards -->
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

    <!-- Chart Section -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 mb-8">
        <h3 class="text-lg font-bold text-slate-800 mb-1">Distribusi Tingkat Risiko Kehamilan</h3>
        <p class="text-sm text-slate-500 mb-6">Berdasarkan data pemeriksaan terakhir yang dilaporkan oleh Bidan.</p>
        
        <!-- Chart Canvas -->
        <div class="w-full h-80 relative">
            <canvas id="risikoKehamilanChart"></canvas>
        </div>
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
                        display: false // Sembunyikan legend karena sudah jelas dari label sumbu X
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
    });
</script>
@endpush

