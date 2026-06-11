@extends('layouts.dashboard')

@section('title', 'Profil Orang Tua')
@section('page_title', 'Profil Saya')
@section('page_subtitle', 'Kelola informasi pribadi dan kata sandi Anda')

@section('content')
<div class="profile-container" style="max-width: 600px; margin: 0 auto; background: #fff; padding: 32px; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
    
    @if (session('success'))
        <div style="padding: 16px; background: rgba(16,185,129,0.1); color: #059669; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="padding: 16px; background: rgba(239,68,68,0.1); color: #DC2626; border-radius: 12px; margin-bottom: 24px; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('orangtua.profile.update') }}" x-data="{ showPassword: false }" enctype="multipart/form-data" onsubmit="return validateProfileForm()">
        @csrf
        @method('PUT')

        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- Foto Profil -->
            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 8px;">
                <div style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, var(--kia-primary, #0D9488), #064E3B); display: grid; place-items: center; color: #fff; font-size: 20px; font-weight: 800; overflow: hidden; {{ $user->foto_profil ? 'background-image: url(' . asset('storage/' . $user->foto_profil) . '); background-size: cover; background-position: center;' : '' }}">
                    @if(!$user->foto_profil)
                        {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
                    @endif
                </div>
                <div style="flex: 1;">
                    <label for="foto_profil" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Foto Profil</label>
                    <input type="file" name="foto_profil" id="foto_profil" accept="image/*" style="width: 100%; padding: 8px 12px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; transition: all 0.2s; background: #fff;">
                    @if($user->foto_profil)
                        <div style="margin-top: 8px; display: flex; align-items: center; gap: 6px;">
                            <input type="checkbox" name="hapus_foto" id="hapus_foto" value="1">
                            <label for="hapus_foto" style="font-size: 13px; color: #EF4444; cursor: pointer;">Hapus foto saat ini</label>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Username (Readonly) -->
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Username</label>
                <input type="text" value="{{ $user->username }}" readonly style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 12px; background: #F8FAFC; color: #94A3B8; font-family: inherit;">
                <p style="font-size: 12px; color: #94A3B8; margin-top: 6px;">Username tidak dapat diubah.</p>
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label for="nama_lengkap" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; transition: all 0.2s;">
            </div>

            <!-- NIK (16 Digit) -->
            <div>
                <label for="nik_ortu" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">NIK (16 Digit)</label>
                <input type="text" name="nik_ortu" id="nik_ortu" value="{{ old('nik_ortu', $user->nik_ortu) }}" required maxlength="16" minlength="16" pattern="[0-9]{16}" title="NIK harus 16 digit angka" style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; transition: all 0.2s;" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>

            <!-- Nomor Kontak -->
            <div>
                <label for="nomor_kontak" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Nomor Kontak</label>
                <input type="tel" name="nomor_kontak" id="nomor_kontak" value="{{ old('nomor_kontak', $user->nomor_kontak) }}" style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; transition: all 0.2s;">
            </div>

            <!-- Posyandu Domisili -->
            <div>
                <label for="posyandu_id" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Posyandu Domisili (Pilih untuk melihat jadwal)</label>
                <select name="posyandu_id" id="posyandu_id" style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; font-size: 14px; appearance: none; background: url('data:image/svg+xml;utf8,<svg viewBox=\&quot;0 0 24 24\&quot; fill=\&quot;%2394A3B8\&quot; xmlns=\&quot;http://www.w3.org/2000/svg\&quot;><path d=\&quot;M7 10l5 5 5-5z\&quot;/></svg>') no-repeat right 12px center; background-color: #fff; background-size: 24px;">
                    <option value="">-- Pilih Posyandu (Opsional) --</option>
                    @if(isset($posyandus))
                        @foreach($posyandus as $posyandu)
                            <option value="{{ $posyandu->id }}" {{ old('posyandu_id', $user->posyandu_id) == $posyandu->id ? 'selected' : '' }}>
                                {{ $posyandu->nama_posyandu }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Email -->
            <div>
                <label for="email" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; transition: all 0.2s;" placeholder="contoh@email.com">
            </div>

            <hr style="border: none; border-top: 1px solid #E2E8F0; margin: 8px 0;">

            <!-- Password -->
            <div>
                <label for="password" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Password Baru</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <input :type="showPassword ? 'text' : 'password'" name="password" id="password" style="width: 100%; padding: 12px 48px 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; transition: all 0.2s;" placeholder="Kosongkan jika tidak ingin mengubah password">
                    <button type="button" @click="showPassword = !showPassword" style="position: absolute; right: 12px; background: none; border: none; cursor: pointer; color: #94A3B8; display: grid; place-items: center; padding: 4px;">
                        <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: currentColor;" x-show="!showPassword"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: currentColor; display: none;" x-show="showPassword"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>
                    </button>
                </div>
            </div>

            <div style="margin-top: 12px;">
                <button type="submit" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #0D9488, #0F766E); color: #fff; border: none; border-radius: 12px; font-weight: 600; font-size: 15px; cursor: pointer; transition: all 0.3s; box-shadow: 0 8px 16px rgba(13,148,136,0.2);">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
<script>
function validateProfileForm() {
    let nikInput = document.getElementById('nik_ortu');
    if (nikInput) {
        if (!/^\d{16}$/.test(nikInput.value.trim())) {
            alert('NIK harus terdiri dari tepat 16 digit angka.');
            return false;
        }
    }
    return true;
}
</script>
@endsection
