<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Kata Sandi - SatuKIA</title>
    
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
    <a href="{{ route('login') }}" class="absolute top-6 left-6 md:top-8 md:left-8 flex items-center gap-2 bg-white px-4 py-2.5 rounded-full text-slate-500 hover:text-slate-800 font-semibold text-sm shadow-sm transition-all border border-slate-100 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Login
    </a>

    <!-- Main Container -->
    <div class="max-w-[500px] mx-auto w-full bg-white rounded-[2rem] shadow-2xl shadow-teal-900/10 p-10 flex flex-col relative z-10">
                
        <!-- Logo -->
        <div class="inline-flex items-center justify-center gap-3 w-full mb-8">
            <div class="w-10 h-10 bg-brand-dark-green rounded-xl flex items-center justify-center font-bold text-white text-lg shadow-sm">
                SK
            </div>
            <span class="text-2xl font-bold tracking-tight text-slate-800">SatuKIA</span>
        </div>

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-extrabold text-slate-900 mb-2 tracking-tight">Buat Kata Sandi Baru</h2>
            <p class="text-slate-500 text-sm font-medium">Pastikan kata sandi baru Anda kuat dan mudah diingat.</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Hidden Token -->
            <input type="hidden" name="token" value="{{ $token }}">

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

            <!-- Email (Readonly) -->
            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-1.5">Email</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-500 text-sm font-medium cursor-not-allowed" style="padding-left: 3.25rem;" readonly>
                </div>
            </div>

            <!-- Kata Sandi Baru -->
            <div>
                <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-teal-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" name="password" id="password" class="block w-full pr-12 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 bg-white text-slate-800 text-sm font-medium placeholder:text-slate-400 transition-all shadow-sm hover:border-slate-300" style="padding-left: 3.25rem;" placeholder="Minimal 8 karakter (huruf besar & angka)" required>
                </div>
            </div>

            <!-- Konfirmasi Kata Sandi -->
            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1.5">Konfirmasi Kata Sandi</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full pr-12 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 bg-white text-slate-800 text-sm font-medium placeholder:text-slate-400 transition-all shadow-sm hover:border-slate-300" style="padding-left: 3.25rem;" placeholder="Ulangi kata sandi" required>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-teal-900/20 text-sm font-bold text-white bg-brand-dark-green hover:bg-brand-dark-green-hover focus:outline-none focus:ring-4 focus:ring-teal-500/30 active:scale-[0.98] transition-all duration-300 transform hover:-translate-y-0.5">
                    Simpan Kata Sandi
                </button>
            </div>
        </form>
    </div>
</body>
</html>
