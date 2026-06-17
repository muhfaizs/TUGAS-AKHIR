@extends('layouts.dashboard')

@section('title', 'Edit Data Ibu Hamil - SatuKIA')
@section('page_title', request('section') == 'riwayat' ? 'Edit Riwayat & Administratif' : 'Perbarui Data Ibu Hamil')
@section('page_subtitle', 'Edit profil dan rekam medis pasien')

@section('content')
<div class="max-w-5xl">
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('ibu-hamil.update', $ibuHamil->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-medium">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                        @php
                $isRiwayatOnly = request('section') == 'riwayat';
            @endphp

            @if($isRiwayatOnly)
            <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl text-sm font-medium">
                Anda sedang mengedit bagian <strong>Riwayat & Administratif</strong> saja.
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('#section-identitas input, #section-identitas select, #section-identitas textarea, #section-kehamilan input, #section-kehamilan select, #section-kehamilan textarea').forEach(el => el.required = false);
                });
            </script>
            @endif

            <!-- Data Administratif -->
            <div class="flex items-center justify-between mb-8 bg-slate-50 p-5 rounded-xl border border-slate-100">
                <div>
                    <p class="text-sm text-slate-500 font-medium">Nomor Rekam Medis</p>
                    <p class="font-bold text-slate-800 text-lg">{{ $ibuHamil->nomor_rekam_medis }}</p>
                </div>
                <div class="flex gap-8">
                    <div class="text-right">
                        <p class="text-sm text-slate-500 font-medium">Status Ibu Hamil</p>
                        <select name="status_ibu_meninggal" class="font-bold bg-transparent border-0 focus:ring-0 text-slate-800 text-lg p-0 text-right cursor-pointer">
                            <option value="Hidup" {{ $ibuHamil->status_ibu_meninggal == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                            <option value="Meninggal" {{ $ibuHamil->status_ibu_meninggal == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                        </select>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-500 font-medium">Status Pasien</p>
                        <select name="status_pasien" class="font-bold bg-transparent border-0 focus:ring-0 text-slate-800 text-lg p-0 text-right cursor-pointer">
                            <option value="Aktif" {{ $ibuHamil->status_pasien == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ $ibuHamil->status_pasien == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="tanggal_registrasi_pasien" value="{{ $ibuHamil->tanggal_registrasi_pasien->format('Y-m-d') }}">
            </div>

            <!-- Bagian 1: Data Identitas Pasien -->
            <div id="section-identitas" class="mb-10" {!! $isRiwayatOnly ? 'style="display:none;"' : '' !!}>
                <h3 class="text-lg font-bold text-teal-700 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Data Identitas Pasien
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" name="nik" value="{{ old('nik', $ibuHamil->nik) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" required maxlength="16" minlength="16" pattern="[0-9]{16}" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nomor BPJS (Opsional)</label>
                        <input type="text" name="nomor_bpjs" value="{{ old('nomor_bpjs', $ibuHamil->nomor_bpjs) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" maxlength="13" minlength="13" pattern="[0-9]{13}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="13 Digit BPJS">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $ibuHamil->nama_lengkap) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $ibuHamil->tempat_lahir) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $ibuHamil->tanggal_lahir->format('Y-m-d')) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Umur (Thn)</label>
                            <input type="number" name="umur" value="{{ old('umur', $ibuHamil->umur) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" required min="10" max="60">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Domisili</label>
                        <textarea name="alamat" rows="2" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" required>{{ old('alamat', $ibuHamil->alamat) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Telepon/HP</label>
                        <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $ibuHamil->nomor_telepon) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $ibuHamil->email) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Suami</label>
                        <input type="text" name="nama_suami" value="{{ old('nama_suami', $ibuHamil->nama_suami) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pekerjaan</label>
                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $ibuHamil->pekerjaan) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Gol. Darah</label>
                            <select name="golongan_darah" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition-colors">
                                <option value="Tidak Tahu" {{ old('golongan_darah', $ibuHamil->golongan_darah) == 'Tidak Tahu' ? 'selected' : '' }}>Tidak Tahu</option>
                                <option value="A" {{ old('golongan_darah', $ibuHamil->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('golongan_darah', $ibuHamil->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="AB" {{ old('golongan_darah', $ibuHamil->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="O" {{ old('golongan_darah', $ibuHamil->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Data Kehamilan Dasar -->
            <div id="section-kehamilan" class="mb-10" {!! $isRiwayatOnly ? 'style="display:none;"' : '' !!}>
                <h3 class="text-lg font-bold text-pink-700 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    Data Kehamilan Dasar
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">HPHT (Haid Terakhir)</label>
                        <input type="date" name="hpht" value="{{ old('hpht', $ibuHamil->hpht->format('Y-m-d')) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-pink-500 focus:border-pink-500 bg-slate-50 focus:bg-white transition-colors" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">HPL (Perkiraan Lahir)</label>
                        <input type="date" name="hpl" value="{{ old('hpl', $ibuHamil->hpl->format('Y-m-d')) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-pink-500 focus:border-pink-500 bg-slate-50 focus:bg-white transition-colors" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Usia Kehamilan</label>
                            <div class="relative flex items-center">
                                <input type="number" name="usia_kehamilan" value="{{ old('usia_kehamilan', $ibuHamil->usia_kehamilan) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-pink-500 focus:border-pink-500 bg-slate-50 focus:bg-white transition-colors pr-16" required>
                                <span class="absolute right-4 text-slate-400 text-sm">Minggu</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kehamilan Ke-</label>
                            <input type="number" name="kehamilan_ke" value="{{ old('kehamilan_ke', $ibuHamil->kehamilan_ke) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-pink-500 focus:border-pink-500 bg-slate-50 focus:bg-white transition-colors" required min="1">
                        </div>
                    </div>
                    
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Riwayat GPA (Gravida, Paritas, Abortus)</label>
                            <div class="flex gap-2">
                                <div class="flex-1 relative flex items-center">
                                    <span class="absolute left-3 text-slate-500 font-bold">G</span>
                                    <input type="number" name="gravida" value="{{ old('gravida', $ibuHamil->gravida) }}" class="block w-full pl-8 pr-3 py-3 border border-slate-200 rounded-xl focus:ring-pink-500 focus:border-pink-500 bg-slate-50 transition-colors" required min="1">
                                </div>
                                <div class="flex-1 relative flex items-center">
                                    <span class="absolute left-3 text-slate-500 font-bold">P</span>
                                    <input type="number" name="paritas" value="{{ old('paritas', $ibuHamil->paritas) }}" class="block w-full pl-8 pr-3 py-3 border border-slate-200 rounded-xl focus:ring-pink-500 focus:border-pink-500 bg-slate-50 transition-colors" required min="0">
                                </div>
                                <div class="flex-1 relative flex items-center">
                                    <span class="absolute left-3 text-slate-500 font-bold">A</span>
                                    <input type="number" name="abortus" value="{{ old('abortus', $ibuHamil->abortus) }}" class="block w-full pl-8 pr-3 py-3 border border-slate-200 rounded-xl focus:ring-pink-500 focus:border-pink-500 bg-slate-50 transition-colors" required min="0">
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Bayi Meninggal Setelah Lahir</label>
                            <input type="number" name="bayi_meninggal_setelah_lahir" value="{{ old('bayi_meninggal_setelah_lahir', $ibuHamil->bayi_meninggal_setelah_lahir) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-pink-500 focus:border-pink-500 bg-slate-50 focus:bg-white transition-colors" required min="0">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Status Risiko Kehamilan</label>
                        <div class="flex gap-4">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="status_risiko_kehamilan" value="Rendah" class="peer sr-only" {{ old('status_risiko_kehamilan', $ibuHamil->status_risiko_kehamilan) == 'Rendah' ? 'checked' : '' }}>
                                <div class="px-4 py-3 border-2 border-slate-100 rounded-xl text-center font-bold text-slate-500 peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 transition-all">Rendah</div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="status_risiko_kehamilan" value="Tinggi" class="peer sr-only" {{ old('status_risiko_kehamilan', $ibuHamil->status_risiko_kehamilan) == 'Tinggi' ? 'checked' : '' }}>
                                <div class="px-4 py-3 border-2 border-slate-100 rounded-xl text-center font-bold text-slate-500 peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-700 transition-all">Tinggi</div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="status_risiko_kehamilan" value="Sangat Tinggi" class="peer sr-only" {{ old('status_risiko_kehamilan', $ibuHamil->status_risiko_kehamilan) == 'Sangat Tinggi' ? 'checked' : '' }}>
                                <div class="px-4 py-3 border-2 border-slate-100 rounded-xl text-center font-bold text-slate-500 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 transition-all">Sangat Tinggi</div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Riwayat Pemeriksaan -->
            <div class="mb-6">
                <h3 class="text-lg font-bold text-indigo-700 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Riwayat Pemeriksaan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Total Kunjungan ANC</label>
                        <input type="number" name="jumlah_pemeriksaan_anc" value="{{ old('jumlah_pemeriksaan_anc', $ibuHamil->jumlah_pemeriksaan_anc) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 focus:bg-white transition-colors" required min="0">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tgl Pemeriksaan Terakhir</label>
                        <input type="date" name="pemeriksaan_terakhir" value="{{ old('pemeriksaan_terakhir', $ibuHamil->pemeriksaan_terakhir ? $ibuHamil->pemeriksaan_terakhir->format('Y-m-d') : '') }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Status Kehamilan Saat Ini</label>
                        <input type="text" name="status_kehamilan_terakhir" value="{{ old('status_kehamilan_terakhir', $ibuHamil->status_kehamilan_terakhir) }}" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 focus:bg-white transition-colors" placeholder="Contoh: Sehat / Keluhan pusing">
                    </div>

                    <div class="md:col-span-3 mt-2 border-t border-slate-100 pt-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tindakan Medis (Opsional)</label>
                        <textarea name="tindakan_medis" rows="3" class="block w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 focus:bg-white transition-colors" placeholder="Catat tindakan medis yang diberikan...">{{ old('tindakan_medis', $ibuHamil->tindakan_medis) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-end gap-4 pt-6 border-t border-slate-100">
                <a href="{{ route('ibu-hamil.index') }}" class="px-8 py-3.5 border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="px-8 py-3.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-teal-500/20">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

