@extends('layouts.dashboard')

@section('title', 'Edit Tindakan Medis')
@section('page_title', 'Edit Tindakan Medis')
@section('page_subtitle', 'Perbarui hasil pemeriksaan atau tindakan medis anak')

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
        <form method="POST" action="{{ route('bidan.tindakan.update', $tindakan) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="id_anak">Pilih Anak <span class="required">*</span></label>
                <select id="id_anak" name="id_anak" required class="form-input" style="appearance: none; background: url('data:image/svg+xml;utf8,<svg viewBox=\"0 0 24 24\" fill=\"%2394A3B8\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>') no-repeat right 12px center; background-color: #fff; background-size: 24px;">
                    <option value="">-- Pilih Anak --</option>
                    @foreach($anakList as $anak)
                        <option value="{{ $anak->id_anak }}" {{ old('id_anak', $tindakan->id_anak) == $anak->id_anak ? 'selected' : '' }}>
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
                        <option value="{{ $p->id }}" {{ old('puskesmas_id', $tindakan->puskesmas_id) == $p->id ? 'selected' : '' }}>
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
                        <option value="{{ $p->id }}" {{ old('posyandu_id', $tindakan->posyandu_id) == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_posyandu }} ({{ $p->puskesmas->nama_puskesmas }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-4">
                <label for="tanggal_pemeriksaan">Tanggal Pemeriksaan <span class="required">*</span></label>
                <input type="date" id="tanggal_pemeriksaan" name="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan', $tindakan->tanggal_pemeriksaan->format('Y-m-d')) }}" required max="{{ date('Y-m-d') }}" class="form-input">
            </div>

            <div class="form-group mt-4">
                <label for="suhu_tubuh">Suhu Tubuh (°C) <span class="required">*</span></label>
                <input type="number" step="0.1" id="suhu_tubuh" name="suhu_tubuh" value="{{ old('suhu_tubuh', $tindakan->suhu_tubuh) }}" required min="30" max="45" class="form-input" placeholder="Misal: 36.5">
            </div>

            <div class="form-group mt-4">
                <label for="diagnosa">Diagnosa <span class="required">*</span></label>
                <input type="text" id="diagnosa" name="diagnosa" value="{{ old('diagnosa', $tindakan->diagnosa) }}" required class="form-input" placeholder="Masukkan diagnosa klinis">
            </div>

            <div class="form-group mt-4">
                <label for="resep_obat">Resep Obat <span class="required">*</span></label>
                <input type="text" id="resep_obat" name="resep_obat" value="{{ old('resep_obat', $tindakan->resep_obat) }}" required class="form-input" placeholder="Masukkan resep obat yang diberikan">
            </div>

            <div class="form-group mt-4">
                <label for="catatan_pemeriksaan">Catatan Pemeriksaan / Tindakan <span class="required">*</span></label>
                <textarea id="catatan_pemeriksaan" name="catatan_pemeriksaan" required class="form-input" rows="4" placeholder="Detail hasil pemeriksaan, tindakan yang diberikan...">{{ old('catatan_pemeriksaan', $tindakan->catatan_pemeriksaan) }}</textarea>
            </div>

            <div class="form-footer">
                <a href="{{ route('bidan.tindakan.index') }}" class="btn-prev">Batal</a>
                <div class="spacer"></div>
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
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
