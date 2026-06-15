@extends('layouts.app')

@section('title', 'Edit User - SatuKIA')
@section('header_title', 'Edit User')
@section('header_subtitle', 'Perbarui informasi akun user di sistem.')

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
    .f-hint { font-size: 12px; color: #6b7280; margin-top: 6px; }
</style>

<div class="form-card">
    <div class="form-section-title">Informasi User</div>
    <div class="form-section-sub">Pastikan data yang dimasukkan valid dan sesuai.</div>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="f-group" style="margin-bottom: 24px;">
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="f-input" placeholder="Masukkan nama lengkap" required>
            @error('name')<div class="f-error">{{ $message }}</div>@enderror
        </div>

        <div class="f-group" style="margin-bottom: 24px;">
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" class="f-input" placeholder="Username untuk login" required>
            @error('username')<div class="f-error">{{ $message }}</div>@enderror
        </div>

        <div class="f-group" style="margin-bottom: 24px;">
            <label>Alamat Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="f-input" placeholder="email@contoh.com" required>
            @error('email')<div class="f-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-grid-2">
            <div class="f-group">
                <label>NIK / NIP</label>
                <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" class="f-input" placeholder="16 atau 18 digit NIK/NIP" required>
                @error('nik')<div class="f-error">{{ $message }}</div>@enderror
            </div>

            <div class="f-group">
                <label>Nomor HP</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="f-input" placeholder="Contoh: 08123456789">
                @error('phone')<div class="f-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-section-title" style="margin-top: 32px;">Pengaturan Keamanan</div>
        <div style="height: 16px;"></div>

        <div class="form-grid-2">
            <div class="f-group">
                <label>Kata Sandi Baru</label>
                <input type="password" name="password" class="f-input" placeholder="Minimal 8 karakter">
                <div class="f-hint">Kosongkan jika tidak ingin mengubah password.</div>
                @error('password')<div class="f-error">{{ $message }}</div>@enderror
            </div>
            <div class="f-group">
                <label>Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="f-input" placeholder="Ulangi kata sandi">
            </div>
        </div>

        <div class="form-section-title" style="margin-top: 32px;">Peran & Status</div>
        <div style="height: 16px;"></div>

        <div class="form-grid-2">
            <div class="f-group">
                <label>Role</label>
                <select name="role" class="f-input" required>
                    <option value="">Pilih role...</option>
                    @foreach($roles as $value => $label)
                        <option value="{{ $value }}" @selected(old('role', $user->role) == $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('role')<div class="f-error">{{ $message }}</div>@enderror
            </div>

            <div class="f-group">
                <label>Status Akun</label>
                <select name="status" class="f-input" required>
                    <option value="">Pilih status...</option>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $user->status) == $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')<div class="f-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="f-group" style="margin-bottom: 24px;">
            <label>Puskesmas <span style="color:#9ca3af;font-weight:500;">(opsional)</span></label>
            <select name="puskesmas_id" class="f-input">
                <option value="">Tidak terkait Puskesmas</option>
                @foreach($puskesmas as $p)
                    <option value="{{ $p->id }}" @selected(old('puskesmas_id', $user->puskesmas_id) == $p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
            @error('puskesmas_id')<div class="f-error">{{ $message }}</div>@enderror
        </div>

        <div class="btn-row">
            <a href="{{ route('users.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-save">Perbarui User</button>
        </div>
    </form>
</div>
@endsection
