@extends('layouts.dashboard')

@section('title', 'Edit Akseptor KB - ' . $kbAcceptor->full_name)
@section('page_title', 'Edit Akseptor KB')
@section('page_subtitle', 'Perbarui data akseptor ' . $kbAcceptor->full_name)

@section('content')
<style>
    .form-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        max-width: 800px;
        padding: 40px;
        margin: 0 auto;
    }
    .form-section-title { font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 4px; }
    .form-section-sub { font-size: 13.5px; color: #6b7280; margin-bottom: 24px; }
    
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }
    @media(max-width:640px){ .form-grid-2 { grid-template-columns:1fr; } }
    .form-grid-full { margin-bottom: 24px; }

    .f-group label {
        display: block; font-size: 13.5px; font-weight: 600; color: #374151; margin-bottom: 8px;
    }
    .f-input {
        width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 10px;
        font-size: 14px; font-family:'Inter',sans-serif; color:#111827;
        background: #fff; outline: none; transition: border-color .2s;
    }
    .f-input::placeholder { color:#9ca3af; }
    .f-input:focus { border-color:#34988e; box-shadow:0 0 0 3px rgba(52,152,142,.10); }

    .btn-row { display:flex; justify-content:flex-end; gap:16px; margin-top:40px; }

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

<div class="form-card" style="position: relative;">
    <a href="{{ route('kb-acceptors.index') }}" style="position: absolute; top: 24px; right: 24px; color: #9ca3af; padding: 8px; border-radius: 50%; transition: all 0.2s; display: flex; align-items: center; justify-content: center;" onmouseover="this.style.backgroundColor='#f3f4f6'; this.style.color='#ef4444';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#9ca3af';" title="Tutup">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </a>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kb-acceptors.update', $kbAcceptor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-section-title">Data Identitas</div>
        <div class="form-section-sub">Informasi pribadi akseptor KB.</div>

        <div class="form-grid-2">
            <div class="f-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="full_name" value="{{ old('full_name', $kbAcceptor->full_name) }}" class="f-input" required>
                @error('full_name') <div class="f-error">{{ $message }}</div> @enderror
            </div>
            <div class="f-group">
                <label>NIK *</label>
                <input type="text" name="nik" value="{{ old('nik', $kbAcceptor->nik) }}" class="f-input" required maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                @error('nik') <div class="f-error">{{ $message }}</div> @enderror
            </div>

            <div class="f-group">
                <label>Tanggal Lahir *</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $kbAcceptor->date_of_birth->format('Y-m-d')) }}" class="f-input" required>
                @error('date_of_birth') <div class="f-error">{{ $message }}</div> @enderror
            </div>
            <div class="f-group">
                <label>Usia (Tahun)</label>
                <input type="number" name="age" value="{{ old('age', $kbAcceptor->age) }}" min="0" max="150" class="f-input" placeholder="Otomatis terisi jika kosong">
                @error('age') <div class="f-error">{{ $message }}</div> @enderror
            </div>
            <div class="f-group">
                <label>Jenis Kelamin *</label>
                <select name="gender" class="f-input" required>
                    <option value="">Pilih...</option>
                    <option value="M" @selected(old('gender', $kbAcceptor->gender) == 'M')>Laki-laki</option>
                    <option value="F" @selected(old('gender', $kbAcceptor->gender) == 'F')>Perempuan</option>
                </select>
                @error('gender') <div class="f-error">{{ $message }}</div> @enderror
            </div>
            <div class="f-group">
                <label>Status Perkawinan *</label>
                <select name="marital_status" class="f-input" required>
                    <option value="">Pilih...</option>
                    <option value="Kawin" @selected(old('marital_status', $kbAcceptor->marital_status) == 'Kawin')>Kawin</option>
                    <option value="Belum Kawin" @selected(old('marital_status', $kbAcceptor->marital_status) == 'Belum Kawin')>Belum Kawin</option>
                    <option value="Cerai" @selected(old('marital_status', $kbAcceptor->marital_status) == 'Cerai')>Cerai</option>
                </select>
                @error('marital_status') <div class="f-error">{{ $message }}</div> @enderror
            </div>
            <div class="f-group">
                <label>Nomor Telepon *</label>
                <input type="tel" name="phone" value="{{ old('phone', $kbAcceptor->phone) }}" class="f-input" required>
                @error('phone') <div class="f-error">{{ $message }}</div> @enderror
            </div>
            <div class="f-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $kbAcceptor->email) }}" class="f-input">
            </div>
            <div class="f-group">
                <label>Pendidikan</label>
                <select name="education" class="f-input">
                    <option value="">Pilih...</option>
                    <option value="TK" @selected(old('education', $kbAcceptor->education) == 'TK')>TK</option>
                    <option value="SD" @selected(old('education', $kbAcceptor->education) == 'SD')>SD</option>
                    <option value="SMP" @selected(old('education', $kbAcceptor->education) == 'SMP')>SMP</option>
                    <option value="SMA" @selected(old('education', $kbAcceptor->education) == 'SMA')>SMA</option>
                    <option value="Diploma" @selected(old('education', $kbAcceptor->education) == 'Diploma')>Diploma</option>
                    <option value="S1" @selected(old('education', $kbAcceptor->education) == 'S1')>S1</option>
                    <option value="S2" @selected(old('education', $kbAcceptor->education) == 'S2')>S2</option>
                </select>
            </div>
            <div class="f-group">
                <label>Pekerjaan</label>
                <input type="text" name="occupation" value="{{ old('occupation', $kbAcceptor->occupation) }}" class="f-input">
            </div>
            <div class="f-group">
                <label>Agama</label>
                <select name="religion" class="f-input">
                    <option value="">Pilih...</option>
                    <option value="Islam" @selected(old('religion', $kbAcceptor->religion) == 'Islam')>Islam</option>
                    <option value="Kristen Protestan" @selected(old('religion', $kbAcceptor->religion) == 'Kristen Protestan')>Kristen Protestan</option>
                    <option value="Kristen Katolik" @selected(old('religion', $kbAcceptor->religion) == 'Kristen Katolik')>Kristen Katolik</option>
                    <option value="Hindu" @selected(old('religion', $kbAcceptor->religion) == 'Hindu')>Hindu</option>
                    <option value="Buddha" @selected(old('religion', $kbAcceptor->religion) == 'Buddha')>Buddha</option>
                    <option value="Konghucu" @selected(old('religion', $kbAcceptor->religion) == 'Konghucu')>Konghucu</option>
                </select>
            </div>
            <div class="f-group">
                <label>Golongan Darah</label>
                <select name="blood_type" class="f-input">
                    <option value="">Pilih...</option>
                    <option value="O" @selected(old('blood_type', $kbAcceptor->blood_type) == 'O')>O</option>
                    <option value="A" @selected(old('blood_type', $kbAcceptor->blood_type) == 'A')>A</option>
                    <option value="B" @selected(old('blood_type', $kbAcceptor->blood_type) == 'B')>B</option>
                    <option value="AB" @selected(old('blood_type', $kbAcceptor->blood_type) == 'AB')>AB</option>
                </select>
            </div>
        </div>

        <div class="form-section-title" style="margin-top: 32px;">Alamat Lengkap</div>
        <div class="form-section-sub">Informasi tempat tinggal akseptor.</div>

        <div class="form-grid-full">
            <div class="f-group">
                <label>Alamat Lengkap</label>
                <textarea name="address" rows="3" class="f-input" style="resize: vertical;">{{ old('address', $kbAcceptor->address) }}</textarea>
                @error('address') <div class="f-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-grid-2">
            <div class="f-group">
                <label>Desa/Kelurahan</label>
                <input type="text" name="village" value="{{ old('village', $kbAcceptor->village) }}" class="f-input">
                @error('village') <div class="f-error">{{ $message }}</div> @enderror
            </div>
            <div class="f-group">
                <label>Kecamatan</label>
                <input type="text" name="district" value="{{ old('district', $kbAcceptor->district) }}" class="f-input">
                @error('district') <div class="f-error">{{ $message }}</div> @enderror
            </div>
            <div class="f-group">
                <label>Kabupaten/Kota</label>
                <input type="text" name="sub_district" value="{{ old('sub_district', $kbAcceptor->sub_district) }}" class="f-input">
                @error('sub_district') <div class="f-error">{{ $message }}</div> @enderror
            </div>
            <div class="f-group">
                <label>Kode Pos</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', $kbAcceptor->postal_code) }}" class="f-input">
                @error('postal_code') <div class="f-error">{{ $message }}</div> @enderror
            </div>
            <div class="f-group">
                <label>Puskesmas *</label>
                <select name="puskesmas_id" class="f-input" required>
                    <option value="">Pilih Puskesmas...</option>
                    @foreach($puskesmas as $p)
                        <option value="{{ $p->id }}" @selected(old('puskesmas_id', $kbAcceptor->puskesmas_id) == $p->id)>{{ $p->name }}</option>
                    @endforeach
                </select>
                @error('puskesmas_id') <div class="f-error">{{ $message }}</div> @enderror
            </div>
            <div class="f-group">
                <label>Status Akseptor</label>
                <select name="status" class="f-input">
                    <option value="active" @selected(old('status', $kbAcceptor->status) == 'active')>Aktif</option>
                    <option value="inactive" @selected(old('status', $kbAcceptor->status) == 'inactive')>Tidak Aktif</option>
                    <option value="transferred" @selected(old('status', $kbAcceptor->status) == 'transferred')>Pindah</option>
                    <option value="graduated" @selected(old('status', $kbAcceptor->status) == 'graduated')>Lulus</option>
                </select>
                @error('status') <div class="f-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-section-title" style="margin-top: 32px;">Informasi Kesehatan</div>
        <div class="form-section-sub">Data medis dan kesehatan akseptor.</div>

        <div class="form-grid-full">
            <div class="f-group" style="margin-bottom: 24px;">
                <label>Riwayat Penyakit</label>
                <textarea name="health_history" rows="2" class="f-input" style="resize: vertical;">{{ old('health_history', $kbAcceptor->health_history) }}</textarea>
            </div>
            <div class="f-group">
                <label>Alergi</label>
                <textarea name="allergies" rows="2" class="f-input" style="resize: vertical;">{{ old('allergies', $kbAcceptor->allergies) }}</textarea>
            </div>
        </div>

        <div class="btn-row">
            <a href="{{ route('kb-acceptors.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-save">Perbarui Akseptor</button>
        </div>
    </form>
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

