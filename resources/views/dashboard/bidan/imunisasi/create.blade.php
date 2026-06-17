@extends('layouts.dashboard')

@section('title', 'Tambah Imunisasi Anak')
@section('page_title', 'Tambah Imunisasi Anak')
@section('page_subtitle', 'Catat pemberian vaksin dan imunisasi pada anak')

@section('content')
<div class="form-container">
    @if ($errors->any())
        <div class="form-errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('bidan.imunisasi.store') }}">
            @csrf

            <div class="form-group">
                <label for="id_anak">Pilih Anak <span class="required">*</span></label>
                <select id="id_anak" name="id_anak" required class="form-input" style="appearance: none; background: url('data:image/svg+xml;utf8,<svg viewBox=\"0 0 24 24\" fill=\"%2394A3B8\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>') no-repeat right 12px center; background-color: #fff; background-size: 24px;">
                    <option value="">-- Pilih Anak --</option>
                    @foreach($anakList as $anak)
                        <option value="{{ $anak->id_anak }}" {{ old('id_anak') == $anak->id_anak ? 'selected' : '' }}>
                            {{ $anak->nama_anak }} (NIK: {{ $anak->nik_anak ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-4">
                <label for="puskesmas_id">Puskesmas <span class="required">*</span></label>
                <select id="puskesmas_id" name="puskesmas_id" required class="form-input" style="appearance: none; background: url('data:image/svg+xml;utf8,<svg viewBox=\"0 0 24 24\" fill=\"%2394A3B8\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>') no-repeat right 12px center; background-color: #fff; background-size: 24px;">
                    <option value="">-- Pilih Puskesmas --</option>
                    @foreach($puskesmasList as $p)
                        <option value="{{ $p->id }}" {{ old('puskesmas_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_puskesmas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-4">
                <label for="posyandu_id">Posyandu <span class="required">*</span></label>
                <select id="posyandu_id" name="posyandu_id" required class="form-input" style="appearance: none; background: url('data:image/svg+xml;utf8,<svg viewBox=\"0 0 24 24\" fill=\"%2394A3B8\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>') no-repeat right 12px center; background-color: #fff; background-size: 24px;">
                    <option value="">-- Pilih Posyandu --</option>
                    @foreach($posyanduList as $p)
                        <option value="{{ $p->id }}" {{ old('posyandu_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_posyandu }} ({{ $p->puskesmas->nama_puskesmas }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-4">
                <label for="nama_vaksin">Nama Vaksin <span class="required">*</span></label>
                <select id="nama_vaksin" name="nama_vaksin" required class="form-input" style="appearance: none; background: url('data:image/svg+xml;utf8,<svg viewBox=\"0 0 24 24\" fill=\"%2394A3B8\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>') no-repeat right 12px center; background-color: #fff; background-size: 24px;">
                    <option value="">-- Pilih Vaksin --</option>
                    <option value="Hepatitis B0" {{ old('nama_vaksin') == 'Hepatitis B0' ? 'selected' : '' }}>Hepatitis B0</option>
                    <option value="BCG" {{ old('nama_vaksin') == 'BCG' ? 'selected' : '' }}>BCG</option>
                    <option value="Polio 1" {{ old('nama_vaksin') == 'Polio 1' ? 'selected' : '' }}>Polio 1</option>
                    <option value="Polio 2" {{ old('nama_vaksin') == 'Polio 2' ? 'selected' : '' }}>Polio 2</option>
                    <option value="Polio 3" {{ old('nama_vaksin') == 'Polio 3' ? 'selected' : '' }}>Polio 3</option>
                    <option value="Polio 4" {{ old('nama_vaksin') == 'Polio 4' ? 'selected' : '' }}>Polio 4</option>
                    <option value="DPT-HB-Hib 1" {{ old('nama_vaksin') == 'DPT-HB-Hib 1' ? 'selected' : '' }}>DPT-HB-Hib 1</option>
                    <option value="DPT-HB-Hib 2" {{ old('nama_vaksin') == 'DPT-HB-Hib 2' ? 'selected' : '' }}>DPT-HB-Hib 2</option>
                    <option value="DPT-HB-Hib 3" {{ old('nama_vaksin') == 'DPT-HB-Hib 3' ? 'selected' : '' }}>DPT-HB-Hib 3</option>
                    <option value="Campak / MR" {{ old('nama_vaksin') == 'Campak / MR' ? 'selected' : '' }}>Campak / MR</option>
                </select>
            </div>

            <div class="form-group mt-4">
                <label for="batch_vaksin">Nomor Batch Vaksin <span class="required">*</span></label>
                <input type="text" id="batch_vaksin" name="batch_vaksin" value="{{ old('batch_vaksin') }}" required class="form-input" placeholder="Misal: VAX-2026-X">
            </div>

            <div class="form-group mt-4">
                <label for="lokasi_suntikan">Lokasi Penyuntikan / Pemberian <span class="required">*</span></label>
                <select id="lokasi_suntikan" name="lokasi_suntikan" required class="form-input" style="appearance: none; background: url('data:image/svg+xml;utf8,<svg viewBox=\"0 0 24 24\" fill=\"%2394A3B8\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>') no-repeat right 12px center; background-color: #fff; background-size: 24px;">
                    <option value="">-- Pilih Lokasi --</option>
                    <option value="Paha Kiri Atas" {{ old('lokasi_suntikan') == 'Paha Kiri Atas' ? 'selected' : '' }}>Paha Kiri Atas</option>
                    <option value="Paha Kanan Atas" {{ old('lokasi_suntikan') == 'Paha Kanan Atas' ? 'selected' : '' }}>Paha Kanan Atas</option>
                    <option value="Lengan Kiri" {{ old('lokasi_suntikan') == 'Lengan Kiri' ? 'selected' : '' }}>Lengan Kiri</option>
                    <option value="Lengan Kanan" {{ old('lokasi_suntikan') == 'Lengan Kanan' ? 'selected' : '' }}>Lengan Kanan</option>
                    <option value="Oral (Mulut)" {{ old('lokasi_suntikan') == 'Oral (Mulut)' ? 'selected' : '' }}>Oral (Mulut)</option>
                </select>
            </div>

            <div class="form-group mt-4">
                <label for="suhu_tubuh">Suhu Tubuh Sebelum Vaksin (°C) <span class="required">*</span></label>
                <input type="number" step="0.1" id="suhu_tubuh" name="suhu_tubuh" value="{{ old('suhu_tubuh') }}" required min="30" max="45" class="form-input" placeholder="Misal: 36.5">
            </div>

            <div class="form-group mt-4">
                <label for="tanggal_pemberian">Tanggal Pemberian <span class="required">*</span></label>
                <input type="date" id="tanggal_pemberian" name="tanggal_pemberian" value="{{ old('tanggal_pemberian', date('Y-m-d')) }}" required max="{{ date('Y-m-d') }}" class="form-input">
            </div>

            <div class="form-group mt-4">
                <label for="catatan">Catatan / Edukasi Pasca Vaksin <span class="required">*</span></label>
                <textarea id="catatan" name="catatan" required class="form-input" rows="3" placeholder="Misal: Edukasi jika anak demam, berikan paracetamol...">{{ old('catatan') }}</textarea>
            </div>

            <div class="form-footer">
                <a href="{{ route('bidan.imunisasi.index') }}" class="btn-prev">Batal</a>
                <div class="spacer"></div>
                <button type="submit" class="btn-submit">Simpan Imunisasi</button>
            </div>
        </form>
    </div>
</div>

<style>
.form-container { max-width: 700px; margin: 0 auto; }
.form-card {
    background: #fff; border-radius: 20px; padding: 32px;
    box-shadow: 0 4px 20px rgba(13,148,136,0.06); border: 1px solid rgba(15,23,42,0.06);
}
.form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
.mt-4 { margin-top: 16px; }
.form-group label { font-size: 13px; font-weight: 600; color: #1E293B; }
.required { color: #EF4444; }
.form-input {
    padding: 12px 16px; border-radius: 12px; border: 1px solid rgba(15,23,42,0.15);
    font-size: 14px; font-family: inherit; transition: all 0.2s; outline: none; background: #fff; width: 100%; box-sizing: border-box;
}
.form-input:focus { border-color: var(--kia-primary); box-shadow: 0 0 0 3px rgba(13,148,136,0.1); }

.form-footer { display: flex; align-items: center; margin-top: 32px; padding-top: 24px; border-top: 1px solid rgba(15,23,42,0.06); }
.spacer { flex: 1; }
.btn-prev {
    padding: 12px 24px; border-radius: 12px; background: #fff; color: #475569; text-decoration: none;
    border: 1px solid rgba(15,23,42,0.15); font-weight: 600; cursor: pointer; transition: all 0.2s;
}
.btn-prev:hover { background: rgba(15,23,42,0.02); color: #0F172A; }
.btn-submit {
    padding: 12px 24px; border-radius: 12px; background: var(--kia-primary); color: #fff;
    border: none; font-weight: 600; cursor: pointer; transition: all 0.2s;
}
.btn-submit:hover { background: var(--kia-primary-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(13,148,136,0.2); }

.form-errors { margin-bottom: 24px; padding: 16px; border-radius: 12px; background: rgba(239,68,68,0.08); color: #B91C1C; }
.form-errors ul { margin: 0; padding-left: 20px; font-size: 13px; }
</style>
@endsection
