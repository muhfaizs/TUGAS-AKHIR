<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SatuKIA') }} — Kesehatan Ibu dan Anak</title>
    <meta name="description" content="SatuKIA: Platform m-Health terpadu untuk layanan Keluarga Berencana, pemantauan kehamilan, dan tumbuh kembang bayi. Dari posyandu ke puskesmas, data KIA dalam satu genggaman.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/welcome.css', 'resources/js/app.js'])
    @endif
</head>
<body class="landing-page">
    <!-- Animated Background -->
    <div class="lp-bg-canvas" aria-hidden="true">
        <div class="lp-orb lp-orb--1"></div>
        <div class="lp-orb lp-orb--2"></div>
        <div class="lp-orb lp-orb--3"></div>
    </div>

    <!-- Navbar -->
    <nav class="lp-navbar" id="navbar">
        <div class="lp-navbar-inner">
            <a href="/" class="lp-brand">
                <div class="lp-brand-icon" aria-hidden="true">SK</div>
                <div class="lp-brand-label"><span>Satu</span>KIA</div>
            </a>
            <div class="lp-nav-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="lp-nav-link lp-nav-link--solid">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="lp-nav-link lp-nav-link--ghost">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="lp-nav-link lp-nav-link--solid">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="lp-hero lp-container" id="hero">
        <div class="lp-hero-content">
            <div class="lp-hero-badge">
                <span class="lp-hero-badge-dot"></span>
                Platform KIA Digital Terpadu
            </div>

            <h1 class="lp-hero-title">
                Monitoring Kesehatan<br>
                <span class="lp-hero-title-accent">Ibu & Anak</span><br>
                Lebih Cerdas
            </h1>

            <p class="lp-hero-desc">
                SatuKIA mengintegrasikan layanan Keluarga Berencana (KB), pemantauan
                kehamilan, dan tumbuh kembang bayi dalam satu platform digital.
                Data mengalir dari posyandu ke puskesmas dengan aman dan terukur.
            </p>

            <div class="lp-hero-actions">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="lp-btn lp-btn--primary">
                        Mulai Sekarang
                        <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd"/></svg>
                    </a>
                @endif
                <a href="#fitur" class="lp-btn lp-btn--outline">Lihat Fitur</a>
            </div>

            <div class="lp-hero-stats">
                <div class="lp-hero-stat">
                    <span class="lp-hero-stat-value">24/7</span>
                    <span class="lp-hero-stat-label">Monitoring Aktif</span>
                </div>
                <div class="lp-hero-stat">
                    <span class="lp-hero-stat-value">1 Klik</span>
                    <span class="lp-hero-stat-label">Laporan Instan</span>
                </div>
                <div class="lp-hero-stat">
                    <span class="lp-hero-stat-value">100%</span>
                    <span class="lp-hero-stat-label">Data Aman</span>
                </div>
            </div>
        </div>

        <div class="lp-hero-visual">
            <div class="lp-hero-glow"></div>
            <div class="lp-hero-img-wrap">
                <img src="{{ asset('images/hero-illustration.png') }}" alt="Ilustrasi kesehatan ibu dan anak" loading="eager">
            </div>

            <!-- Floating Cards -->
            <div class="lp-float-card lp-float-card--1">
                <div class="lp-fc-row">
                    <div class="lp-fc-icon lp-fc-icon--teal">🤰</div>
                    <div>
                        <div class="lp-fc-text">Pemeriksaan ANC</div>
                        <div class="lp-fc-sub">Kunjungan ke-3 selesai</div>
                    </div>
                </div>
            </div>
            <div class="lp-float-card lp-float-card--2">
                <div class="lp-fc-row">
                    <div class="lp-fc-icon lp-fc-icon--coral">💊</div>
                    <div>
                        <div class="lp-fc-text">Peserta KB Aktif</div>
                        <div class="lp-fc-sub">+15 akseptor bulan ini</div>
                    </div>
                </div>
            </div>
            <div class="lp-float-card lp-float-card--3">
                <div class="lp-fc-row">
                    <div class="lp-fc-icon lp-fc-icon--amber">👶</div>
                    <div>
                        <div class="lp-fc-text">Tumbuh Kembang Bayi</div>
                        <div class="lp-fc-sub">12 bayi terpantau</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted Section -->
    <section class="lp-trusted lp-container lp-reveal">
        <p class="lp-trusted-label">Dipercaya oleh tenaga kesehatan di seluruh Indonesia</p>
        <div class="lp-trusted-logos">
            <div class="lp-trusted-logo">
                <svg viewBox="0 0 24 24"><path d="M12 2L2 7v10l10 5 10-5V7L12 2zm0 2.18l7 3.5v7.64l-7 3.5-7-3.5V7.68l7-3.5z"/></svg>
                Puskesmas
            </div>
            <div class="lp-trusted-logo">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                Posyandu
            </div>
            <div class="lp-trusted-logo">
                <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                Kader & Bidan
            </div>
            <div class="lp-trusted-logo">
                <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                Dinas Kesehatan
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="lp-section lp-container">
        <div class="lp-section-header lp-reveal">
            <p class="lp-section-kicker">Fitur Unggulan</p>
            <h2 class="lp-section-title">Tiga Modul Terpadu<br>Dalam Satu Platform</h2>
            <p class="lp-section-desc">
                Layanan KB, pemantauan kehamilan, dan monitoring bayi terintegrasi dari posyandu hingga puskesmas.
            </p>
        </div>

        <div class="lp-features-grid">
            {{-- Modul KB --}}
            <div class="lp-feature-card lp-reveal lp-reveal-delay-1">
                <div class="lp-feature-icon lp-feature-icon--2">
                    <svg viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
                <h3 class="lp-feature-title">Layanan Keluarga Berencana</h3>
                <p class="lp-feature-text">Kelola data akseptor KB, pencatatan metode kontrasepsi, dan jadwal kunjungan ulang secara digital.</p>
            </div>

            {{-- Modul Ibu Hamil --}}
            <div class="lp-feature-card lp-reveal lp-reveal-delay-2">
                <div class="lp-feature-icon lp-feature-icon--1">
                    <svg viewBox="0 0 24 24"><path d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-6 0h-4V4h4v2zm-1 10h-2v2h-2v-2H7v-2h2v-2h2v2h2v2z"/></svg>
                </div>
                <h3 class="lp-feature-title">Pemantauan Kehamilan</h3>
                <p class="lp-feature-text">Pantau kesehatan ibu hamil dari trimester pertama hingga persalinan, termasuk jadwal ANC dan riwayat pemeriksaan.</p>
            </div>

            {{-- Modul Bayi --}}
            <div class="lp-feature-card lp-reveal lp-reveal-delay-3">
                <div class="lp-feature-icon lp-feature-icon--3">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                </div>
                <h3 class="lp-feature-title">Tumbuh Kembang Bayi</h3>
                <p class="lp-feature-text">Catat berat badan, tinggi badan, lingkar kepala, dan jadwal imunisasi bayi dengan grafik pertumbuhan WHO.</p>
            </div>

            {{-- Fitur Umum --}}
            <div class="lp-feature-card lp-reveal lp-reveal-delay-1">
                <div class="lp-feature-icon lp-feature-icon--4">
                    <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                </div>
                <h3 class="lp-feature-title">Laporan Terpadu</h3>
                <p class="lp-feature-text">Rangkuman data KB, kehamilan, dan bayi tersedia otomatis untuk pelaporan ke dinas kesehatan.</p>
            </div>

            <div class="lp-feature-card lp-reveal lp-reveal-delay-2">
                <div class="lp-feature-icon lp-feature-icon--5">
                    <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                </div>
                <h3 class="lp-feature-title">Akses Bertingkat</h3>
                <p class="lp-feature-text">Role-based access untuk kader, bidan, orang tua, dan admin puskesmas. Data aman dan terkontrol.</p>
            </div>

            <div class="lp-feature-card lp-reveal lp-reveal-delay-3">
                <div class="lp-feature-icon lp-feature-icon--6">
                    <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                </div>
                <h3 class="lp-feature-title">Multi-Posyandu</h3>
                <p class="lp-feature-text">Kelola beberapa posyandu sekaligus dengan data KB, ibu hamil, dan bayi dalam satu dashboard.</p>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="lp-section lp-container">
        <div class="lp-section-header lp-reveal">
            <p class="lp-section-kicker">Cara Kerja</p>
            <h2 class="lp-section-title">Mulai dalam 4 Langkah Mudah</h2>
            <p class="lp-section-desc">Proses sederhana untuk memulai digitalisasi data kesehatan ibu dan anak.</p>
        </div>

        <div class="lp-steps-grid">
            <div class="lp-step lp-reveal lp-reveal-delay-1">
                <div class="lp-step-num">1</div>
                <h3 class="lp-step-title">Daftar Akun</h3>
                <p class="lp-step-text">Buat akun untuk puskesmas atau posyandu Anda dalam hitungan menit.</p>
            </div>
            <div class="lp-step lp-reveal lp-reveal-delay-2">
                <div class="lp-step-num">2</div>
                <h3 class="lp-step-title">Input Data KIA</h3>
                <p class="lp-step-text">Masukkan data KB, kehamilan, atau bayi melalui form yang mudah dipahami.</p>
            </div>
            <div class="lp-step lp-reveal lp-reveal-delay-3">
                <div class="lp-step-num">3</div>
                <h3 class="lp-step-title">Pantau Berkala</h3>
                <p class="lp-step-text">Catat kunjungan, pemeriksaan, dan perkembangan secara rutin di setiap modul.</p>
            </div>
            <div class="lp-step lp-reveal lp-reveal-delay-4">
                <div class="lp-step-num">4</div>
                <h3 class="lp-step-title">Lihat Laporan</h3>
                <p class="lp-step-text">Dapatkan laporan terpadu KB, ibu hamil, dan bayi untuk evaluasi serta koordinasi.</p>
            </div>
        </div>
    </section>

    <!-- Stats Banner -->
    <section class="lp-section lp-container">
        <div class="lp-stats-banner lp-reveal">
            <div class="lp-stat-item">
                <div class="lp-stat-num" data-count="500">0+</div>
                <div class="lp-stat-text">Posyandu Terdaftar</div>
            </div>
            <div class="lp-stat-item">
                <div class="lp-stat-num" data-count="10000">0+</div>
                <div class="lp-stat-text">Pasien Terpantau</div>
            </div>
            <div class="lp-stat-item">
                <div class="lp-stat-num" data-count="2000">0+</div>
                <div class="lp-stat-text">Tenaga Kesehatan</div>
            </div>
            <div class="lp-stat-item">
                <div class="lp-stat-num">99.9%</div>
                <div class="lp-stat-text">Uptime Sistem</div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="lp-cta lp-container">
        <div class="lp-cta-card lp-reveal">
            <h2 class="lp-cta-title">Siap Digitalisasi Data KIA?</h2>
            <p class="lp-cta-desc">
                Bergabung dengan ratusan puskesmas dan posyandu yang sudah menggunakan SatuKIA
                untuk pemantauan kesehatan ibu dan anak yang lebih baik.
            </p>
            <div class="lp-cta-actions">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="lp-btn lp-btn--white">Masuk Sekarang</a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="lp-btn lp-btn--ghost-white">Daftar Gratis</a>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="lp-footer lp-container">
        <span>&copy; {{ date('Y') }} SatuKIA — KB · Ibu Hamil · Bayi — Dari posyandu untuk generasi sehat <span class="lp-footer-heart">♥</span></span>
    </footer>

    <!-- Scripts -->
    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        });

        // Intersection Observer for scroll animations
        const reveals = document.querySelectorAll('.lp-reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
        reveals.forEach(el => observer.observe(el));

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(link.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    </script>
</body>
</html>
