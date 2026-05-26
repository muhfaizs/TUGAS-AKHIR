<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — {{ config('app.name', 'SatuKIA') }}</title>
    <meta name="description" content="Masuk ke SatuKIA untuk memantau kesehatan ibu dan anak secara digital.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/login.css', 'resources/js/app.js'])
    @endif
</head>
<body class="login-page" x-data="{
    activeTab: new URLSearchParams(window.location.search).get('tab') === 'register' || '{{ old('_register') }}' ? 'register' : 'login',
    showPassword: false,
    showRegPassword: false,
    showRegConfirm: false
}">
    <!-- Animated Background -->
    <div class="lp-bg-canvas" aria-hidden="true">
        <div class="lp-orb lp-orb--1"></div>
        <div class="lp-orb lp-orb--2"></div>
        <div class="lp-orb lp-orb--3"></div>
    </div>

    <!-- Back to Home -->
    <a href="/" class="login-back" id="back-home">
        <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd"/></svg>
        Beranda
    </a>

    <!-- Login Card -->
    <div class="login-wrapper">
        <!-- Left Branding Panel -->
        <div class="login-branding">
            <div class="login-brand-header">
                <a href="/" class="login-brand-logo">
                    <div class="login-brand-mark">SK</div>
                    <div class="login-brand-name">SatuKIA</div>
                </a>

                <h1 class="login-brand-tagline">
                    Selamat Datang<br>Kembali 👋
                </h1>
                <p class="login-brand-desc">
                    Masuk untuk melanjutkan pengelolaan layanan KB, pemantauan kehamilan, dan tumbuh kembang bayi di wilayah kerja Anda.
                </p>
            </div>

            <div class="login-brand-features">
                <div class="login-feature-pill">
                    <span class="login-feature-pill-icon">🔒</span>
                    Aman & Terenkripsi
                </div>
                <div class="login-feature-pill">
                    <span class="login-feature-pill-icon">📱</span>
                    Akses Mudah
                </div>
                <div class="login-feature-pill">
                    <span class="login-feature-pill-icon">📊</span>
                    Realtime
                </div>
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="login-form-panel">
            <!-- Tab Switcher -->
            <div class="auth-tabs" id="auth-tabs">
                <button
                    type="button"
                    class="auth-tab"
                    :class="{ 'auth-tab--active': activeTab === 'login' }"
                    @click="activeTab = 'login'"
                    id="tab-login"
                >
                    Masuk
                </button>
                <button
                    type="button"
                    class="auth-tab"
                    :class="{ 'auth-tab--active': activeTab === 'register' }"
                    @click="activeTab = 'register'"
                    id="tab-register"
                >
                    Daftar Orang Tua
                </button>
                <div class="auth-tab-slider" :style="activeTab === 'login' ? 'left: 4px; width: calc(50% - 4px)' : 'left: 50%; width: calc(50% - 4px)'"></div>
            </div>

            <!-- ==================== LOGIN FORM ==================== -->
            <div x-show="activeTab === 'login'" x-transition:enter="tab-enter" x-transition:leave="tab-leave" style="display: none;">
                <div class="login-form-header">
                    <h2 class="login-form-title">Masuk ke Akun</h2>
                    <p class="login-form-subtitle">Silakan masukkan username dan kata sandi Anda.</p>
                </div>

                @if ($errors->has('username'))
                    <div class="login-errors" id="login-errors">
                        <div class="login-error-icon">
                            <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        </div>
                        <ul>
                            @foreach ($errors->get('username') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="login-form" id="login-form">
                    @csrf

                    <!-- Username -->
                    <div class="login-field-group">
                        <label for="username" class="login-label">Username</label>
                        <div class="login-input-wrap">
                            <span class="login-input-icon">
                                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </span>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                class="login-input"
                                placeholder="Masukkan username"
                                value="{{ old('username') }}"
                                required
                                autofocus
                                autocomplete="username"
                            >
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="login-field-group">
                        <label for="password" class="login-label">Kata Sandi</label>
                        <div class="login-input-wrap">
                            <span class="login-input-icon">
                                <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                            </span>
                            <input
                                :type="showPassword ? 'text' : 'password'"
                                id="password"
                                name="password"
                                class="login-input"
                                placeholder="Masukkan kata sandi"
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" class="login-password-toggle" @click="showPassword = !showPassword" aria-label="Tampilkan kata sandi">
                                <svg viewBox="0 0 24 24" x-show="!showPassword"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                                <svg viewBox="0 0 24 24" x-show="showPassword" style="display: none;"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember -->
                    <div class="login-options">
                        <label class="login-remember" for="remember">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="login-submit" id="btn-login">
                        <span>Masuk</span>
                        <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd"/></svg>
                    </button>
                </form>

                <p class="login-footer-text">
                    Belum punya akun? <button type="button" class="login-footer-link" @click="activeTab = 'register'; document.querySelector('.login-form-panel').scrollTop = 0;">Daftar sekarang</button>
                </p>
            </div>

            <!-- ==================== REGISTER FORM ==================== -->
            <div x-show="activeTab === 'register'" x-transition:enter="tab-enter" x-transition:leave="tab-leave" style="display: none;">
                <div class="login-form-header">
                    <h2 class="login-form-title">Daftar Akun Orang Tua</h2>
                    <p class="login-form-subtitle">Daftarkan akun untuk memantau tumbuh kembang anak Anda.</p>
                </div>

                @if ($errors->has('nik_ortu') || $errors->has('nama_lengkap') || $errors->has('nomor_kontak') || $errors->has('reg_username') || $errors->has('reg_password'))
                    <div class="login-errors" id="register-errors">
                        <div class="login-error-icon">
                            <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        </div>
                        <ul>
                            @foreach ($errors->get('nik_ortu') ?? [] as $e)<li>{{ $e }}</li>@endforeach
                            @foreach ($errors->get('nama_lengkap') ?? [] as $e)<li>{{ $e }}</li>@endforeach
                            @foreach ($errors->get('nomor_kontak') ?? [] as $e)<li>{{ $e }}</li>@endforeach
                            @foreach ($errors->get('reg_username') ?? [] as $e)<li>{{ $e }}</li>@endforeach
                            @foreach ($errors->get('reg_password') ?? [] as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="login-form" id="register-form">
                    @csrf
                    <input type="hidden" name="_register" value="1">

                    <!-- NIK -->
                    <div class="login-field-group">
                        <label for="nik_ortu" class="login-label">NIK (16 Digit)</label>
                        <div class="login-input-wrap">
                            <span class="login-input-icon">
                                <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zm-6-7h4v1h-4v-1zm0-2h4v1h-4V9zm0 4h4v1h-4v-1zM6 9h6v5H6V9zm1 1v3h4v-3H7zm0 5h10v1H7v-1z"/></svg>
                            </span>
                            <input
                                type="text"
                                id="nik_ortu"
                                name="nik_ortu"
                                class="login-input"
                                placeholder="3201xxxxxxxxxx"
                                value="{{ old('nik_ortu') }}"
                                required
                                maxlength="16"
                                pattern="[0-9]{16}"
                            >
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="login-field-group">
                        <label for="nama_lengkap" class="login-label">Nama Lengkap</label>
                        <div class="login-input-wrap">
                            <span class="login-input-icon">
                                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            </span>
                            <input
                                type="text"
                                id="nama_lengkap"
                                name="nama_lengkap"
                                class="login-input"
                                placeholder="Masukkan nama lengkap"
                                value="{{ old('nama_lengkap') }}"
                                required
                            >
                        </div>
                    </div>

                    <!-- Nomor Kontak -->
                    <div class="login-field-group">
                        <label for="nomor_kontak" class="login-label">Nomor Kontak</label>
                        <div class="login-input-wrap">
                            <span class="login-input-icon">
                                <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                            </span>
                            <input
                                type="tel"
                                id="nomor_kontak"
                                name="nomor_kontak"
                                class="login-input"
                                placeholder="08xxxxxxxxxx"
                                value="{{ old('nomor_kontak') }}"
                                required
                            >
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="login-field-group">
                        <label for="reg_username" class="login-label">Username</label>
                        <div class="login-input-wrap">
                            <span class="login-input-icon">
                                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                            </span>
                            <input
                                type="text"
                                id="reg_username"
                                name="reg_username"
                                class="login-input"
                                placeholder="Buat username"
                                value="{{ old('reg_username') }}"
                                required
                            >
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="login-field-group">
                        <label for="reg_password" class="login-label">Kata Sandi</label>
                        <div class="login-input-wrap">
                            <span class="login-input-icon">
                                <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                            </span>
                            <input
                                :type="showRegPassword ? 'text' : 'password'"
                                id="reg_password"
                                name="reg_password"
                                class="login-input"
                                placeholder="Minimal 8 karakter"
                                required
                                minlength="8"
                            >
                            <button type="button" class="login-password-toggle" @click="showRegPassword = !showRegPassword" aria-label="Tampilkan kata sandi">
                                <svg viewBox="0 0 24 24" x-show="!showRegPassword"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                                <svg viewBox="0 0 24 24" x-show="showRegPassword" style="display: none;"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="login-field-group">
                        <label for="reg_password_confirmation" class="login-label">Konfirmasi Kata Sandi</label>
                        <div class="login-input-wrap">
                            <span class="login-input-icon">
                                <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                            </span>
                            <input
                                :type="showRegConfirm ? 'text' : 'password'"
                                id="reg_password_confirmation"
                                name="reg_password_confirmation"
                                class="login-input"
                                placeholder="Ulangi kata sandi"
                                required
                            >
                            <button type="button" class="login-password-toggle" @click="showRegConfirm = !showRegConfirm" aria-label="Tampilkan kata sandi">
                                <svg viewBox="0 0 24 24" x-show="!showRegConfirm"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                                <svg viewBox="0 0 24 24" x-show="showRegConfirm" style="display: none;"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="login-submit login-submit--register" id="btn-register">
                        <span>Daftar Sekarang</span>
                        <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                    </button>
                </form>

                <p class="login-footer-text">
                    Sudah punya akun? <button type="button" class="login-footer-link" @click="activeTab = 'login'; document.querySelector('.login-form-panel').scrollTop = 0;">Masuk di sini</button>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
