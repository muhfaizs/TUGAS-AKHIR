@extends('layouts.dashboard')

@section('title', 'Manajemen Profil Kader')
@section('page_title', 'Profil Kader')
@section('page_subtitle', 'Kelola informasi pribadi dan keamanan akun Anda')

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

    @php
        $oldPosyanduId = old('posyandu_id', $user->posyandu_id);
        $initPuskesmasId = '';
        $initKabupatenId = '';
        if ($oldPosyanduId) {
            $pos = $posyanduList->firstWhere('id', $oldPosyanduId);
            if ($pos) {
                $initPuskesmasId = $pos->puskesmas_id;
                $pusk = $puskesmasList->firstWhere('id', $initPuskesmasId);
                if ($pusk) {
                    $initKabupatenId = $pusk->kabupaten_id;
                }
            }
        }
    @endphp

    <form method="POST" action="{{ route('kader.profile.update') }}" x-data="{ 
        showPassword: false, 
        kabupatenList: {{ json_encode($kabupatenList) }}, 
        puskesmasList: {{ json_encode($puskesmasList) }}, 
        posyanduList: {{ json_encode($posyanduList) }}, 
        kabupaten_id: {{ $initKabupatenId ?: '""' }}, 
        puskesmas_id: '', 
        posyandu_id: '', 
        init() {
            this.$nextTick(() => {
                this.puskesmas_id = {{ $initPuskesmasId ?: '""' }};
                this.$nextTick(() => {
                    this.posyandu_id = {{ $oldPosyanduId ?: '""' }};
                });
            });
        },
        get filteredPuskesmas() {
            if (!this.kabupaten_id) return [];
            return this.puskesmasList.filter(p => p.kabupaten_id == this.kabupaten_id);
        },
        get filteredPosyandu() {
            if (!this.puskesmas_id) return [];
            return this.posyanduList.filter(p => p.puskesmas_id == this.puskesmas_id);
        }
    }" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- Foto Profil -->
            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 8px;">
                <div style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, var(--kia-primary, #0D9488), #064E3B); display: grid; place-items: center; color: #fff; font-size: 20px; font-weight: 800; overflow: hidden; {{ $user->foto_profil ? 'background-image: url(' . asset('storage/' . $user->foto_profil) . '); background-size: cover; background-position: center;' : '' }}">
                    @if(!$user->foto_profil)
                        {{ strtoupper(substr($user->name, 0, 2)) }}
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
                <label for="name" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; transition: all 0.2s;">
            </div>

            <!-- Nomor Kontak -->
            <div>
                <label for="phone" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Nomor Kontak</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; transition: all 0.2s;">
            </div>



            <!-- Email -->
            <div>
                <label for="email" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; transition: all 0.2s;" placeholder="contoh@email.com">
            </div>

            <!-- Kabupaten/Kota -->
            <div>
                <label for="kabupaten_id" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Kabupaten/Kota (Tempat Tugas)</label>
                <select id="kabupaten_id" x-model="kabupaten_id" class="form-input" style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; background-color: #fff;" @change="puskesmas_id = ''; posyandu_id = ''">
                    <option value="">Pilih Kabupaten/Kota</option>
                    @foreach($kabupatenList as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kabupaten }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Puskesmas -->
            <div>
                <label for="puskesmas_id" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Puskesmas</label>
                <select id="puskesmas_id" x-model="puskesmas_id" class="form-input" style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; background-color: #fff;" @change="posyandu_id = ''">
                    <option value="">Pilih Puskesmas</option>
                    <template x-for="p in filteredPuskesmas" :key="p.id">
                        <option :value="p.id" x-text="p.nama_puskesmas"></option>
                    </template>
                </select>
            </div>

            <!-- Posyandu -->
            <div>
                <label for="posyandu_id" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Posyandu (Tempat Tugas) <span style="color: #EF4444;">*</span></label>
                <select name="posyandu_id" id="posyandu_id" x-model="posyandu_id" required class="form-input" style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; background-color: #fff;">
                    <option value="">Pilih Posyandu</option>
                    <template x-for="p in filteredPosyandu" :key="p.id">
                        <option :value="p.id" x-text="p.nama_posyandu"></option>
                    </template>
                </select>
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
        </div>
    </form>
</div>
@endsection
