@extends('layouts.app')

@php
    $role = request('role', old('role', 'patient'));
    $title = 'Tambah Pengguna Baru';
    $subtitle = 'Masukkan data pengguna ke dalam sistem';
    $btnLabel = 'Simpan Pengguna';
    $nikLabel = 'NIK / NIP';
    $nikPlaceholder = 'Masukkan NIK/NIP';
    $infoTitle = 'Informasi Pengguna';
    $showStatus = true;
    
    if ($role == 'bidan') {
        $title = 'Tambah Bidan Baru';
        $subtitle = 'Masukkan data pengguna bidan ke dalam sistem';
        $btnLabel = 'Simpan Data Bidan';
        $nikLabel = 'NIP (Nomor Induk Pegawai)';
        $nikPlaceholder = '18 Digit NIP';
        $infoTitle = 'Informasi Bidan';
    } elseif ($role == 'dinas_kesehatan') {
        $title = 'Tambah Dinkes Baru';
        $subtitle = 'Masukkan data pengguna Dinkes ke dalam sistem';
        $btnLabel = 'Simpan Data Dinkes';
        $nikLabel = 'NIP (Nomor Induk Pegawai)';
        $nikPlaceholder = '18 Digit NIP';
        $infoTitle = 'Informasi Dinkes';
    } elseif ($role == 'patient' || empty(request('role'))) {
        $title = 'Tambah Akun Pengguna';
        $subtitle = 'Masukkan data pengguna ke dalam sistem';
        $btnLabel = 'Simpan';
        $nikLabel = 'NIK / NIP';
        $nikPlaceholder = 'Masukkan NIK/NIP (16 atau 18 digit)';
        $infoTitle = 'Informasi Pengguna';
        $showStatus = true;
    }
@endphp

@section('title', $title . ' - SatuKIA')
@section('header_title', $title)
@section('header_subtitle', $subtitle)

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
</style>

<div class="form-card">
    <div class="form-section-title">{{ $infoTitle }}</div>
    <div class="form-section-sub">Pastikan data yang dimasukkan valid dan sesuai.</div>

    <form action="{{ route('users.store') }}" method="POST" id="userForm">
        @csrf
        
        <input type="hidden" name="username" id="hidden_username" value="{{ old('username') }}">

        <div class="f-group" style="margin-bottom: 24px;">
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" class="f-input" placeholder="Masukkan nama lengkap" required>
            @error('name')<div class="f-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-grid-2">
            <div class="f-group">
                <label>{{ $nikLabel }}</label>
                <input type="text" name="nik" id="nik_input" value="{{ old('nik') }}" class="f-input" placeholder="{{ $nikPlaceholder }}" required>
                @error('nik')<div class="f-error">{{ $message }}</div>@enderror
                @error('username')<div class="f-error">Username/NIK ini sudah terdaftar.</div>@enderror
            </div>

            <div class="f-group">
                <label>Nomor HP</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="f-input" placeholder="Contoh: 08123456789">
                @error('phone')<div class="f-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="f-group" style="margin-bottom: 24px;">
            <label>Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="f-input" placeholder="email@contoh.com" required>
            @error('email')<div class="f-error">{{ $message }}</div>@enderror
        </div>

        <div class="f-group" style="margin-bottom: 24px;">
            <label>Role Pengguna</label>
            <select name="role" class="f-input" required>
                <option value="patient" @selected(old('role', $role) == 'patient')>Pasien</option>
                <option value="bidan" @selected(old('role', $role) == 'bidan')>Bidan</option>
                <option value="dinas_kesehatan" @selected(old('role', $role) == 'dinas_kesehatan')>Dinas Kesehatan</option>
                <option value="kader" @selected(old('role', $role) == 'kader')>Kader Posyandu</option>
            </select>
            @error('role')<div class="f-error">{{ $message }}</div>@enderror
        </div>

        @if($showStatus)
        <div class="f-group" style="margin-bottom: 32px;">
            <label>Status Akun</label>
            <select name="status" class="f-input" required>
                <option value="active" @selected(old('status') == 'active')>Aktif</option>
                <option value="inactive" @selected(old('status') == 'inactive')>Non-Aktif</option>
            </select>
            @error('status')<div class="f-error">{{ $message }}</div>@enderror
        </div>
        @else
        <div style="margin-bottom: 32px;"></div>
        @endif

        <div class="form-section-title" style="margin-top: 16px;">Pengaturan Keamanan</div>
        <div style="height: 16px;"></div>

        <div class="form-grid-2">
            <div class="f-group">
                <label>Password</label>
                <input type="password" name="password" class="f-input" placeholder="Minimal 8 karakter" required>
                @error('password')<div class="f-error">{{ $message }}</div>@enderror
            </div>
            <div class="f-group">
                <label>Verifikasi Password</label>
                <input type="password" name="password_confirmation" class="f-input" placeholder="Ulangi password" required>
            </div>
        </div>

        <div class="btn-row">
            <a href="{{ route('users.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-save">Simpan</button>
        </div>
    </form>
</div>

<script>
    // Copy NIK/NIP to hidden username field before submit
    document.getElementById('userForm').addEventListener('submit', function(e) {
        document.getElementById('hidden_username').value = document.getElementById('nik_input').value;
    });
</script>
@endsection
