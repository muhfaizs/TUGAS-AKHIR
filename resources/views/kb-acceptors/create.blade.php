@extends('layouts.app')

@section('title', 'Tambah Pasien KB - SatuKIA')
@section('header_title', 'Tambah Pasien KB')
@section('header_subtitle', 'Masukkan data diri pasien KB baru')

@section('content')
<style>
    .form-wrapper { padding: 40px 20px; display: flex; align-items: center; justify-content: center; min-height: calc(100vh - 120px); }
    .form-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        width: 100%;
        max-width: 900px;
        padding: 40px;
    }
    .form-section-title { font-size: 18px; font-weight: 700; color: #111827; margin-bottom: 24px; margin-top: 40px; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px; }
    .form-section-title:first-child { margin-top: 0; }
    
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }
    @media(max-width:768px){ .form-grid-2 { grid-template-columns:1fr; } }

    .f-group label {
        display: block; font-size: 13.5px; font-weight: 600; color: #374151; margin-bottom: 8px;
    }
    .f-input {
        width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 10px;
        font-size: 14px; font-family:'Inter',sans-serif; color:#111827;
        background: #fff; outline: none; transition: border-color .2s;
    }
    textarea.f-input { min-height: 100px; resize: vertical; }
    .f-input::placeholder { color:#9ca3af; }
    .f-input:focus { border-color:#34988e; box-shadow:0 0 0 3px rgba(52,152,142,.10); }

    .btn-row { display:flex; justify-content:flex-end; gap:16px; margin-top:40px; border-top: 1px solid #e5e7eb; padding-top: 24px; }

    .btn-cancel {
        padding: 12px 32px; background: #fff; border: 1px solid #d1d5db; border-radius: 10px;
        font-size: 14px; font-weight: 600; color: #374151; font-family:'Inter',sans-serif;
        text-decoration:none; display:inline-flex; align-items:center; justify-content: center;
        transition:all .2s; cursor:pointer;
    }
    .btn-cancel:hover { background:#f9fafb; }

    .btn-save {
        padding: 12px 32px; background: #34988e; border: none; border-radius: 10px;
        font-size: 14px; font-weight: 600; color: #fff; font-family:'Inter',sans-serif;
        display:inline-flex; align-items:center; justify-content: center;
        transition:all .2s; cursor:pointer;
    }
    .btn-save:hover { background: #287d74; }
    .f-error { font-size: 12px; color: #ef4444; margin-top: 4px; }
</style>

<div class="form-wrapper">
    <div class="form-card">
        @if ($errors->any())
            <div style="background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; padding:16px; border-radius:10px; margin-bottom:24px;">
                <ul style="margin:0; padding-left:20px; list-style-type:disc;">
                    @foreach ($errors->all() as $error)
                        <li style="font-size:14px;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kb-acceptors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Data Identitas -->
            <div class="form-section-title">Data Identitas</div>
            
            <div class="form-grid-2">
                <div class="f-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" class="f-input" required>
                    @error('full_name')<div class="f-error">{{ $message }}</div>@enderror
                </div>
                <div class="f-group">
                    <label>NIK *</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" class="f-input" required>
                    @error('nik')<div class="f-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grid-2">
                <div class="f-group">
                    <label>Tanggal Lahir *</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="f-input" required>
                    @error('date_of_birth')<div class="f-error">{{ $message }}</div>@enderror
                </div>
                <div class="f-group">
                    <label>Usia (Tahun)</label>
                    <input type="number" name="age" value="{{ old('age') }}" min="0" max="150" class="f-input" placeholder="Otomatis terisi jika kosong">
                    @error('age')<div class="f-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grid-2">
                <div class="f-group">
                    <label>Jenis Kelamin *</label>
                    <select name="gender" class="f-input" required>
                        <option value="">Pilih...</option>
                        <option value="M" @selected(old('gender') == 'M')>Laki-laki</option>
                        <option value="F" @selected(old('gender') == 'F')>Perempuan</option>
                    </select>
                    @error('gender')<div class="f-error">{{ $message }}</div>@enderror
                </div>
                <div class="f-group">
                    <label>Status Perkawinan *</label>
                    <select name="marital_status" class="f-input" required>
                        <option value="">Pilih...</option>
                        <option value="Kawin" @selected(old('marital_status') == 'Kawin')>Kawin</option>
                        <option value="Belum Kawin" @selected(old('marital_status') == 'Belum Kawin')>Belum Kawin</option>
                        <option value="Cerai" @selected(old('marital_status') == 'Cerai')>Cerai</option>
                    </select>
                    @error('marital_status')<div class="f-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grid-2">
                <div class="f-group">
                    <label>Nomor Telepon *</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" class="f-input" required>
                    @error('phone')<div class="f-error">{{ $message }}</div>@enderror
                </div>
                <div class="f-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="f-input">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="f-group">
                    <label>Pendidikan</label>
                    <select name="education" class="f-input">
                        <option value="">Pilih...</option>
                        <option value="TK" @selected(old('education') == 'TK')>TK</option>
                        <option value="SD" @selected(old('education') == 'SD')>SD</option>
                        <option value="SMP" @selected(old('education') == 'SMP')>SMP</option>
                        <option value="SMA" @selected(old('education') == 'SMA')>SMA</option>
                        <option value="Diploma" @selected(old('education') == 'Diploma')>Diploma</option>
                        <option value="S1" @selected(old('education') == 'S1')>S1</option>
                        <option value="S2" @selected(old('education') == 'S2')>S2</option>
                    </select>
                </div>
                <div class="f-group">
                    <label>Pekerjaan</label>
                    <input type="text" name="occupation" value="{{ old('occupation') }}" class="f-input">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="f-group">
                    <label>Agama</label>
                    <select name="religion" class="f-input">
                        <option value="">Pilih...</option>
                        <option value="Islam" @selected(old('religion') == 'Islam')>Islam</option>
                        <option value="Kristen Protestan" @selected(old('religion') == 'Kristen Protestan')>Kristen Protestan</option>
                        <option value="Kristen Katolik" @selected(old('religion') == 'Kristen Katolik')>Kristen Katolik</option>
                        <option value="Hindu" @selected(old('religion') == 'Hindu')>Hindu</option>
                        <option value="Buddha" @selected(old('religion') == 'Buddha')>Buddha</option>
                        <option value="Konghucu" @selected(old('religion') == 'Konghucu')>Konghucu</option>
                    </select>
                </div>
                <div class="f-group">
                    <label>Golongan Darah</label>
                    <select name="blood_type" class="f-input">
                        <option value="">Pilih...</option>
                        <option value="O" @selected(old('blood_type') == 'O')>O</option>
                        <option value="A" @selected(old('blood_type') == 'A')>A</option>
                        <option value="B" @selected(old('blood_type') == 'B')>B</option>
                        <option value="AB" @selected(old('blood_type') == 'AB')>AB</option>
                    </select>
                </div>
            </div>

            <!-- Alamat -->
            <div class="form-section-title">Alamat</div>

            <div class="f-group" style="margin-bottom: 24px;">
                <label>Alamat Lengkap</label>
                <textarea name="address" class="f-input">{{ old('address') }}</textarea>
                @error('address')<div class="f-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-grid-2">
                <div class="f-group">
                    <label>Desa/Kelurahan</label>
                    <input type="text" name="village" value="{{ old('village') }}" class="f-input">
                    @error('village')<div class="f-error">{{ $message }}</div>@enderror
                </div>
                <div class="f-group">
                    <label>Kecamatan</label>
                    <input type="text" name="district" value="{{ old('district') }}" class="f-input">
                    @error('district')<div class="f-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grid-2">
                <div class="f-group">
                    <label>Kabupaten/Kota</label>
                    <input type="text" name="sub_district" value="{{ old('sub_district') }}" class="f-input">
                    @error('sub_district')<div class="f-error">{{ $message }}</div>@enderror
                </div>
                <div class="f-group">
                    <label>Kode Pos</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="f-input">
                    @error('postal_code')<div class="f-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grid-2">
                <div class="f-group">
                    <label>Puskesmas *</label>
                    <select name="puskesmas_id" class="f-input" required>
                        <option value="">Pilih Puskesmas...</option>
                        @foreach($puskesmas as $p)
                            <option value="{{ $p->id }}" @selected(old('puskesmas_id') == $p->id)>{{ $p->name }}</option>
                        @endforeach
                    </select>
                    @error('puskesmas_id')<div class="f-error">{{ $message }}</div>@enderror
                </div>
                <div class="f-group">
                    <label>Status Akseptor</label>
                    <select name="status" class="f-input">
                        <option value="active" @selected(old('status') == 'active')>Aktif</option>
                        <option value="inactive" @selected(old('status') == 'inactive')>Tidak Aktif</option>
                        <option value="transferred" @selected(old('status') == 'transferred')>Pindah</option>
                        <option value="graduated" @selected(old('status') == 'graduated')>Lulus</option>
                    </select>
                </div>
            </div>


            <!-- Buttons -->
            <div class="btn-row">
                <a href="{{ route('kb-acceptors.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dobInput = document.querySelector('input[name="date_of_birth"]');
        const ageInput = document.querySelector('input[name="age"]');

        if (dobInput && ageInput) {
            dobInput.addEventListener('change', function() {
                if (this.value) {
                    const dob = new Date(this.value);
                    const today = new Date();
                    let age = today.getFullYear() - dob.getFullYear();
                    const m = today.getMonth() - dob.getMonth();
                    
                    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }
                    
                    ageInput.value = age >= 0 ? age : 0;
                    ageInput.style.backgroundColor = '#f8fafc';
                    ageInput.setAttribute('readonly', true);
                } else {
                    ageInput.value = '';
                    ageInput.style.backgroundColor = '';
                    ageInput.removeAttribute('readonly');
                }
            });
            
            // Trigger calculation on load if value exists
            if(dobInput.value) {
                dobInput.dispatchEvent(new Event('change'));
            }
        }
    });
</script>
@endsection
