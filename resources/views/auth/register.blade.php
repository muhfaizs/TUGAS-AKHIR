<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - SatuKIA</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ebf6f5; /* Light greenish background */
            background-image: 
                radial-gradient(circle at 90% 10%, #dcf2ee 0%, transparent 45%),
                radial-gradient(circle at 10% 90%, #dcf2ee 0%, transparent 45%);
            background-attachment: fixed;
        }
        .bg-brand-dark-green {
            background-color: #0e755f !important;
        }
        .bg-brand-dark-green-hover:hover {
            background-color: #0b5c4b !important;
        }
        .text-brand-dark-green {
            color: #0e755f !important;
        }
        .text-brand-dark-green-hover:hover {
            color: #0b5c4b !important;
        }
        
        /* Custom Checkbox */
        .strength-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: #94a3b8; /* slate-400 */
        }
        .strength-indicator.active {
            color: #10b981; /* emerald-500 */
        }
        .strength-indicator svg {
            width: 14px;
            height: 14px;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-4 sm:p-8 relative">
    <!-- Top Left Home Button -->
    <a href="/" class="absolute top-6 left-6 md:top-8 md:left-8 flex items-center gap-2 bg-white px-4 py-2.5 rounded-full text-slate-500 hover:text-slate-800 font-semibold text-sm shadow-sm transition-all border border-slate-100 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Beranda
    </a>

    <!-- Main Container -->
    <div class="max-w-[650px] w-full bg-white p-8 md:p-10 rounded-[2rem] shadow-2xl shadow-teal-900/10 border border-slate-100 my-10 relative z-10">
            
        <!-- Logo Section -->
        <div class="flex justify-center mb-8">
            <div class="w-14 h-14 bg-brand-dark-green rounded-[1.1rem] flex items-center justify-center text-white font-extrabold text-xl shadow-lg shadow-teal-900/15">
                SK
            </div>
        </div>

            <form action="/register" method="POST" class="space-y-6">
                @csrf
                
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium mb-4 border border-red-100">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Nomor Induk Kependudukan (NIK) -->
                <div>
                    <label for="nik" class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Nomor Induk Kependudukan (NIK)</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="block w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-colors text-sm" placeholder="Masukkan 16 digit NIK" required maxlength="16" minlength="16" pattern="[0-9]{16}" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-colors text-sm" placeholder="Masukkan nama lengkap (sesuai e-KTP)" required>
                </div>

                <!-- Nomor Ponsel -->
                <div>
                    <label for="phone" class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Nomor Ponsel</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-300 bg-slate-50 text-slate-500 text-sm font-semibold">
                            +62
                        </span>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="block w-full px-4 py-3 border border-slate-300 rounded-r-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-colors text-sm" placeholder="81234567890 (11 digit)" required maxlength="11" minlength="11" pattern="[0-9]{11}" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                </div>

                <!-- Alamat Email -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="block w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-colors text-sm" placeholder="Masukkan alamat email" required>
                </div>

                <!-- Buat Password -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Buat Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="block w-full px-4 py-3 pr-10 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-colors text-sm" placeholder="Masukkan password" required onkeyup="checkPasswordStrength()">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600" onclick="togglePasswordVisibility('password', 'eye-icon-1')">
                            <svg id="eye-icon-1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Password Strength Indicators -->
                <div class="py-2 flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4">
                    <div id="req-uppercase" class="strength-indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                        Huruf besar
                    </div>
                    <div id="req-number" class="strength-indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                        Mengandung angka
                    </div>
                    <div id="req-lowercase" class="strength-indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                        Huruf kecil
                    </div>
                    <div id="req-length" class="strength-indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                        Minimum 8 karakter
                    </div>
                </div>

                <!-- Ulangi Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Ulangi Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full px-4 py-3 pr-10 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-colors text-sm" placeholder="Ulangi password" required>
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600" onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-2')">
                            <svg id="eye-icon-2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Benefits Banner -->
                <div class="bg-amber-50 rounded-xl p-4 border border-amber-100 flex gap-3 mt-8">
                    <div class="text-amber-500 flex-shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                          <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-amber-800 mb-1">Penting: Pastikan Data yang Anda Masukkan Sudah Benar</p>
                        <ul class="text-xs text-amber-700 list-disc pl-4 space-y-1">
                            <li>Pastikan Nomor NIK yang dimasukkan sudah sesuai dengan data yang terdaftar.</li>
                            <li>Nomor Ponsel yang dimasukkan harus aktif dan dapat dihubungi.</li>
                            <li>Email yang dimasukkan harus aktif dan dapat dihubungi.</li>
                        </ul>
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="flex items-start mt-8">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" class="w-4 h-4 border border-slate-300 rounded bg-slate-50 focus:ring-3 focus:ring-teal-300" required>
                    </div>
                    <label for="terms" class="ml-2 text-sm text-slate-500 font-medium leading-tight">
                        Dengan membuat akun, saya menyetujui <a href="#" class="text-brand-dark-green font-semibold hover:underline">Ketentuan Penggunaan</a> dan <a href="#" class="text-brand-dark-green font-semibold hover:underline">Kebijakan Privasi</a>.
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-slate-200 text-slate-500 font-bold rounded-xl px-5 py-4 mt-6 focus:outline-none transition-colors" id="submit-btn" disabled>
                    Buat Akun
                </button>

                <div class="mt-6 text-center text-xs font-medium text-slate-500">
                    Sudah punya akun SatuKIA? <a href="/login" class="font-bold text-brand-dark-green hover:text-brand-dark-green-hover transition-colors">Masuk</a>
                </div>

            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }

        function checkPasswordStrength() {
            const pw = document.getElementById('password').value;
            
            const hasUpper = /[A-Z]/.test(pw);
            const hasNumber = /[0-9]/.test(pw);
            const hasLower = /[a-z]/.test(pw);
            const hasLength = pw.length >= 8;

            document.getElementById('req-uppercase').classList.toggle('active', hasUpper);
            document.getElementById('req-number').classList.toggle('active', hasNumber);
            document.getElementById('req-lowercase').classList.toggle('active', hasLower);
            document.getElementById('req-length').classList.toggle('active', hasLength);

            const terms = document.getElementById('terms').checked;
            const btn = document.getElementById('submit-btn');

            if (hasUpper && hasNumber && hasLower && hasLength) {
                btn.classList.remove('bg-slate-200', 'text-slate-500');
                btn.classList.add('bg-brand-dark-green', 'hover:bg-brand-dark-green-hover', 'text-white', 'shadow-lg', 'shadow-teal-900/20');
                btn.disabled = false;
            } else {
                btn.classList.add('bg-slate-200', 'text-slate-500');
                btn.classList.remove('bg-brand-dark-green', 'hover:bg-brand-dark-green-hover', 'text-white', 'shadow-lg', 'shadow-teal-900/20');
                btn.disabled = true;
            }
        }

        // Add event listener for checkbox to also trigger button state validation
        document.getElementById('terms').addEventListener('change', checkPasswordStrength);
    </script>
</body>
</html>
