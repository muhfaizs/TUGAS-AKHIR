@extends('layouts.dashboard')

@section('title', 'Profil Orang Tua')
@section('page_title', 'Profil Saya')
@section('page_subtitle', 'Kelola informasi pribadi dan kata sandi Anda')

@section('content')
<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
            </div>
            <div class="profile-info">
                <h2 class="profile-name">{{ $user->nama_lengkap }}</h2>
                <p class="profile-role">Orang Tua</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="profile-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('orangtua.profile.update') }}" class="profile-form">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required class="form-input">
                </div>

                <div class="form-group">
                    <label for="nik_ortu">NIK (16 Digit)</label>
                    <input type="text" id="nik_ortu" name="nik_ortu" value="{{ old('nik_ortu', $user->nik_ortu) }}" required maxlength="16" class="form-input">
                </div>

                <div class="form-group">
                    <label for="nomor_kontak">Nomor Kontak</label>
                    <input type="tel" id="nomor_kontak" name="nomor_kontak" value="{{ old('nomor_kontak', $user->nomor_kontak) }}" required class="form-input">
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required class="form-input">
                </div>
            </div>

            <hr class="profile-divider">
            <h3 class="profile-section-title">Ubah Kata Sandi</h3>
            <p class="profile-section-desc">Kosongkan jika tidak ingin mengubah kata sandi.</p>

            <div class="form-grid">
                <div class="form-group">
                    <label for="password">Kata Sandi Baru</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Minimal 8 karakter">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi kata sandi">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.profile-container {
    max-width: 800px; margin: 0 auto;
}
.profile-card {
    background: #fff; border-radius: 20px; padding: 32px;
    box-shadow: 0 4px 20px rgba(13,148,136,0.06); border: 1px solid rgba(15,23,42,0.06);
}
.profile-header {
    display: flex; align-items: center; gap: 20px; margin-bottom: 32px;
}
.profile-avatar {
    width: 64px; height: 64px; border-radius: 16px;
    background: linear-gradient(135deg, var(--kia-primary), #064E3B);
    display: grid; place-items: center; color: #fff; font-size: 20px; font-weight: 800;
}
.profile-name { font-size: 24px; font-weight: 700; color: #0F172A; margin: 0 0 4px; }
.profile-role { font-size: 14px; color: #64748B; margin: 0; }

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-group { display: flex; flex-direction: column; gap: 8px; }
.form-group label { font-size: 13px; font-weight: 600; color: #1E293B; }
.form-input {
    padding: 12px 16px; border-radius: 12px; border: 1px solid rgba(15,23,42,0.15);
    font-size: 14px; font-family: inherit; transition: all 0.2s; outline: none; background: #fff;
}
.form-input:focus { border-color: var(--kia-primary); box-shadow: 0 0 0 3px rgba(13,148,136,0.1); }

.profile-divider { border: none; border-top: 1px solid rgba(15,23,42,0.08); margin: 32px 0; }
.profile-section-title { font-size: 16px; font-weight: 700; margin: 0 0 4px; color: #0F172A; }
.profile-section-desc { font-size: 13px; color: #64748B; margin: 0 0 20px; }

.form-actions { margin-top: 32px; display: flex; justify-content: flex-end; }
.btn-primary {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 24px; border-radius: 12px; background: var(--kia-primary); color: #fff;
    font-size: 14px; font-weight: 600; font-family: inherit; border: none; cursor: pointer; transition: all 0.2s;
}
.btn-primary:hover { background: var(--kia-primary-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(13,148,136,0.2); }
.btn-primary svg { width: 18px; height: 18px; fill: currentColor; }

.profile-errors { margin-bottom: 24px; padding: 16px; border-radius: 12px; background: rgba(239,68,68,0.08); color: #B91C1C; }
.profile-errors ul { margin: 0; padding-left: 20px; font-size: 13px; }

@media (max-width: 640px) {
    .form-grid { grid-template-columns: 1fr; }
    .profile-card { padding: 24px; }
}
</style>
@endsection
