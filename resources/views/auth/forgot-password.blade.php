<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Kata Sandi - SatuKIA</title>
    
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
            <h2 class="text-2xl font-extrabold text-slate-900 mb-2 tracking-tight">Lupa Kata Sandi?</h2>
            <p class="text-slate-500 text-sm font-medium">Masukkan NIK atau NIP Anda yang terdaftar, lalu pilih metode pemulihan.</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl text-sm font-medium">
                {!! session('success') !!}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
            @csrf

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

            <!-- Identity Input -->
            <div>
                <label for="identity" class="block text-sm font-bold text-slate-700 mb-1.5">NIK / NIP</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-teal-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <input type="text" name="identity" id="identity" value="{{ old('identity') }}" class="block w-full pr-4 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 bg-white text-slate-800 text-sm font-medium placeholder:text-slate-400 transition-all shadow-sm hover:border-slate-300" style="padding-left: 3.25rem;" placeholder="Masukkan NIK atau NIP" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
            </div>

            <!-- Recovery Method Selection -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Metode Pemulihan</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative flex flex-col items-center justify-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 hover:border-teal-400 transition-all">
                        <input type="radio" name="recovery_method" value="email" class="absolute h-0 w-0 opacity-0 peer" required {{ old('recovery_method') == 'email' ? 'checked' : '' }}>
                        <div class="peer-checked:border-teal-500 peer-checked:bg-teal-50 absolute inset-0 rounded-xl border-2 border-transparent transition-all"></div>
                        <div class="relative z-10 flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-500 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm font-bold text-slate-700">Email</span>
                        </div>
                    </label>
                    <label class="relative flex flex-col items-center justify-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 hover:border-teal-400 transition-all">
                        <input type="radio" name="recovery_method" value="wa" class="absolute h-0 w-0 opacity-0 peer" required {{ old('recovery_method') == 'wa' ? 'checked' : '' }}>
                        <div class="peer-checked:border-teal-500 peer-checked:bg-teal-50 absolute inset-0 rounded-xl border-2 border-transparent transition-all"></div>
                        <div class="relative z-10 flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm font-bold text-slate-700">WhatsApp</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-teal-900/20 text-sm font-bold text-white bg-brand-dark-green hover:bg-brand-dark-green-hover focus:outline-none focus:ring-4 focus:ring-teal-500/30 active:scale-[0.98] transition-all duration-300 transform hover:-translate-y-0.5">
                    Kirim Tautan Pemulihan
                </button>
            </div>
        </form>
    </div>
</body>
</html>
