@extends('layouts.dashboard')

@section('title', 'Tambah Akun Ibu Hamil - SatuKIA')
@section('page_title', 'Tambah Akun Ibu Hamil')
@section('page_subtitle', 'Masukkan data pengguna ibu hamil ke dalam sistem')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('ortu.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="mb-8">
                <h3 class="text-lg font-bold text-slate-800 mb-1">Informasi Ibu Hamil</h3>
                <p class="text-sm text-slate-500">Pastikan data yang dimasukkan valid dan sesuai.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-medium">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Nama Lengkap -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white text-slate-800 transition-colors" required placeholder="Masukkan nama lengkap">
                </div>

                <!-- NIK -->
                <div>
                    <label for="nik" class="block text-sm font-bold text-slate-700 mb-2">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white text-slate-800 transition-colors" required maxlength="16" minlength="16" pattern="[0-9]{16}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="16 Digit NIK">
                </div>

                <!-- Nomor HP / Kontak -->
                <div>
                    <label for="phone" class="block text-sm font-bold text-slate-700 mb-2">Nomor HP</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white text-slate-800 transition-colors" required placeholder="Contoh: 08123456789" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>

                <!-- Email -->
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white text-slate-800 transition-colors" required placeholder="email@contoh.com">
                </div>
                
                <div class="md:col-span-2 border-t border-slate-100 pt-6 mt-2">
                    <h4 class="font-bold text-slate-800 mb-4">Pengaturan Keamanan</h4>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Kata Sandi</label>
                    <input type="password" name="password" id="password" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white text-slate-800 transition-colors" required placeholder="Minimal 8 karakter">
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white text-slate-800 transition-colors" required placeholder="Ulangi kata sandi">
                </div>
            </div>

            <div class="mt-8 flex gap-4 pt-4 border-t border-slate-100">
                <a href="{{ route('bidan.index') }}" class="px-6 py-3 border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-teal-500/20">Simpan Akun Ibu Hamil</button>
            </div>
        </form>
    </div>
</div>
@endsection

