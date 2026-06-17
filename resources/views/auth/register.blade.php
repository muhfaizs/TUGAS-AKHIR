<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pasien - SatuKIA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal-900: #0d4f40;
            --teal-800: #0f5a4a;
            --teal-700: #117a65;
            --teal-600: #16a085;
            --teal-500: #1abc9c;
            --white:    #ffffff;
            --gray-50:  #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-900: #111827;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #e8f5f2 0%, #d1ede8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
        }

        /* Back button */
        .back-btn {
            position: absolute;
            top: 24px; left: 24px;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(8px);
            border: 1px solid var(--gray-200);
            border-radius: 999px;
            font-size: 13px;
            font-weight: 500;
            color: var(--gray-700);
            text-decoration: none;
            transition: background 0.2s;
            z-index: 20;
        }
        .back-btn:hover { background: var(--white); }
        .back-btn svg { width: 16px; height: 16px; }

        /* Card */
        .card {
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
            overflow: hidden;
            position: relative;
            z-index: 10;
        }

        /* Left panel */
        .left-panel {
            width: 38%;
            background: linear-gradient(145deg, var(--teal-800) 0%, var(--teal-600) 100%);
            padding: 40px 36px;
            color: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            top: -80px; left: -80px;
            width: 280px; height: 280px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -60px; right: -60px;
            width: 220px; height: 220px;
            background: rgba(0,0,0,0.12);
            border-radius: 50%;
        }
        .left-inner { position: relative; z-index: 2; }

        .logo-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 44px;
        }
        .logo-badge {
            width: 44px; height: 44px;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 15px;
        }
        .logo-name { font-size: 22px; font-weight: 700; letter-spacing: -0.3px; }

        .left-heading { font-size: 28px; font-weight: 800; line-height: 1.25; margin-bottom: 14px; }
        .left-desc { font-size: 13.5px; color: rgba(255,255,255,0.78); line-height: 1.7; }

        /* Step indicators */
        .steps { position: relative; z-index: 2; display: flex; flex-direction: column; gap: 12px; }
        .step-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .step-num {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            border: 1.5px solid rgba(255,255,255,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .step-item.done .step-num {
            background: rgba(255,255,255,0.9);
            color: var(--teal-800);
            border-color: transparent;
        }
        .step-text { font-size: 13px; color: rgba(255,255,255,0.85); }
        .step-item.done .step-text { font-weight: 600; color: #fff; }

        /* Right panel */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 40px 48px;
            background: var(--white);
            overflow-y: auto;
        }

        .form-wrap { width: 100%; max-width: 380px; }

        /* Tab toggle */
        .tab-group {
            display: flex;
            background: var(--gray-100);
            border-radius: 12px;
            padding: 5px;
            margin-bottom: 32px;
            border: 1px solid var(--gray-200);
        }
        .tab-btn {
            flex: 1;
            padding: 10px 0;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 9px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            text-align: center;
            display: block;
        }
        .tab-btn.active {
            background: var(--white);
            color: var(--teal-700);
            font-weight: 600;
            box-shadow: 0 1px 4px rgba(0,0,0,0.10);
            border: 1px solid rgba(0,0,0,0.06);
        }
        .tab-btn.inactive { background: transparent; color: var(--gray-500); }
        .tab-btn.inactive:hover { color: var(--gray-900); }

        .form-title { font-size: 22px; font-weight: 700; color: var(--gray-900); margin-bottom: 4px; }
        .form-sub   { font-size: 13px; color: var(--gray-500); margin-bottom: 24px; }

        /* Field */
        .field { margin-bottom: 14px; }
        .field label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 5px;
        }
        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            top: 50%; left: 12px;
            transform: translateY(-50%);
            color: var(--gray-400);
            pointer-events: none;
            display: flex; align-items: center;
        }
        .input-icon svg { width: 16px; height: 16px; }

        .input-field {
            width: 100%;
            padding: 10px 12px 10px 38px;
            border: 1.5px solid var(--gray-200);
            border-radius: 11px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            color: var(--gray-900);
            background: var(--gray-50);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .input-field.no-icon { padding-left: 12px; }
        .input-field::placeholder { color: var(--gray-400); }
        .input-field:focus {
            border-color: var(--teal-600);
            box-shadow: 0 0 0 3px rgba(22,160,133,0.12);
            background: var(--white);
        }
        .input-field.is-error { border-color: #f87171; }

        .field-error {
            font-size: 11.5px;
            color: #dc2626;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Eye button */
        .eye-btn {
            position: absolute;
            top: 50%; right: 10px;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer;
            color: var(--gray-400);
            padding: 4px; border-radius: 6px;
            display: flex; align-items: center;
        }
        .eye-btn:hover { color: var(--gray-600); }
        .eye-btn svg { width: 16px; height: 16px; }

        /* Password hint */
        .pwd-hint {
            font-size: 11.5px;
            color: var(--gray-400);
            margin-top: 4px;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: var(--gray-100);
            margin: 18px 0;
        }

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--teal-800) 0%, var(--teal-600) 100%);
            color: var(--white);
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: none;
            border-radius: 11px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: opacity 0.2s, transform 0.15s;
            box-shadow: 0 4px 16px rgba(17,122,101,0.28);
            margin-top: 8px;
        }
        .btn-submit:hover   { opacity: 0.92; transform: translateY(-1px); }
        .btn-submit:active  { transform: translateY(0); }
        .btn-submit svg { width: 16px; height: 16px; }

        /* Login link */
        .login-row {
            text-align: center;
            margin-top: 18px;
            font-size: 13px;
            color: var(--gray-500);
        }
        .login-row a { color: var(--teal-700); font-weight: 600; text-decoration: none; }
        .login-row a:hover { text-decoration: underline; }

        /* Error alert */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 11px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 16px;
            display: flex; align-items: flex-start; gap: 8px;
        }
        .alert-error svg { width: 17px; height: 17px; flex-shrink: 0; margin-top: 1px; }
        .alert-error ul  { margin-left: 4px; }
        .alert-error li  { margin-top: 2px; }

        /* Required star */
        .req { color: #f43f5e; margin-left: 2px; }

        /* Section label */
        .section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--gray-400);
            margin-bottom: 12px;
        }

        @media (max-width: 700px) {
            .card { flex-direction: column; }
            .left-panel { width: 100%; min-height: 220px; }
            .right-panel { padding: 28px 22px; }
            .field-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Back button -->
    <a href="{{ route('login') }}" class="back-btn">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali Login
    </a>

    <div class="card">
        <!-- ══ Left Panel ══════════════════════════ -->
        <div class="left-panel">
            <div class="left-inner">
                <div class="logo-wrap">
                    <div class="logo-badge">SK</div>
                    <span class="logo-name">SatuKIA</span>
                </div>
                <h1 class="left-heading">Daftar sebagai<br>Pasien</h1>
                <p class="left-desc">
                    Buat akun pasien untuk memantau layanan KB, kesehatan ibu, dan tumbuh kembang bayi Anda.
                </p>
            </div>

            <div class="steps">
                <div class="step-item done">
                    <div class="step-num">1</div>
                    <div class="step-text">Isi data diri Anda</div>
                </div>
                <div class="step-item done">
                    <div class="step-num">2</div>
                    <div class="step-text">Buat username &amp; kata sandi</div>
                </div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <div class="step-text">Akun aktif &amp; siap digunakan</div>
                </div>
            </div>
        </div>

        <!-- ══ Right Panel ═════════════════════════ -->
        <div class="right-panel">
            <div class="form-wrap">

                <!-- Tab -->
                <div class="tab-group">
                    <a href="{{ route('login') }}" class="tab-btn inactive">Masuk</a>
                    <span class="tab-btn active">Daftar Pasien</span>
                </div>

                <h2 class="form-title">Buat Akun Pasien</h2>
                <p class="form-sub">Lengkapi data di bawah untuk mendaftar.</p>

                @if ($errors->any())
                <div class="alert-error">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <strong>Terdapat kesalahan:</strong>
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <form action="{{ route('register') }}" method="POST" id="registerForm" novalidate>
                    @csrf

                    {{-- ── Data Diri ─────────────────── --}}
                    <div class="section-label">Data Diri</div>

                    <!-- Nama Lengkap -->
                    <div class="field">
                        <label for="name">Nama Lengkap <span class="req">*</span></label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <input id="name" type="text" name="name"
                                   class="input-field @error('name') is-error @enderror"
                                   placeholder="Masukkan nama lengkap"
                                   value="{{ old('name') }}" required>
                        </div>
                        @error('name')<div class="field-error">{{ $message }}</div>@enderror
                    </div>

                    <!-- NIK -->
                    <div class="field">
                        <label for="nik">NIK (16 digit) <span class="req">*</span></label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                                </svg>
                            </span>
                            <input id="nik" type="text" name="nik"
                                   class="input-field @error('nik') is-error @enderror"
                                   placeholder="Contoh: 3273010101900001"
                                   value="{{ old('nik') }}"
                                   maxlength="16"
                                   pattern="\d{16}"
                                   inputmode="numeric"
                                   required>
                        </div>
                        @error('nik')<div class="field-error">{{ $message }}</div>@enderror
                    </div>

                    <!-- Phone & Address row -->
                    <div class="field">
                        <label for="phone">Nomor Telepon</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </span>
                            <input id="phone" type="text" name="phone"
                                   class="input-field @error('phone') is-error @enderror"
                                   placeholder="Contoh: 081234567890"
                                   value="{{ old('phone') }}"
                                   inputmode="tel">
                        </div>
                        @error('phone')<div class="field-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="field">
                        <label for="address">Alamat</label>
                        <div class="input-wrap">
                            <span class="input-icon" style="top:14px;transform:none;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </span>
                            <textarea id="address" name="address"
                                      class="input-field @error('address') is-error @enderror"
                                      placeholder="Alamat lengkap"
                                      rows="2"
                                      style="resize:none; padding-top:10px;">{{ old('address') }}</textarea>
                        </div>
                        @error('address')<div class="field-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="divider"></div>

                    {{-- ── Akun Login ─────────────────── --}}
                    <div class="section-label">Akun Login</div>

                    <!-- Email -->
                    <div class="field">
                        <label for="email">Email <span class="req">*</span></label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input id="email" type="email" name="email"
                                   class="input-field @error('email') is-error @enderror"
                                   placeholder="Masukkan alamat email"
                                   value="{{ old('email') }}"
                                   autocomplete="email"
                                   required>
                        </div>
                        @error('email')<div class="field-error">{{ $message }}</div>@enderror
                    </div>

                    <!-- Password -->
                    <div class="field">
                        <label for="password">Kata Sandi <span class="req">*</span></label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input id="password" type="password" name="password"
                                   class="input-field @error('password') is-error @enderror"
                                   placeholder="Min. 8 karakter"
                                   autocomplete="new-password"
                                   required>
                            <button type="button" class="eye-btn" onclick="togglePwd('password','eye1')">
                                <svg id="eye1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="pwd-hint">Gunakan minimal 8 karakter dengan huruf dan angka.</div>
                        @error('password')<div class="field-error">{{ $message }}</div>@enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="field">
                        <label for="password_confirmation">Konfirmasi Kata Sandi <span class="req">*</span></label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </span>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   class="input-field"
                                   placeholder="Ulangi kata sandi"
                                   autocomplete="new-password"
                                   required>
                            <button type="button" class="eye-btn" onclick="togglePwd('password_confirmation','eye2')">
                                <svg id="eye2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-submit" id="submitBtn">
                        Daftar
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>

                    <p class="login-row">
                        Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePwd(inputId, iconId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        // NIK — angka saja
        document.getElementById('nik').addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });

        // Submit loading state
        document.getElementById('registerForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            btn.innerHTML = `
                <svg class="spin" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Memproses...
            `;
            btn.disabled = true;
        });
    </script>

    <style>
        @keyframes spin { to { transform: rotate(360deg); } }
        .spin { animation: spin 0.8s linear infinite; }
    </style>
</body>
</html>
