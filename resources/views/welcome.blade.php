<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SatuKIA - Monitoring Kesehatan Ibu & Anak Lebih Cerdas</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .hero-gradient {
            background: radial-gradient(circle at top right, #e0f2fe 0%, #f0fdf4 50%, #f8fafc 100%);
        }
        .text-brand-dark {
            color: #0f172a;
        }
        .text-brand-teal {
            color: #0d9488;
        }
        .bg-brand-teal {
            background-color: #0d9488;
        }
        .bg-brand-teal-light {
            background-color: #14b8a6;
        }
        .shadow-soft {
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05);
        }
        .shadow-glow {
            box-shadow: 0 10px 40px -10px rgba(13, 148, 136, 0.4);
        }
        .bg-brand-gradient {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="antialiased text-slate-600 min-h-screen relative overflow-x-hidden selection:bg-teal-200 selection:text-teal-900">
    
    <!-- Navbar -->
    <nav class="w-full bg-white/80 backdrop-blur-xl sticky top-0 z-50 border-b border-slate-200/50 transition-all">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-brand-gradient rounded-[0.8rem] flex items-center justify-center text-white font-extrabold text-lg shadow-sm">
                    SK
                </div>
                <span class="text-[1.35rem] font-extrabold tracking-tight text-brand-dark">SatuKIA</span>
            </div>
            <div class="flex items-center gap-6">
                <a href="#fitur" class="hidden md:block text-sm font-semibold text-slate-500 hover:text-brand-teal transition-colors">Fitur</a>
                <a href="#cara-kerja" class="hidden md:block text-sm font-semibold text-slate-500 hover:text-brand-teal transition-colors">Cara Kerja</a>
                <a href="/login" class="text-sm font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 px-5 py-2.5 rounded-full transition-colors border border-teal-100">Masuk Akun</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient pt-16 pb-32 relative z-10 overflow-hidden">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                
                <!-- Left Column: Content -->
                <div class="lg:col-span-6 relative z-10">
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white border border-slate-200 shadow-sm mb-8">
                        <span class="relative flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-teal-500"></span>
                        </span>
                        <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Platform KIA Digital Terpadu</span>
                    </div>

                    <h1 class="text-[3.5rem] lg:text-[4.5rem] font-extrabold text-brand-dark leading-[1.05] mb-6 tracking-tight">
                        Monitoring<br />
                        Pintar<br />
                        Kesehatan<br />
                        Ibu & Anak.
                    </h1>

                    <p class="text-xl text-slate-500 mb-10 leading-relaxed max-w-xl font-medium">
                        SatuKIA mengintegrasikan layanan Keluarga Berencana (KB), Pemantauan Kehamilan, dan Tumbuh Kembang Bayi dalam satu platform digital yang Aman dan Terukur.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <a href="/login" class="w-full sm:w-auto bg-brand-teal hover:bg-brand-teal-light text-white font-bold px-8 py-4 rounded-full shadow-glow transition-all flex items-center justify-center gap-2 hover:-translate-y-1">
                            Mulai Sekarang
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        <a href="#fitur" class="w-full sm:w-auto bg-white hover:bg-slate-50 text-brand-dark font-bold px-8 py-4 rounded-full border-2 border-slate-200 shadow-sm transition-all hover:-translate-y-1 flex justify-center">
                            Lihat Fitur
                        </a>
                    </div>
                    
                    <!-- Small Stats -->
                    <div class="mt-12 flex items-center gap-10 text-sm">
                        <div>
                            <p class="font-extrabold text-3xl text-brand-dark tracking-tight">24/7</p>
                            <p class="text-slate-500 font-medium mt-1">Monitoring Aktif</p>
                        </div>
                        <div class="w-px h-12 bg-slate-200"></div>
                        <div>
                            <p class="font-extrabold text-3xl text-brand-dark tracking-tight">1 Klik</p>
                            <p class="text-slate-500 font-medium mt-1">Laporan Aman</p>
                        </div>
                        <div class="w-px h-12 bg-slate-200"></div>
                        <div>
                            <p class="font-extrabold text-3xl text-brand-dark tracking-tight">100%</p>
                            <p class="text-slate-500 font-medium mt-1">Aman & Rahasia</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Illustration -->
                <div class="lg:col-span-6 relative w-full h-[550px] lg:h-[650px] flex items-center justify-center mt-12 lg:mt-0">
                    <!-- Background aesthetic blob -->
                    <div class="absolute w-[120%] h-[120%] bg-gradient-to-tr from-teal-100 to-green-50 rounded-full blur-3xl -z-10 opacity-70"></div>
                    
                    <a href="/login" class="w-[90%] z-10 block cursor-pointer">
                        <img src="/images/hero_illustration.png" alt="Ilustrasi Ibu dan Anak" class="w-full object-contain drop-shadow-2xl rounded-[3rem] transition-transform duration-700 hover:scale-[1.02]" />
                    </a>

                    <!-- Floating Cards -->
                    <div class="absolute top-8 -left-4 lg:left-0 glass-card rounded-[1.5rem] p-4 shadow-soft flex items-center gap-4 z-20 animate-[bounce_4s_infinite_alternate]">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl shadow-sm">🤰</div>
                        <div class="pr-4">
                            <p class="font-bold text-slate-800 text-sm">Pemeriksaan ANC</p>
                            <p class="text-xs font-medium text-slate-500">Kunjungan ke-3 selesai</p>
                        </div>
                    </div>
                    
                    <div class="absolute bottom-32 -left-8 lg:-left-12 glass-card rounded-[1.5rem] p-4 shadow-soft flex items-center gap-4 z-20 animate-[bounce_5s_infinite_alternate_reverse]">
                        <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center text-xl shadow-sm">👶</div>
                        <div class="pr-4">
                            <p class="font-bold text-slate-800 text-sm">Tumbuh Kembang</p>
                            <p class="text-xs font-medium text-slate-500">12 bayi terpantau</p>
                        </div>
                    </div>
                    
                    <div class="absolute bottom-8 -right-4 lg:right-4 glass-card rounded-[1.5rem] p-4 shadow-soft flex items-center gap-4 z-20 animate-[bounce_6s_infinite_alternate]">
                        <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center text-xl shadow-sm">💊</div>
                        <div class="pr-4">
                            <p class="font-bold text-slate-800 text-sm">Peserta KB Aktif</p>
                            <p class="text-xs font-medium text-slate-500">+15 akseptor baru</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted By -->
    <section class="py-12 bg-white border-y border-slate-200">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-8">Dipercaya oleh institusi kesehatan di seluruh Indonesia</p>
            <div class="flex flex-wrap justify-center items-center gap-x-16 gap-y-8 opacity-60 grayscale hover:grayscale-0 transition-all duration-700">
                <div class="flex items-center gap-3 text-slate-600 font-bold text-lg"><span class="text-2xl">🏥</span> Puskesmas</div>
                <div class="flex items-center gap-3 text-slate-600 font-bold text-lg"><span class="text-2xl">🏡</span> Posyandu</div>
                <div class="flex items-center gap-3 text-slate-600 font-bold text-lg"><span class="text-2xl">👩‍⚕️</span> Ikatan Bidan</div>
                <div class="flex items-center gap-3 text-slate-600 font-bold text-lg"><span class="text-2xl">🏢</span> Dinas Kesehatan</div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-32 bg-slate-50 relative">
        <!-- Background elements -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-teal-50 rounded-full blur-3xl -z-10 translate-x-1/3 -translate-y-1/3"></div>
        
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <p class="text-sm font-bold text-brand-teal uppercase tracking-[0.2em] mb-4">Fitur Unggulan</p>
                <h2 class="text-4xl md:text-5xl font-extrabold text-brand-dark mb-6 tracking-tight">Tiga Modul Terpadu Dalam Satu Platform</h2>
                <p class="text-xl text-slate-500 font-medium">Layanan KB, pemantauan kehamilan, dan monitoring bayi terintegrasi dari posyandu hingga puskesmas.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-10 rounded-[2rem] shadow-sm border border-slate-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-[1.2rem] flex items-center justify-center text-2xl mb-6 group-hover:scale-110 group-hover:bg-rose-500 group-hover:text-white transition-all duration-300">❤️</div>
                    <h3 class="text-2xl font-bold text-brand-dark mb-3">Keluarga Berencana</h3>
                    <p class="text-slate-500 leading-relaxed font-medium">Kelola data akseptor KB, pencatatan metode kontrasepsi, dan jadwal kunjungan ulang secara digital dan otomatis.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white p-10 rounded-[2rem] shadow-sm border border-slate-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-[1.2rem] flex items-center justify-center text-2xl mb-6 group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">📋</div>
                    <h3 class="text-2xl font-bold text-brand-dark mb-3">Pemantauan Kehamilan</h3>
                    <p class="text-slate-500 leading-relaxed font-medium">Pantau kesehatan ibu hamil dari trimester pertama hingga persalinan, termasuk jadwal ANC dan grafik evaluasi.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white p-10 rounded-[2rem] shadow-sm border border-slate-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-[1.2rem] flex items-center justify-center text-2xl mb-6 group-hover:scale-110 group-hover:bg-orange-500 group-hover:text-white transition-all duration-300">👶</div>
                    <h3 class="text-2xl font-bold text-brand-dark mb-3">Tumbuh Kembang Bayi</h3>
                    <p class="text-slate-500 leading-relaxed font-medium">Catat berat badan, tinggi badan, lingkar kepala, dan jadwal imunisasi bayi yang disinkronkan dengan standar WHO.</p>
                </div>
                <!-- Feature 4 -->
                <div class="bg-white p-10 rounded-[2rem] shadow-sm border border-slate-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-[1.2rem] flex items-center justify-center text-2xl mb-6 group-hover:scale-110 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300">📊</div>
                    <h3 class="text-2xl font-bold text-brand-dark mb-3">Laporan Terpadu</h3>
                    <p class="text-slate-500 leading-relaxed font-medium">Rangkuman data KIA tersedia secara real-time dan siap diunduh untuk kebutuhan pelaporan ke dinas kesehatan.</p>
                </div>
                <!-- Feature 5 -->
                <div class="bg-white p-10 rounded-[2rem] shadow-sm border border-slate-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-purple-50 text-purple-500 rounded-[1.2rem] flex items-center justify-center text-2xl mb-6 group-hover:scale-110 group-hover:bg-purple-500 group-hover:text-white transition-all duration-300">🔒</div>
                    <h3 class="text-2xl font-bold text-brand-dark mb-3">Akses Bertingkat</h3>
                    <p class="text-slate-500 leading-relaxed font-medium">Hak akses terstruktur untuk kader, bidan, admin puskesmas, dan ibu hamil. Menjamin privasi dan keamanan data.</p>
                </div>
                <!-- Feature 6 -->
                <div class="bg-white p-10 rounded-[2rem] shadow-sm border border-slate-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-brand-teal/10 text-brand-teal rounded-[1.2rem] flex items-center justify-center text-2xl mb-6 group-hover:scale-110 group-hover:bg-brand-teal group-hover:text-white transition-all duration-300">👥</div>
                    <h3 class="text-2xl font-bold text-brand-dark mb-3">Multi-Posyandu</h3>
                    <p class="text-slate-500 leading-relaxed font-medium">Pantau dan kelola berbagai cabang posyandu di wilayah kerja puskesmas Anda melalui satu dashboard terpusat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works Section -->
    <section id="cara-kerja" class="py-32 bg-white relative overflow-hidden">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-24">
                <p class="text-sm font-bold text-brand-teal uppercase tracking-[0.2em] mb-4">Cara Kerja</p>
                <h2 class="text-4xl md:text-5xl font-extrabold text-brand-dark mb-6 tracking-tight">Mulai dalam 4 Langkah Mudah</h2>
                <p class="text-xl text-slate-500 font-medium">Proses sederhana untuk memulai digitalisasi data kesehatan ibu dan anak.</p>
            </div>

            <div class="relative">
                <!-- Connecting Line (Desktop) -->
                <div class="hidden md:block absolute top-[2.5rem] left-[12%] right-[12%] h-1 bg-gradient-to-r from-teal-100 via-teal-300 to-teal-100 rounded-full -z-10"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <!-- Step 1 -->
                    <div class="text-center group">
                        <div class="w-20 h-20 mx-auto bg-white text-teal-600 rounded-full flex items-center justify-center text-2xl font-extrabold shadow-soft mb-8 border-[6px] border-slate-50 ring-1 ring-slate-200 group-hover:bg-teal-600 group-hover:text-white group-hover:border-teal-100 transition-all duration-300">1</div>
                        <h3 class="text-xl font-bold text-brand-dark mb-3">Daftar Akun</h3>
                        <p class="text-slate-500 font-medium">Buat akun puskesmas atau posyandu Anda dengan proses verifikasi yang cepat.</p>
                    </div>
                    <!-- Step 2 -->
                    <div class="text-center group">
                        <div class="w-20 h-20 mx-auto bg-white text-teal-600 rounded-full flex items-center justify-center text-2xl font-extrabold shadow-soft mb-8 border-[6px] border-slate-50 ring-1 ring-slate-200 group-hover:bg-teal-600 group-hover:text-white group-hover:border-teal-100 transition-all duration-300">2</div>
                        <h3 class="text-xl font-bold text-brand-dark mb-3">Input Data</h3>
                        <p class="text-slate-500 font-medium">Masukkan data awal pasien dan riwayat KIA menggunakan form yang intuitif.</p>
                    </div>
                    <!-- Step 3 -->
                    <div class="text-center group">
                        <div class="w-20 h-20 mx-auto bg-white text-teal-600 rounded-full flex items-center justify-center text-2xl font-extrabold shadow-soft mb-8 border-[6px] border-slate-50 ring-1 ring-slate-200 group-hover:bg-teal-600 group-hover:text-white group-hover:border-teal-100 transition-all duration-300">3</div>
                        <h3 class="text-xl font-bold text-brand-dark mb-3">Pantau Berkala</h3>
                        <p class="text-slate-500 font-medium">Catat hasil pemeriksaan secara rutin di modul KB, kehamilan, dan bayi.</p>
                    </div>
                    <!-- Step 4 -->
                    <div class="text-center group">
                        <div class="w-20 h-20 mx-auto bg-white text-teal-600 rounded-full flex items-center justify-center text-2xl font-extrabold shadow-soft mb-8 border-[6px] border-slate-50 ring-1 ring-slate-200 group-hover:bg-teal-600 group-hover:text-white group-hover:border-teal-100 transition-all duration-300">4</div>
                        <h3 class="text-xl font-bold text-brand-dark mb-3">Lihat Laporan</h3>
                        <p class="text-slate-500 font-medium">Dapatkan grafik dan laporan terpadu untuk bahan evaluasi dan tindak lanjut.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Banner -->
    <section class="py-24 bg-brand-gradient text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center divide-x divide-white/20">
                <div class="px-4 hover:scale-105 transition-transform">
                    <p class="text-5xl md:text-6xl font-extrabold mb-3 drop-shadow-sm">0+</p>
                    <p class="text-teal-50 font-semibold text-lg tracking-wide">Posyandu Terdaftar</p>
                </div>
                <div class="px-4 hover:scale-105 transition-transform">
                    <p class="text-5xl md:text-6xl font-extrabold mb-3 drop-shadow-sm">0+</p>
                    <p class="text-teal-50 font-semibold text-lg tracking-wide">Pasien Terpantau</p>
                </div>
                <div class="px-4 hover:scale-105 transition-transform">
                    <p class="text-5xl md:text-6xl font-extrabold mb-3 drop-shadow-sm">0+</p>
                    <p class="text-teal-50 font-semibold text-lg tracking-wide">Tenaga Kesehatan</p>
                </div>
                <div class="px-4 hover:scale-105 transition-transform">
                    <p class="text-5xl md:text-6xl font-extrabold mb-3 drop-shadow-sm">99.9%</p>
                    <p class="text-teal-50 font-semibold text-lg tracking-wide">Uptime Sistem</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 bg-slate-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] p-12 md:p-20 text-center shadow-[0_20px_50px_-15px_rgba(13,148,136,0.15)] border border-teal-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-teal-50/80 rounded-full blur-3xl -z-10 translate-x-1/3 -translate-y-1/3"></div>
                <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-sky-50/80 rounded-full blur-3xl -z-10 -translate-x-1/3 translate-y-1/3"></div>
                
                <h2 class="text-4xl md:text-5xl font-extrabold text-brand-dark mb-6 tracking-tight">Siap Digitalisasi Data KIA?</h2>
                <p class="text-xl text-slate-500 mb-12 max-w-2xl mx-auto font-medium leading-relaxed">
                    Bergabung dengan ratusan puskesmas dan posyandu yang sudah menggunakan SatuKIA untuk pemantauan kesehatan ibu dan anak yang lebih baik.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/register" class="inline-block bg-brand-teal hover:bg-brand-teal-light text-white font-bold px-10 py-5 rounded-full shadow-glow transition-all hover:-translate-y-1 text-lg">
                        Daftar Puskesmas Baru
                    </a>
                    <a href="/login" class="inline-block bg-white hover:bg-slate-50 text-brand-teal border-2 border-teal-100 font-bold px-10 py-5 rounded-full shadow-sm transition-all hover:-translate-y-1 text-lg">
                        Masuk ke Akun
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-16">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-12">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-gradient rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-sm">
                        SK
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight text-brand-dark">SatuKIA</span>
                </div>
                <div class="flex gap-8 text-sm font-semibold text-slate-500">
                    <a href="#" class="hover:text-brand-teal transition-colors">Tentang Kami</a>
                    <a href="#" class="hover:text-brand-teal transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-brand-teal transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-brand-teal transition-colors">Bantuan</a>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-400 font-medium">
                <p>&copy; {{ date('Y') }} SatuKIA. Hak Cipta Dilindungi.</p>
                <p>Platform Monitoring Kesehatan Ibu & Anak Terpadu.</p>
            </div>
        </div>
    </footer>
</body>
</html>
