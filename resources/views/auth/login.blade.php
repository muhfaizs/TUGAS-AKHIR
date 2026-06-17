<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - SatuKIA</title>
    
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
    <div class="max-w-[950px] mx-auto w-full bg-white rounded-[2rem] shadow-2xl shadow-teal-900/10 p-2.5 flex flex-col md:flex-row min-h-[560px] relative z-10">
                
        <!-- Left Side: Banner -->
        <div class="md:w-[45%] bg-brand-dark-green p-10 flex flex-col justify-between text-white relative rounded-[1.5rem] overflow-hidden">
            
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-80 h-80 rounded-full bg-black/10 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col h-full justify-between">
                <!-- Top Section: Logo & Text -->
                <div>
                    <!-- Logo -->
                    <div class="inline-flex items-center gap-3 w-fit mb-10">
                        <div class="w-8 h-8 bg-white/20 backdrop-blur-md border border-white/30 rounded-lg flex items-center justify-center font-bold text-sm shadow-sm">
                            SK
                        </div>
                        <span class="text-xl font-bold tracking-tight">SatuKIA</span>
                    </div>

                    <!-- Text -->
                    <div class="space-y-6">
                        <h1 class="text-[42px] md:text-[48px] lg:text-[52px] leading-[1.1] font-black tracking-tight">
                            Selamat Datang<br/>Kembali 👋
                        </h1>
                        <p class="text-white/90 text-base md:text-lg leading-relaxed max-w-sm font-medium">
                            Masuk untuk melanjutkan pengelolaan layanan KB, pemantauan kehamilan, dan tumbuh kembang bayi di wilayah kerja Anda.
                        </p>
                    </div>
                </div>
                
                <!-- Bottom Section: Badges -->
                <div class="flex flex-col gap-4 mt-12 pb-6">
                    <div class="text-sm font-semibold flex items-center gap-3 text-white/90">
                        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: #fb923c;"></span>Aman & Terenkripsi
                    </div>
                    <div class="text-sm font-semibold flex items-center gap-3 text-white/90">
                        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: #c084fc;"></span>Akses Mudah
                    </div>
                    <div class="text-sm font-semibold flex items-center gap-3 text-white/90">
                        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: #60a5fa;"></span>Realtime
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="md:w-[55%] p-10 flex flex-col justify-center bg-white rounded-r-[2rem]">
            
            <div class="w-full max-w-[380px] mx-auto">
                <!-- Role Selection Tabs -->
                <div class="flex bg-slate-50 p-1.5 rounded-xl mb-8 border border-slate-100">
                    <button type="button" id="tab-bidan" class="flex-1 py-2.5 px-4 text-sm font-bold rounded-lg bg-white shadow-sm border border-slate-100 text-brand-dark-green transition-all" onclick="switchRole('bidan')">
                        Bidan/Dinkes
                    </button>
                    <button type="button" id="tab-ortu" class="flex-1 py-2.5 px-4 text-sm font-bold rounded-lg text-slate-500 hover:text-slate-700 transition-all text-center" onclick="switchRole('ortu')">
                        Ibu Hamil
                    </button>
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl font-extrabold text-slate-900 mb-2 tracking-tight">Masuk ke Akun</h2>
                    <p class="text-slate-500 text-sm font-medium">Silakan masukkan username dan kata sandi Anda.</p>
                </div>

                <form action="/login" method="POST" class="space-y-4" id="login-form">
                    @csrf
                    <!-- Hidden field to store selected role -->
                    <input type="hidden" name="role" id="role-input" value="{{ old('role', 'bidan') }}">

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="bg-red-50 text-red-600 p-3 rounded-xl text-sm font-medium">
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Username Input -->
                    <div>
                        <label id="identity-label" for="identity" class="block text-sm font-bold text-slate-700 mb-1.5">Username</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-teal-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="identity" id="identity" value="{{ old('identity') }}" class="block w-full pr-4 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 bg-white text-slate-800 text-sm font-medium placeholder:text-slate-400 transition-all shadow-sm hover:border-slate-300" style="padding-left: 3.25rem;" placeholder="Masukkan NIP" required maxlength="18" minlength="18" pattern="[0-9]{18}" oninput="handleIdentityInput(this)">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5">Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" class="block w-full py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 bg-white text-slate-800 text-sm font-medium placeholder:text-slate-400 transition-all shadow-sm hover:border-slate-300" style="padding-left: 3.25rem; padding-right: 3.25rem;" placeholder="Masukkan kata sandi" required>
                            
                            <!-- Toggle Password Visibility -->
                            <button type="button" class="absolute inset-y-0 right-5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition-colors" onclick="togglePassword()">
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-slate-300 rounded cursor-pointer">
                            <label for="remember-me" class="ml-2 block text-sm font-medium text-slate-500 cursor-pointer select-none">
                                Ingatkan saya
                            </label>
                        </div>
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-bold text-brand-dark-green hover:text-brand-dark-green-hover transition-colors">
                                Lupa Kata Sandi?
                            </a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-teal-900/20 text-sm font-bold text-white bg-brand-dark-green hover:bg-brand-dark-green-hover focus:outline-none focus:ring-4 focus:ring-teal-500/30 active:scale-[0.98] transition-all duration-300 transform hover:-translate-y-0.5">
                            Masuk &rarr;
                        </button>
                    </div>
                    
                    <div class="mt-6 text-center text-xs font-medium text-slate-500">
                        Belum punya akun? <a href="/register" class="font-bold text-brand-dark-green hover:text-brand-dark-green-hover transition-colors">Daftar sekarang</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script to handle identity input and role switching -->
    <script>
        function handleIdentityInput(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
        }

        function switchRole(role) {
            const tabBidan = document.getElementById('tab-bidan');
            const tabOrtu = document.getElementById('tab-ortu');
            const identityInput = document.getElementById('identity');
            const roleInput = document.getElementById('role-input');

            roleInput.value = role;

            if (role === 'bidan') {
                // Style tabs
                tabBidan.className = 'flex-1 py-2.5 px-4 text-sm font-bold rounded-lg bg-white shadow-sm border border-slate-100 text-brand-dark-green transition-all';
                tabOrtu.className = 'flex-1 py-2.5 px-4 text-sm font-bold rounded-lg text-slate-500 hover:text-slate-700 transition-all text-center';

                // Update Placeholder & Validation
                identityInput.placeholder = 'Masukkan NIP';
                identityInput.setAttribute('maxlength', '18');
                identityInput.setAttribute('minlength', '18');
                identityInput.setAttribute('pattern', '[0-9]{18}');
            } else {
                // Style tabs
                tabOrtu.className = 'flex-1 py-2.5 px-4 text-sm font-bold rounded-lg bg-white shadow-sm border border-slate-100 text-brand-dark-green transition-all';
                tabBidan.className = 'flex-1 py-2.5 px-4 text-sm font-bold rounded-lg text-slate-500 hover:text-slate-700 transition-all text-center';

                // Update Placeholder & Validation
                identityInput.placeholder = 'Masukkan NIK';
                identityInput.setAttribute('maxlength', '16');
                identityInput.setAttribute('minlength', '16');
                identityInput.setAttribute('pattern', '[0-9]{16}');
            }
            
            // Clear input and focus
            identityInput.value = '';
            identityInput.focus();
        }

        window.addEventListener('DOMContentLoaded', () => {
            const role = document.getElementById('role-input').value;
            if (role === 'ortu') {
                switchRole('ortu');
            }
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</body>
</html>
