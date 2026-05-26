@extends('layouts.dashboard')

@section('title', 'Daftarkan Anak')
@section('page_title', 'Registrasi Anak')
@section('page_subtitle', 'Masukkan data anak Anda dengan lengkap dan benar')

@section('content')
<div class="wizard-container" x-data="anakWizard()" x-cloak>
    
    <!-- Wizard Progress -->
    <div class="wizard-progress">
        <div class="progress-steps">
            <div class="step" :class="{ 'active': step >= 1, 'completed': step > 1 }">
                <div class="step-circle">1</div>
                <div class="step-label">Data Dasar</div>
            </div>
            <div class="step-line" :class="{ 'active': step > 1 }"></div>
            <div class="step" :class="{ 'active': step >= 2, 'completed': step > 2 }">
                <div class="step-circle">2</div>
                <div class="step-label">Kelahiran</div>
            </div>
            <div class="step-line" :class="{ 'active': step > 2 }"></div>
            <div class="step" :class="{ 'active': step >= 3, 'completed': step > 3 }">
                <div class="step-circle">3</div>
                <div class="step-label">Keluarga</div>
            </div>
        </div>
    </div>

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
        <form method="POST" action="{{ route('orangtua.anak.store') }}" id="form-anak">
            @csrf

            <!-- Step 1: Data Dasar -->
            <div x-show="step === 1" x-transition:enter="slide-in" class="wizard-step">
                <h3 class="step-title">Informasi Dasar Anak</h3>
                <p class="step-desc">Silakan lengkapi informasi dasar anak Anda.</p>

                <div class="form-group">
                    <label for="nik_anak">NIK Anak <span class="required">*</span></label>
                    <input type="text" id="nik_anak" name="nik_anak" value="{{ old('nik_anak') }}" required maxlength="16" minlength="16" class="form-input" placeholder="Masukkan 16 digit NIK">
                </div>
                <div class="form-group">
                    <label for="nama_anak">Nama Lengkap Anak <span class="required">*</span></label>
                    <input type="text" id="nama_anak" name="nama_anak" value="{{ old('nama_anak') }}" required class="form-input" placeholder="Nama sesuai akta kelahiran">
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                    <div class="radio-group">
                        <label class="radio-card">
                            <input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} required>
                            <span class="radio-content">
                                <span class="radio-icon boy">👦</span>
                                <span class="radio-label">Laki-laki</span>
                            </span>
                        </label>
                        <label class="radio-card">
                            <input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }} required>
                            <span class="radio-content">
                                <span class="radio-icon girl">👧</span>
                                <span class="radio-label">Perempuan</span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Step 2: Data Kelahiran -->
            <div x-show="step === 2" x-transition:enter="slide-in" class="wizard-step" style="display: none;">
                <h3 class="step-title">Data Kelahiran</h3>
                <p class="step-desc">Detail informasi saat anak dilahirkan.</p>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir <span class="required">*</span></label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required class="form-input" placeholder="Kota/Kabupaten">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir <span class="required">*</span></label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required max="{{ date('Y-m-d') }}" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="berat_lahir">Berat Lahir (kg) <span class="required">*</span></label>
                        <input type="number" step="0.01" id="berat_lahir" name="berat_lahir" value="{{ old('berat_lahir') }}" required class="form-input" placeholder="Contoh: 3.2">
                    </div>
                    <div class="form-group">
                        <label for="panjang_lahir">Panjang Lahir (cm) <span class="required">*</span></label>
                        <input type="number" step="0.1" id="panjang_lahir" name="panjang_lahir" value="{{ old('panjang_lahir') }}" required class="form-input" placeholder="Contoh: 49.5">
                    </div>
                </div>
            </div>

            <!-- Step 3: Keluarga & Catatan -->
            <div x-show="step === 3" x-transition:enter="slide-in" class="wizard-step" style="display: none;">
                <h3 class="step-title">Informasi Tambahan</h3>
                <p class="step-desc">Data orang tua dan catatan tambahan.</p>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="nama_ayah">Nama Ayah</label>
                        <input type="text" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}" class="form-input" placeholder="Masukkan nama ayah">
                    </div>
                    <div class="form-group">
                        <label for="nama_ibu">Nama Ibu</label>
                        <input type="text" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}" class="form-input" placeholder="Masukkan nama ibu">
                    </div>
                </div>
                <div class="form-group mt-4">
                    <label for="catatan">Catatan / Alergi (opsional)</label>
                    <textarea id="catatan" name="catatan" class="form-input" rows="3" placeholder="Tambahkan catatan khusus jika ada...">{{ old('catatan') }}</textarea>
                </div>
            </div>

            <!-- Wizard Footer -->
            <div class="wizard-footer">
                <button type="button" class="btn-prev" x-show="step > 1" @click="prevStep()">Kembali</button>
                <div class="spacer"></div>
                <button type="button" class="btn-next" x-show="step < 3" @click="nextStep()">Lanjut</button>
                <button type="submit" class="btn-submit" x-show="step === 3">Simpan Data Anak</button>
            </div>
        </form>
    </div>
