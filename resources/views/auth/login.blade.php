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

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/welcome.css', 'resources/css/login.css', 'resources/js/app.js'])
    @endif
</head>
<body class="login-page">
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


        </div>

        <!-- Right Form Panel -->
        <div class="login-form-panel">
            <div class="login-form-header">
                <h2 class="login-form-title">Masuk ke Akun</h2>
                <p class="login-form-subtitle">Silakan masukkan email dan kata sandi Anda untuk melanjutkan.</p>
            </div>

            @if ($errors->any())
                <ul class="login-errors" id="login-errors">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-form" id="login-form">
                @csrf

                <!-- Email -->
                <div class="login-field-group">
                    <label for="email" class="login-label">Email</label>
                    <div class="login-input-wrap">
                        <span class="login-input-icon">
                            <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="login-input"
                            placeholder="nama@puskesmas.go.id"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
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
                            type="password"
                            id="password"
                            name="password"
                            class="login-input"
                            placeholder="Masukkan kata sandi"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="login-password-toggle" id="toggle-password" aria-label="Tampilkan kata sandi">
                            <svg viewBox="0 0 24 24" id="eye-icon"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="login-options">
                    <label class="login-remember" for="remember">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Ingat saya
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" class="login-submit" id="btn-login">
                    Masuk
                    <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd"/></svg>
                </button>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const toggleBtn = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.innerHTML = isPassword
                ? '<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>'
                : '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>';
        });
    </script>
</body>
</html>
