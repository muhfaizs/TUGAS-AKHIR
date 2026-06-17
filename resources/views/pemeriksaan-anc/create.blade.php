@extends('layouts.dashboard')

@section('title', 'Input Pemeriksaan ANC')
@section('page_title', 'Pemeriksaan ANC Terpadu')
@section('page_subtitle', 'Rekam medis lengkap Antenatal Care')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Pasien: {{ $ibuHamil->nama_lengkap }}</h2>
        <p class="text-slate-500">Usia: {{ $ibuHamil->umur }} Tahun | NIK: {{ $ibuHamil->nik }}</p>
    </div>
    <a href="{{ route('ibu-hamil.show', $ibuHamil->id) }}" class="text-teal-600 hover:text-teal-700 font-medium text-sm flex items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Profil
    </a>
</div>

<form action="{{ route('pemeriksaan-anc.store') }}" method="POST" class="space-y-6">
    @csrf
    
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl">
            <div class="font-bold mb-2">Mohon periksa kembali isian Anda:</div>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    
    <div class="bg-blue-50 border border-blue-200 text-blue-800 px-5 py-4 rounded-2xl mb-6">
        <div class="font-bold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            Penting: Semua Data Wajib Diisi
        </div>
        <p class="text-sm mt-1 ml-7">Jika tidak ada data atau Anda tidak ingin mengisi kolom tertentu, silakan isi dengan tanda hubung ( <b>-</b> ). Khusus untuk waktu pemeriksaan, klik tombol untuk mengisi otomatis.</p>
    </div>
    
    <input type="hidden" name="ibu_hamil_id" value="{{ $ibuHamil->id }}">

    <!-- Informasi Dasar -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">Informasi Pemeriksaan Dasar</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal & Waktu Pemeriksaan <span class="text-rose-500">*</span></label>
                <div class="grid grid-cols-2 gap-2">
                    <input type="date" name="tanggal_pemeriksaan" required value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block p-3">
                    <div class="relative">
                        <input type="time" name="waktu_pemeriksaan" id="waktu_pemeriksaan" required readonly class="w-full bg-slate-100 border border-slate-200 text-slate-600 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block p-3 cursor-pointer" onclick="setWaktuSekarang()">
                        <button type="button" onclick="setWaktuSekarang()" class="absolute right-2 top-2 px-2 py-1 bg-teal-100 text-teal-700 text-[10px] font-bold rounded-lg hover:bg-teal-200">Set Waktu</button>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Trimester Kehamilan</label>
                <select name="trimester" required id="trimester_select" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block p-3">
                    <option value="">-- Pilih Trimester --</option>
                    <option value="-">- (Tidak Diisi)</option>
                    <option value="Trimester 1" {{ old('trimester') == 'Trimester 1' ? 'selected' : '' }}>Trimester 1 (0-12 Minggu)</option>
                    <option value="Trimester 2" {{ old('trimester') == 'Trimester 2' ? 'selected' : '' }}>Trimester 2 (13-28 Minggu)</option>
                    <option value="Trimester 3" {{ old('trimester') == 'Trimester 3' ? 'selected' : '' }}>Trimester 3 (29-40 Minggu)</option>
                </select>
                <div id="trimester_info" style="display:none;"></div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-2">Keluhan Utama Pasien</label>
                <textarea name="keluhan_utama" required rows="2" placeholder="Tuliskan keluhan utama pasien saat datang..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block p-3"></textarea>
            </div>
        </div>
    </div>

    <!-- Fisik & Kebidanan -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-teal-500">
        <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">1. Pemeriksaan Fisik & Kebidanan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Berat Badan</label>
                <div class="relative">
                    <input type="text" required name="berat_badan" placeholder="Contoh: 60" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block p-3 pr-10" oninput="this.value = this.value.replace(/[^0-9.-]/g, '');">
                    <span class="absolute right-3 top-3 text-slate-400 text-sm font-medium">kg</span>
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tinggi Badan</label>
                <div class="relative">
                    <input type="text" required name="tinggi_badan" placeholder="Contoh: 155" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block p-3 pr-10" oninput="this.value = this.value.replace(/[^0-9.-]/g, '');">
                    <span class="absolute right-3 top-3 text-slate-400 text-sm font-medium">cm</span>
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tekanan Darah</label>
                <input type="text" name="tekanan_darah" required placeholder="Contoh: 120/80" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block p-3">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Lingkar Lengan Atas (LiLA)</label>
                <div class="relative">
                    <input type="text" required step="0.1" name="lingkar_lengan_atas" placeholder="Contoh: 24.5" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block p-3 pr-10" oninput="this.value = this.value.replace(/[^0-9.-]/g, '');">
                    <span class="absolute right-3 top-3 text-slate-400 text-sm font-medium">cm</span>
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tinggi Fundus Uteri</label>
                <div class="relative">
                    <input type="text" required name="tinggi_fundus_uteri" placeholder="Contoh: 20" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block p-3 pr-10" oninput="this.value = this.value.replace(/[^0-9.-]/g, '');">
                    <span class="absolute right-3 top-3 text-slate-400 text-sm font-medium">cm</span>
                </div>
            </div>
            <!-- T5 -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Letak Janin (Leopold)</label>
                <select name="letak_janin" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block p-3">
                    <option value="">-- Pilih Letak Janin --</option>
                    <option value="-">- (Tidak Diisi)</option>
                    <option value="Kepala">Kepala</option>
                    <option value="Sungsang">Sungsang</option>
                    <option value="Lintang">Lintang</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Denyut Jantung Janin (DJJ)</label>
                <div class="relative">
                    <input type="text" required name="denyut_jantung_janin" placeholder="Contoh: 140" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block p-3 pr-12" oninput="this.value = this.value.replace(/[^0-9.-]/g, '');">
                    <span class="absolute right-3 top-3 text-slate-400 text-sm font-medium">bpm</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Imunisasi & Suplemen -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-indigo-500">
        <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">2. Imunisasi & Suplemen</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                <label class="block text-sm font-bold text-slate-700 mb-2">Imunisasi Tetanus</label>
                <div class="flex items-center gap-3 mb-3">
                    <input type="checkbox" id="diberikan_imunisasi_tt" name="diberikan_imunisasi_tt" value="1" class="w-5 h-5 text-indigo-600 bg-white border-slate-300 rounded focus:ring-indigo-500">
                    <label for="diberikan_imunisasi_tt" class="text-sm font-medium text-slate-800">Diberikan Imunisasi TT pada kunjungan ini</label>
                </div>
                <label class="block text-xs font-bold text-slate-600 mb-2 mt-4">Status Imunisasi TT Saat Ini</label>
                <select name="status_imunisasi_tt" required class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3">
                    <option value="">-- Pilih Status --</option>
                    <option value="-">- (Tidak Diisi)</option>
                    <option value="T1">T1 (Perlindungan 0 tahun)</option>
                    <option value="T2">T2 (Perlindungan 3 tahun)</option>
                    <option value="T3">T3 (Perlindungan 5 tahun)</option>
                    <option value="T4">T4 (Perlindungan 10 tahun)</option>
                    <option value="T5">T5 (Perlindungan >25 tahun)</option>
                </select>
            </div>
            
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                <label class="block text-sm font-bold text-slate-700 mb-2">Tablet Tambah Darah</label>
                <div class="flex items-center gap-3 mb-3">
                    <input type="checkbox" id="diberikan_tablet_tambah_darah" name="diberikan_tablet_tambah_darah" value="1" class="w-5 h-5 text-indigo-600 bg-white border-slate-300 rounded focus:ring-indigo-500">
                    <label for="diberikan_tablet_tambah_darah" class="text-sm font-medium text-slate-800">Diberikan TTD (Tablet Tambah Darah)</label>
                </div>
                <label class="block text-xs font-bold text-slate-600 mb-2 mt-4">Jumlah Tablet</label>
                <div class="relative">
                    <input type="text" required name="jumlah_tablet_darah" placeholder="Contoh: 30" class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3 pr-16" oninput="this.value = this.value.replace(/[^0-9.-]/g, '');">
                    <span class="absolute right-3 top-3 text-slate-400 text-sm font-medium">tablet</span>
                </div>
                
                <label class="block text-xs font-bold text-slate-600 mb-2 mt-4">Risiko Anemia</label>
                <select name="risiko_anemia" required class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3">
                    <option value="">-- Pilih Risiko Anemia --</option>
                    <option value="-">- (Tidak Diisi)</option>
                    <option value="Ringan" {{ old('risiko_anemia') == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                    <option value="Sedang" {{ old('risiko_anemia') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="Tinggi" {{ old('risiko_anemia') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Laboratorium & USG -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-rose-500">
        <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">3. Laboratorium & USG</h3>
        
        <div class="mb-6 flex flex-wrap justify-between items-start gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="rujuk_laboratorium" name="rujuk_laboratorium" value="1" {{ old('rujuk_laboratorium') ? 'checked' : '' }} class="w-5 h-5 text-rose-600 bg-white border-slate-300 rounded focus:ring-rose-500" onchange="toggleLabFields()">
                    <label for="rujuk_laboratorium" class="text-sm font-bold text-slate-800">Pasien dirujuk ke laboratorium</label>
                </div>
                <p class="text-xs text-slate-500 ml-8 mt-1">Sesuai alur proses, jika Ya, lengkapi hasil lab di bawah ini setelah hasil tersedia.</p>
            </div>
            <div id="btn_cetak_lab" style="display: {{ old('rujuk_laboratorium') ? 'block' : 'none' }};">
                <button type="submit" name="action" value="draft_print" formnovalidate class="inline-flex items-center gap-2 px-4 py-2 bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-200 font-bold rounded-xl transition-colors shadow-sm text-sm" title="Simpan sebagai draft terlebih dahulu untuk mencetak surat rujukan">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Simpan Draft & Cetak Lab
                </button>
            </div>
        </div>

        <div id="lab_fields_container" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 p-4 bg-slate-50 rounded-2xl border border-slate-200" style="display: {{ old('rujuk_laboratorium') ? 'grid' : 'none' }};">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Hemoglobin (Hb)</label>
                <div class="relative">
                    <input type="text"  name="lab_hb" placeholder="Contoh: 11" class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-rose-500 focus:border-rose-500 block p-3 pr-12" oninput="this.value = this.value.replace(/[^0-9.-]/g, '');">
                    <span class="absolute right-3 top-3 text-slate-400 text-sm font-medium">g/dl</span>
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Protein Urine</label>
                <select name="lab_protein_urine"  class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-rose-500 focus:border-rose-500 block p-3">
                    <option value="">-- Pilih Hasil --</option>
                    <option value="-">- (Tidak Diisi)</option>
                    <option value="Negatif (-)">Negatif (-)</option>
                    <option value="Positif (+)">Positif (+)</option>
                    <option value="Positif (++)">Positif (++)</option>
                    <option value="Positif (+++)">Positif (+++)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Golongan Darah</label>
                <select name="lab_golongan_darah"  class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-rose-500 focus:border-rose-500 block p-3">
                    <option value="">-- Pilih --</option>
                    <option value="-">- (Tidak Diisi)</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Sifilis</label>
                <select name="lab_sifilis"  class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-rose-500 focus:border-rose-500 block p-3">
                    <option value="">-- Pilih Hasil --</option>
                    <option value="-">- (Tidak Diisi)</option>
                    <option value="Non Reaktif">Non Reaktif</option>
                    <option value="Reaktif">Reaktif</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">HIV</label>
                <select name="lab_hiv"  class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-rose-500 focus:border-rose-500 block p-3">
                    <option value="">-- Pilih Hasil --</option>
                    <option value="-">- (Tidak Diisi)</option>
                    <option value="Non Reaktif">Non Reaktif</option>
                    <option value="Reaktif">Reaktif</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Hepatitis B (HBsAg)</label>
                <select name="lab_hepatitis_b"  class="w-full bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-rose-500 focus:border-rose-500 block p-3">
                    <option value="">-- Pilih Hasil --</option>
                    <option value="-">- (Tidak Diisi)</option>
                    <option value="Non Reaktif">Non Reaktif</option>
                    <option value="Reaktif">Reaktif</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold text-slate-700 mb-2">Hasil USG Bidan</label>
            <textarea name="hasil_usg" required rows="2" placeholder="Catatan atau hasil pemeriksaan USG bidan (jika ada)..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-rose-500 focus:border-rose-500 block p-3"></textarea>
        </div>
    </div>

    <!-- Tatalaksana & Konseling -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-amber-500">
        <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">4. Tatalaksana & Konseling</h3>
        
        <div class="mb-6 p-4 bg-red-50 rounded-2xl border border-red-100">
            <div class="flex items-center gap-3">
                <input type="checkbox" id="ditemukan_risiko" name="ditemukan_risiko" value="1" class="w-5 h-5 text-red-600 bg-white border-red-300 rounded focus:ring-red-500">
                <label for="ditemukan_risiko" class="text-sm font-bold text-red-800">Ditemukan Risiko Kehamilan?</label>
            </div>
            <p class="text-xs text-red-600 ml-8 mt-1">Centang jika evaluasi fisik/lab menunjukkan tanda bahaya dan perlu rujukan fasilitas lanjutan.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 mb-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tatalaksana Kasus / Penanganan</label>
                <textarea name="tatalaksana_kasus" required rows="3" placeholder="Tindakan medis yang dilakukan atau rencana rujukan..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3"></textarea>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Temu Wicara / Konseling</label>
                <textarea name="konseling" required rows="3" placeholder="Materi edukasi dan konseling yang diberikan pada pasien..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3"></textarea>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Skrining Jiwa</label>
                <textarea name="skrining_jiwa" required rows="2" placeholder="Hasil observasi status mental dan emosional ibu hamil..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3"></textarea>
            </div>
        </div>
    </div>

    <!-- Submit Action -->
    <div class="flex flex-wrap justify-end gap-4 mt-8 pb-8">
        <a href="{{ route('ibu-hamil.show', $ibuHamil->id) }}" class="px-6 py-3 border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors">
            Batal
        </a>
        <button type="submit" name="action" value="draft" formnovalidate class="px-6 py-3 bg-amber-50 text-amber-600 border border-amber-200 rounded-xl font-bold hover:bg-amber-100 transition-colors shadow-sm flex items-center gap-2">
            Simpan Sementara (Draft)
        </button>
        <button type="submit" name="action" value="selesai" class="px-8 py-3 bg-teal-600 text-white rounded-xl font-bold hover:bg-teal-700 transition-colors shadow-sm shadow-teal-200 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
            Simpan Final
        </button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('trimester_select');
        const infoBox = document.getElementById('trimester_info');
        
        const requiredFields = {
            'Trimester 1': ['berat_badan', 'tinggi_badan', 'tekanan_darah', 'lingkar_lengan_atas', 'diberikan_imunisasi_tt', 'diberikan_tablet_tambah_darah', 'rujuk_laboratorium'],
            'Trimester 2': ['tekanan_darah', 'tinggi_fundus_uteri', 'letak_janin', 'denyut_jantung_janin', 'diberikan_tablet_tambah_darah', 'konseling'],
            'Trimester 3': ['tekanan_darah', 'tinggi_fundus_uteri', 'letak_janin', 'denyut_jantung_janin', 'diberikan_tablet_tambah_darah', 'konseling']
        };

        const infoTexts = {
            'Trimester 1': {
                title: 'Fokus Trimester 1 (0-12 Minggu)',
                desc: 'Memastikan kondisi awal kehamilan dan skrining komplikasi dini.',
                jadwal: '1-2 kali (termasuk 1 kali bersama bidan dan USG)'
            },
            'Trimester 2': {
                title: 'Fokus Trimester 2 (13-28 Minggu)',
                desc: 'Memantau perkembangan bentuk fisik dan organ janin.',
                jadwal: 'Minimal 1-2 kali'
            },
            'Trimester 3': {
                title: 'Fokus Trimester 3 (29-40 Minggu)',
                desc: 'Mempersiapkan persalinan, memantau posisi akhir janin, dan deteksi dini risiko prematur.',
                jadwal: 'Minimal 3 kali (termasuk 1 kali pemeriksaan bidan di akhir trimester)'
            }
        };

        
    window.setWaktuSekarang = function() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('waktu_pemeriksaan').value = `${hours}:${minutes}`;
    }

    function updateUI() {
            const val = select.value;
            
            // Clear all badges
            document.querySelectorAll('.req-badge').forEach(el => el.remove());

            if (val && infoTexts[val]) {
                const info = infoTexts[val];
                infoBox.innerHTML = `
                    <div class="mt-4 p-4 bg-teal-50 border border-teal-500 rounded-xl border-l-4">
                        <p class="font-bold text-teal-800 text-sm mb-1">${info.title}</p>
                        <p class="text-teal-700 text-xs mb-1"><strong>Jadwal Wajib:</strong> ${info.jadwal}</p>
                        <p class="text-teal-700 text-xs"><strong>Fokus Utama:</strong> ${info.desc}</p>
                    </div>
                `;
                infoBox.style.display = 'block';

                // Add badges
                requiredFields[val].forEach(fieldName => {
                    let input = document.querySelector(`[name="${fieldName}"]`);
                    if (!input) {
                        input = document.getElementById(fieldName);
                    }
                    if (input) {
                        let label;
                        if (input.type === 'checkbox') {
                            label = input.nextElementSibling;
                        } else if (input.tagName === 'SELECT' || input.tagName === 'TEXTAREA' || input.tagName === 'INPUT') {
                            label = input.closest('div').querySelector('label');
                        }
                        
                        if (label && !label.querySelector('.req-badge')) {
                            label.innerHTML += ' <span class="req-badge inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-700 ml-1">FOKUS WAJIB</span>';
                        }
                    }
                });
            } else {
                infoBox.style.display = 'none';
                infoBox.innerHTML = '';
            }
        }

        select.addEventListener('change', updateUI);
        updateUI();
    });

    function toggleLabFields() {
        const checkbox = document.getElementById('rujuk_laboratorium');
        const container = document.getElementById('lab_fields_container');
        const btnCetak = document.getElementById('btn_cetak_lab');
        if (checkbox && container) {
            if (checkbox.checked) {
                container.style.display = 'grid';
                if(btnCetak) btnCetak.style.display = 'block';
                const selects = container.querySelectorAll('select');
                selects.forEach(sel => sel.required = true);
                const inputs = container.querySelectorAll('input');
                inputs.forEach(inp => inp.required = true);
            } else {
                container.style.display = 'none';
                if(btnCetak) btnCetak.style.display = 'none';
                
                // Remove required
                const selects = container.querySelectorAll('select');
                selects.forEach(sel => { sel.value = ''; sel.required = false; });
                
                // Reset all inputs inside to empty
                const inputs = container.querySelectorAll('input');
                inputs.forEach(inp => { inp.value = ''; inp.required = false; });
            }

        }
    }
</script>
@endpush
@endsection

