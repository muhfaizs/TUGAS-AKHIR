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
            background-color: #ebf6f5;
            background-image: radial-gradient(#117a6522 1px, transparent 1px);
            background-size: 24px 24px;
        }
        
        /* Gradient gelap untuk panel kiri */
        .bg-mint-dark {
            background: linear-gradient(135deg, #105448 0%, #1c7c6b 100%);
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
    <div class="max-w-[950px] mx-auto w-full bg-white rounded-[2rem] shadow-2xl shadow-teal-900/10 flex flex-col md:flex-row min-h-[560px] relative z-10 overflow-hidden">
                
        <!-- Left Side: Banner -->
        <div class="md:w-[45%] bg-mint-dark p-10 flex flex-col justify-between text-white relative overflow-hidden shadow-inner">
            
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-80 h-80 rounded-full bg-black/20 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col h-full justify-between">
                <!-- Top Section: Logo & Text -->
                <div>
                    <!-- Logo -->
                    <div class="inline-flex items-center gap-3 w-fit mb-10">
                        <div class="w-10 h-10 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl flex items-center justify-center font-bold text-base shadow-sm">
                            SK
                        </div>
                        <span class="text-2xl font-bold tracking-tight drop-shadow-sm">SatuKIA</span>
                    </div>

                    <!-- Text -->
                    <div class="space-y-6">
                        <h1 class="text-[40px] md:text-[46px] leading-[1.1] font-black tracking-tight text-white drop-shadow-sm">
                            Selamat Datang<br/>Kembali
                        </h1>
                        <p class="text-white/80 text-base leading-relaxed max-w-sm font-medium">
                            Masuk untuk melanjutkan pengelolaan layanan KB, pemantauan kehamilan, dan tumbuh kembang bayi di wilayah kerja Anda.
                        </p>
                    </div>
                </div>
                
                <!-- Bottom Section: Badges -->
                <div class="flex flex-col gap-4 mt-12 pb-2">
                    <div class="text-sm font-semibold flex items-center gap-3 text-white/90 bg-white/5 w-fit px-3 py-2 rounded-lg border border-white/10 backdrop-blur-sm">
                        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: #fb923c;"></span>Aman & Terenkripsi
                    </div>
                    <div class="text-sm font-semibold flex items-center gap-3 text-white/90 bg-white/5 w-fit px-3 py-2 rounded-lg border border-white/10 backdrop-blur-sm">
                        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: #60a5fa;"></span>Akses Cepat & Mudah
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="md:w-[55%] p-10 flex flex-col justify-center bg-white">
            
            <div class="w-full max-w-[380px] mx-auto">
                <!-- Role Selection Tabs -->
                <div class="flex bg-slate-50 p-1.5 rounded-xl mb-8 border border-slate-100 relative">
                    <!-- Active Indicator Background -->
                    <div id="tab-active-bg" class="absolute top-1.5 bottom-1.5 left-1.5 w-[calc(50%-6px)] bg-white rounded-lg shadow-sm border border-slate-100 transition-all duration-300 ease-in-out"></div>
                    
                    <button type="button" id="tab-bidan" class="relative z-10 flex-1 py-2.5 px-4 text-sm font-bold text-teal-800 transition-all text-center" onclick="switchRole('bidan')">
                        Petugas
                    </button>
                    <button type="button" id="tab-ortu" class="relative z-10 flex-1 py-2.5 px-4 text-sm font-bold text-slate-500 hover:text-slate-700 transition-all text-center" onclick="switchRole('ortu')">
                        Pasien KB
                    </button>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-black text-slate-900 mb-2 tracking-tight">Masuk ke Akun</h2>
                    <p class="text-slate-500 text-sm font-medium leading-relaxed">Silakan masukkan identitas dan kata sandi Anda untuk melanjutkan.</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-5" id="login-form">
                    @csrf
                    <!-- Hidden field to store selected role -->
                    <input type="hidden" name="role" id="role-input" value="{{ old('role', 'bidan') }}">

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100 flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Username Input -->
                    <div>
                        <label id="identity-label" for="identity" class="block text-sm font-bold text-slate-700 mb-2">Username</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-teal-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="username" id="identity" value="{{ old('username') }}" class="block w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/15 focus:border-teal-500 bg-slate-50 focus:bg-white text-slate-800 text-sm font-medium placeholder:text-slate-400 transition-all hover:border-slate-300" placeholder="Masukkan Username" required>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" class="block w-full pl-11 pr-12 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/15 focus:border-teal-500 bg-slate-50 focus:bg-white text-slate-800 text-sm font-medium placeholder:text-slate-400 transition-all hover:border-slate-300" placeholder="Masukkan Password" required>
                            
                            <!-- Toggle Password Visibility -->
                            <button type="button" class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition-colors" onclick="togglePassword()">
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-slate-300 rounded cursor-pointer transition-colors">
                            <label for="remember-me" class="ml-2 block text-sm font-medium text-slate-600 cursor-pointer select-none">
                                Ingatkan saya
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 rounded-xl shadow-lg shadow-teal-700/20 text-sm font-bold text-white bg-[#117a65] hover:bg-[#0e6150] focus:outline-none focus:ring-4 focus:ring-teal-500/30 active:scale-[0.98] transition-all duration-300">
                            Masuk
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>

                    <!-- Additional Links -->
                    <div class="flex flex-col items-center justify-center gap-3 pt-3">
                        <a href="#" class="text-sm font-bold text-[#117a65] hover:text-[#0e6150] transition-colors">Forgot Password?</a>
                        <p class="text-sm font-medium text-slate-600">
                            New User? 
                            <a href="{{ route('register') }}" class="font-bold text-[#117a65] hover:text-[#0e6150] transition-colors">Sign Up</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script to handle identity input and role switching -->
    <script>
        function handleIdentityInput(input) {
            // Dihapus agar bisa memasukkan huruf (username non-angka)
        }

        function switchRole(role, isUserClick = true) {
            const tabBidan = document.getElementById('tab-bidan');
            const tabOrtu = document.getElementById('tab-ortu');
            const identityInput = document.getElementById('identity');
            const roleInput = document.getElementById('role-input');
            const identityLabel = document.getElementById('identity-label');
            const activeBg = document.getElementById('tab-active-bg');

            roleInput.value = role;

            if (role === 'bidan') {
                // Style tabs
                tabBidan.className = 'relative z-10 flex-1 py-2.5 px-4 text-sm font-bold text-teal-800 transition-all text-center';
                tabOrtu.className = 'relative z-10 flex-1 py-2.5 px-4 text-sm font-bold text-slate-500 hover:text-slate-700 transition-all text-center';
                activeBg.style.transform = 'translateX(0)';

                // Update Placeholder & Validation
                identityLabel.innerText = 'Username / NIP';
                identityInput.type = 'text';
                identityInput.placeholder = 'Masukkan Username atau NIP';
                identityInput.removeAttribute('maxlength');
                identityInput.removeAttribute('minlength');
                identityInput.removeAttribute('pattern');
                identityInput.oninput = null;
            } else {
                // Style tabs
                tabOrtu.className = 'relative z-10 flex-1 py-2.5 px-4 text-sm font-bold text-teal-800 transition-all text-center';
                tabBidan.className = 'relative z-10 flex-1 py-2.5 px-4 text-sm font-bold text-slate-500 hover:text-slate-700 transition-all text-center';
                activeBg.style.transform = 'translateX(100%)';

                // Update Placeholder & Validation
                identityLabel.innerText = 'NIK (Nomor Induk Kependudukan)';
                identityInput.type = 'text';
                identityInput.placeholder = 'Masukkan NIK Pasien';
                identityInput.setAttribute('maxlength', '16');
                identityInput.setAttribute('minlength', '16');
                identityInput.setAttribute('pattern', '[0-9]{16}');
                
                // Mencegah input huruf atau email untuk NIK
                identityInput.oninput = function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                };
                
                // Bersihkan langsung jika terlanjur ada karakter selain angka (misal: dari autofill browser)
                identityInput.value = identityInput.value.replace(/[^0-9]/g, '');
            }
            
            // Clear input and focus only if user explicitly clicked the tab
            if (isUserClick) {
                identityInput.value = '';
                identityInput.focus();
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            const role = document.getElementById('role-input').value;
            if (role === 'ortu') {
                switchRole('ortu', false);
            } else {
                switchRole('bidan', false);
            }

            @if ($errors->any())
                @if (old('role') === 'ortu')
                    alert('NIK yang dimasukkan salah');
                @else
                    alert('Username atau NIP yang dimasukkan salah');
                @endif
            @endif
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