</div>

<script>
function anakWizard() {
    return {
        step: {{ $errors->any() ? 3 : 1 }},
        nextStep() {
            if (this.step < 3) this.step++;
        },
        prevStep() {
            if (this.step > 1) this.step--;
        }
    }
}
</script>

<style>
.wizard-container { max-width: 700px; margin: 0 auto; }

/* Progress */
.wizard-progress { margin-bottom: 32px; padding: 0 20px; }
.progress-steps { display: flex; align-items: center; justify-content: space-between; }
.step { display: flex; flex-direction: column; align-items: center; gap: 8px; position: relative; z-index: 2; }
.step-circle {
    width: 40px; height: 40px; border-radius: 50%; background: #fff; border: 2px solid #CBD5E1;
    display: grid; place-items: center; font-weight: 700; color: #94A3B8; transition: all 0.3s;
}
.step.active .step-circle { border-color: var(--kia-primary); color: var(--kia-primary); }
.step.completed .step-circle { background: var(--kia-primary); border-color: var(--kia-primary); color: #fff; }
.step-label { font-size: 13px; font-weight: 600; color: #94A3B8; transition: all 0.3s; }
.step.active .step-label { color: #0F172A; }

.step-line { flex: 1; height: 2px; background: #CBD5E1; margin: 0 -10px 24px; position: relative; z-index: 1; transition: all 0.3s; }
.step-line.active { background: var(--kia-primary); }

.wizard-card {
    background: #fff; border-radius: 20px; padding: 32px;
    box-shadow: 0 4px 20px rgba(13,148,136,0.06); border: 1px solid rgba(15,23,42,0.06);
}

.step-title { font-size: 20px; font-weight: 700; color: #0F172A; margin: 0 0 8px; }
.step-desc { font-size: 14px; color: #64748B; margin: 0 0 24px; }

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

/* Radio Cards */
.radio-group { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.radio-card input { display: none; }
.radio-content {
    display: flex; flex-direction: column; align-items: center; gap: 12px; padding: 20px;
    border: 2px solid rgba(15,23,42,0.1); border-radius: 16px; cursor: pointer; transition: all 0.2s;
}
.radio-card input:checked + .radio-content { border-color: var(--kia-primary); background: rgba(240,253,250,0.5); box-shadow: 0 4px 12px rgba(13,148,136,0.1); }
.radio-icon { font-size: 32px; line-height: 1; }
.radio-label { font-size: 15px; font-weight: 600; color: #1E293B; }

.wizard-footer { display: flex; align-items: center; margin-top: 32px; padding-top: 24px; border-top: 1px solid rgba(15,23,42,0.06); }
.spacer { flex: 1; }
.btn-prev {
    padding: 12px 24px; border-radius: 12px; background: #fff; color: #475569;
    border: 1px solid rgba(15,23,42,0.15); font-weight: 600; cursor: pointer; transition: all 0.2s;
}
.btn-prev:hover { background: rgba(15,23,42,0.02); color: #0F172A; }
.btn-next, .btn-submit {
    padding: 12px 24px; border-radius: 12px; background: var(--kia-primary); color: #fff;
    border: none; font-weight: 600; cursor: pointer; transition: all 0.2s;
}
.btn-next:hover, .btn-submit:hover { background: var(--kia-primary-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(13,148,136,0.2); }

.wizard-errors { margin-bottom: 24px; padding: 16px; border-radius: 12px; background: rgba(239,68,68,0.08); color: #B91C1C; }
.wizard-errors ul { margin: 0; padding-left: 20px; font-size: 13px; }

/* Transitions */
.slide-in-enter-active, .slide-in-leave-active { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
.slide-in-enter-from { opacity: 0; transform: translateX(20px); }
.slide-in-leave-to { opacity: 0; transform: translateX(-20px); position: absolute; }

@media (max-width: 640px) {
    .form-grid { grid-template-columns: 1fr; }
    .wizard-card { padding: 24px; }
}
</style>
@endsection
