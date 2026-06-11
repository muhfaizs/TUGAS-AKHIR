@extends('layouts.dashboard')

@section('title', 'Tambah Jadwal Posyandu')
@section('page_title', 'Tambah Jadwal Posyandu')
@section('page_subtitle', 'Masukkan detail jadwal kegiatan posyandu baru')

@section('content')
<div style="background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); padding: 32px; max-width: 800px; margin: 0 auto;">
    <form action="{{ route('kader.jadwal.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="tanggal" style="display: block; margin-bottom: 8px; font-weight: 600; color: #334155;">Tanggal <span style="color: #EF4444;">*</span></label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required class="form-input" style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 12px; outline: none; transition: border-color 0.2s;">
                @error('tanggal')
                    <span style="color: #EF4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="waktu_mulai" style="display: block; margin-bottom: 8px; font-weight: 600; color: #334155;">Waktu Mulai <span style="color: #EF4444;">*</span></label>
                <input type="time" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai', '08:00') }}" required class="form-input" style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 12px; outline: none;">
                @error('waktu_mulai')
                    <span style="color: #EF4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="waktu_selesai" style="display: block; margin-bottom: 8px; font-weight: 600; color: #334155;">Waktu Selesai <span style="color: #EF4444;">*</span></label>
                <input type="time" id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai', '12:00') }}" required class="form-input" style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 12px; outline: none;">
                @error('waktu_selesai')
                    <span style="color: #EF4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="lokasi" style="display: block; margin-bottom: 8px; font-weight: 600; color: #334155;">Lokasi <span style="color: #EF4444;">*</span></label>
                <select id="lokasi" name="lokasi" required class="form-input" style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 12px; outline: none; font-family: inherit; appearance: none; background: url('data:image/svg+xml;utf8,<svg viewBox=\&quot;0 0 24 24\&quot; fill=\&quot;%2394A3B8\&quot; xmlns=\&quot;http://www.w3.org/2000/svg\&quot;><path d=\&quot;M7 10l5 5 5-5z\&quot;/></svg>') no-repeat right 12px center; background-color: #fff; background-size: 24px;">
                    <option value="{{ $posyanduName }}" {{ old('lokasi') == $posyanduName ? 'selected' : '' }}>{{ $posyanduName }} (Default)</option>
                    <option value="Balai Desa / Balai RW" {{ old('lokasi') == 'Balai Desa / Balai RW' ? 'selected' : '' }}>Balai Desa / Balai RW</option>
                    <option value="Puskesmas Pembantu" {{ old('lokasi') == 'Puskesmas Pembantu' ? 'selected' : '' }}>Puskesmas Pembantu</option>
                    <option value="Rumah Kader / Ketua RT" {{ old('lokasi') == 'Rumah Kader / Ketua RT' ? 'selected' : '' }}>Rumah Kader / Ketua RT</option>
                </select>
                @error('lokasi')
                    <span style="color: #EF4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="keterangan" style="display: block; margin-bottom: 8px; font-weight: 600; color: #334155;">Keterangan / Catatan Tambahan <span style="color: #94A3B8; font-weight: normal;">(Opsional)</span></label>
                <textarea id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Harap membawa buku KIA dan fotokopi KK" class="form-input" style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 12px; outline: none; font-family: inherit;">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <span style="color: #EF4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 1px solid #F1F5F9;">
            <a href="{{ route('kader.jadwal.index') }}" style="padding: 12px 24px; background: #F1F5F9; color: #475569; border-radius: 12px; font-weight: 600; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#E2E8F0'" onmouseout="this.style.background='#F1F5F9'">
                Batal
            </a>
            <button type="submit" style="padding: 12px 24px; background: #0D9488; color: #fff; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#0F766E'" onmouseout="this.style.background='#0D9488'">
                Simpan Jadwal
            </button>
        </div>
    </form>
</div>
@endsection
