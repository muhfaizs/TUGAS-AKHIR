@extends('layouts.app')

@section('title', 'Profil Saya - SatuKIA')
@section('header_title', 'Profil Saya')
@section('header_subtitle', 'Kelola informasi profil Anda')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('profile.update') }}" method="POST" class="p-8">
            @csrf
            @method('PATCH')
            
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-medium">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3 class="text-lg font-bold text-teal-700 mb-6 pb-2 border-b border-slate-100">
                Informasi Akun
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Nama Lengkap -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" required>
                </div>

                @if(Auth::user()->isSuperAdmin() || Auth::user()->isBidanOnly() || Auth::user()->isDinkes())
                <!-- NIP -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">NIP (Nomor Induk Pegawai)</label>
                    <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" maxlength="18" minlength="18" pattern="[0-9]{18}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="18 Digit NIP">
                </div>
                @else
                <!-- NIK -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" maxlength="16" minlength="16" pattern="[0-9]{16}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="16 Digit NIK">
                </div>
                @endif

                <!-- Nomor HP -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Ponsel</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" placeholder="Contoh: 081234567890" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>

                <!-- Email -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" required>
                </div>
            </div>

                <div class="pt-4 mt-6 border-t border-slate-100">
                    <h3 class="text-lg font-bold text-teal-700 mb-6">
                        Ubah Kata Sandi <span class="text-slate-400 font-normal text-sm">(Opsional)</span>
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kata Sandi Baru</label>
                            <input type="password" name="password" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" placeholder="Biarkan kosong jika tidak ingin mengubah">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" placeholder="Ketik ulang kata sandi baru">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-end gap-4 pt-6 border-t border-slate-100">
                <button type="submit" class="px-8 py-3.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-teal-500/20">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
