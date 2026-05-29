@extends('layouts.dashboard')

@section('title', 'Edit Data Anak')
@section('page_title', 'Edit Data Anak')
@section('page_subtitle', 'Perbarui informasi anak Anda')

@section('content')
<div class="wizard-container">
    @php
        $routePrefix = auth()->user()->isOrangTua() ? 'orangtua' : (auth()->user()->isBidan() ? 'bidan' : 'admin');
    @endphp
    @if ($errors->any())
        <div class="wizard-errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="wizard-card">
        <form method="POST" action="{{ route($routePrefix . '.anak.update', $anak) }}">
            @csrf
            @method('PUT')

            <h3 class="step-title">Informasi Dasar</h3>
            @if(!auth()->user()->isOrangTua())
            <div class="form-group mt-4">
                <label for="id_user">Pilih Orang Tua <span class="required">*</span></label>
                <select id="id_user" name="id_user" required class="form-input" style="appearance: none; background: url('data:image/svg+xml;utf8,<svg viewBox=\"0 0 24 24\" fill=\"%2394A3B8\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>') no-repeat right 12px center; background-color: #fff; background-size: 24px;">
                    <option value="">-- Pilih Orang Tua --</option>
                    @foreach($orangTuaList as $ortu)
                        <option value="{{ $ortu->id_user }}" {{ old('id_user', $anak->id_user) == $ortu->id_user ? 'selected' : '' }}>
                            {{ $ortu->nama_lengkap }} (NIK: {{ $ortu->nik_ortu ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="form-group mt-4">
                <label for="nik_anak">NIK Anak <span class="required">*</span></label>
                <input type="text" id="nik_anak" name="nik_anak" value="{{ old('nik_anak', $anak->nik_anak) }}" required maxlength="16" minlength="16" class="form-input">
            </div>
            <div class="form-group">
                <label for="nama_anak">Nama Lengkap Anak <span class="required">*</span></label>
                <input type="text" id="nama_anak" name="nama_anak" value="{{ old('nama_anak', $anak->nama_anak) }}" required class="form-input">
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="anak_ke">Anak Ke (opsional)</label>
                    <input type="number" id="anak_ke" name="anak_ke" value="{{ old('anak_ke', $anak->anak_ke) }}" min="1" class="form-input">
                </div>
                <div class="form-group">
                    <label for="no_bpjs">Nomor BPJS (opsional)</label>
                    <input type="text" id="no_bpjs" name="no_bpjs" value="{{ old('no_bpjs', $anak->no_bpjs) }}" class="form-input">
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-input" required>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $anak->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $anak->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="golongan_darah">Golongan Darah (opsional)</label>
                    <select id="golongan_darah" name="golongan_darah" class="form-input" style="appearance: none; background: url('data:image/svg+xml;utf8,<svg viewBox=\"0 0 24 24\" fill=\"%2394A3B8\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>') no-repeat right 12px center; background-color: #fff; background-size: 24px;">
                        <option value="">-- Pilih Golongan Darah --</option>
                        <option value="A" {{ old('golongan_darah', $anak->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah', $anak->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah', $anak->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah', $anak->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                        <option value="Tidak Tahu" {{ old('golongan_darah', $anak->golongan_darah) == 'Tidak Tahu' ? 'selected' : '' }}>Tidak Tahu</option>
                    </select>
                </div>
            </div>

            <hr class="my-6">
            <h3 class="step-title">Data Kelahiran</h3>
            <div class="form-grid mt-4">
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir <span class="required">*</span></label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $anak->tempat_lahir) }}" required class="form-input">
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir <span class="required">*</span></label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $anak->tanggal_lahir->format('Y-m-d')) }}" required max="{{ date('Y-m-d') }}" class="form-input">
                </div>
                <div class="form-group">
                    <label for="berat_lahir">Berat Lahir (kg) <span class="required">*</span></label>
                    <input type="number" step="0.01" id="berat_lahir" name="berat_lahir" value="{{ old('berat_lahir', $anak->berat_lahir) }}" required class="form-input">
                </div>
                <div class="form-group">
                    <label for="panjang_lahir">Panjang Lahir (cm) <span class="required">*</span></label>
                    <input type="number" step="0.1" id="panjang_lahir" name="panjang_lahir" value="{{ old('panjang_lahir', $anak->panjang_lahir) }}" required class="form-input">
                </div>
                <div class="form-group">
                    <label for="lingkar_kepala_lahir">Lingkar Kepala Lahir (cm) (opsional)</label>
                    <input type="number" step="0.1" id="lingkar_kepala_lahir" name="lingkar_kepala_lahir" value="{{ old('lingkar_kepala_lahir', $anak->lingkar_kepala_lahir) }}" class="form-input">
                </div>
                <div class="form-group">
                    <label for="kondisi_lahir">Kondisi Lahir (opsional)</label>
                    <select id="kondisi_lahir" name="kondisi_lahir" class="form-input" style="appearance: none; background: url('data:image/svg+xml;utf8,<svg viewBox=\"0 0 24 24\" fill=\"%2394A3B8\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>') no-repeat right 12px center; background-color: #fff; background-size: 24px;">
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="Normal" {{ old('kondisi_lahir', $anak->kondisi_lahir) == 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Prematur" {{ old('kondisi_lahir', $anak->kondisi_lahir) == 'Prematur' ? 'selected' : '' }}>Prematur</option>
                        <option value="Cacat Bawaan" {{ old('kondisi_lahir', $anak->kondisi_lahir) == 'Cacat Bawaan' ? 'selected' : '' }}>Cacat Bawaan</option>
                        <option value="Lainnya" {{ old('kondisi_lahir', $anak->kondisi_lahir) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
            </div>

            <hr class="my-6">
            <h3 class="step-title">Keluarga & Catatan</h3>
            <div class="form-grid mt-4">
                <div class="form-group">
                    <label for="nama_ayah">Nama Ayah</label>
                    <input type="text" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $anak->nama_ayah) }}" class="form-input">
                </div>
                <div class="form-group">
                    <label for="nama_ibu">Nama Ibu</label>
                    <input type="text" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $anak->nama_ibu) }}" class="form-input">
                </div>
            </div>
            <div class="form-group mt-4">
                <label for="riwayat_alergi">Riwayat Alergi (opsional)</label>
                <textarea id="riwayat_alergi" name="riwayat_alergi" class="form-input" rows="2">{{ old('riwayat_alergi', $anak->riwayat_alergi) }}</textarea>
            </div>
            <div class="form-group">
                <label for="catatan">Catatan Tambahan (opsional)</label>
                <textarea id="catatan" name="catatan" class="form-input" rows="2">{{ old('catatan', $anak->catatan) }}</textarea>
            </div>

            <div class="wizard-footer">
                <a href="{{ route($routePrefix . '.anak.index') }}" class="btn-prev">Batal</a>
                <div class="spacer"></div>
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<style>
.wizard-container { max-width: 700px; margin: 0 auto; }
.wizard-card {
    background: #fff; border-radius: 20px; padding: 32px;
    box-shadow: 0 4px 20px rgba(13,148,136,0.06); border: 1px solid rgba(15,23,42,0.06);
}
.step-title { font-size: 18px; font-weight: 700; color: #0F172A; margin: 0; }
.my-6 { margin: 32px 0; border: none; border-top: 1px solid rgba(15,23,42,0.06); }

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
.mt-4 { margin-top: 16px; }
.form-group label { font-size: 13px; font-weight: 600; color: #1E293B; }
.required { color: #EF4444; }
.form-input {
    padding: 12px 16px; border-radius: 12px; border: 1px solid rgba(15,23,42,0.15);
    font-size: 14px; font-family: inherit; transition: all 0.2s; outline: none; background: #fff;
}
.form-input:focus { border-color: var(--kia-primary); box-shadow: 0 0 0 3px rgba(13,148,136,0.1); }

.wizard-footer { display: flex; align-items: center; margin-top: 32px; padding-top: 24px; border-top: 1px solid rgba(15,23,42,0.06); }
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

.wizard-errors { margin-bottom: 24px; padding: 16px; border-radius: 12px; background: rgba(239,68,68,0.08); color: #B91C1C; }
.wizard-errors ul { margin: 0; padding-left: 20px; font-size: 13px; }

@media (max-width: 640px) {
    .form-grid { grid-template-columns: 1fr; }
    .wizard-card { padding: 24px; }
}
</style>
@endsection
