@extends('layouts.dashboard')

@section('title', 'Kelola Pengguna')
@section('page_title', 'Kelola Pengguna')
@section('page_subtitle', 'Tambah, edit, dan hapus pengguna sistem')

@section('content')
<div x-data="userManager()" x-cloak>
    <!-- Header Row -->
    <div class="um-header">
        <div class="um-header-left">
            <form method="GET" action="{{ auth()->user()->isBidan() ? route('bidan.kader.index') : route('admin.users.index') }}" class="um-search-form" id="search-form">
                <div class="um-search-wrap">
                    <svg class="um-search-icon" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, username, NIK..." class="um-search-input" id="search-input">
                </div>
                <select name="role" onchange="this.form.submit()" class="um-filter-select" id="filter-role">
                    <option value="">Semua Role</option>
                    <option value="super admin" {{ request('role') === 'super admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="bidan" {{ request('role') === 'bidan' ? 'selected' : '' }}>Bidan</option>
                    <option value="kader" {{ request('role') === 'kader' ? 'selected' : '' }}>Kader</option>
                    <option value="orang tua" {{ request('role') === 'orang tua' ? 'selected' : '' }}>Orang Tua</option>
                    <option value="dinkes" {{ request('role') === 'dinkes' ? 'selected' : '' }}>Dinas Kesehatan</option>
                </select>
            </form>
        </div>
        <button type="button" class="um-btn-add" @click="openCreate()" id="btn-add-user">
            <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/></svg>
            Tambah Pengguna
        </button>
    </div>

    <!-- Users Table -->
    <div class="um-table-wrap">
        <table class="um-table" id="users-table">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th>Terdaftar</th>
                    <th class="um-th-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            <div class="um-user-cell">
                                <div class="um-user-avatar" style="background: linear-gradient(135deg,
                                    {{ $user->role === 'super admin' ? '#6366F1,#8B5CF6' : ($user->role === 'bidan' ? '#0D9488,#06B6D4' : ($user->role === 'kader' ? '#F97316,#EAB308' : ($user->role === 'dinkes' ? '#EC4899,#F43F5E' : '#64748B,#94A3B8'))) }});">
                                    {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="um-user-name">{{ $user->nama_lengkap }}</div>
                                    @if ($user->nik_ortu)
                                        <div class="um-user-nik">NIK: {{ $user->nik_ortu }}</div>
                                    @elseif ($user->nip_bidan)
                                        <div class="um-user-nik">NIP: {{ $user->nip_bidan }}</div>
                                    @endif
                                    @if ($user->email)
                                        <div class="um-user-nik" style="color: #64748B; margin-top: 2px;">{{ $user->email }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td><code class="um-username">{{ $user->username }}</code></td>
                        <td>
                            <span class="um-role-badge um-role-badge--{{ str_replace(' ', '-', $user->role) }}">
                                {{ $user->role === 'dinkes' ? 'Dinas Kesehatan' : ucwords($user->role) }}
                            </span>
                        </td>
                        <td class="um-contact">{{ $user->nomor_kontak ?? '-' }}</td>
                        <td>
                            @if($user->is_active)
                                <span style="background: rgba(16,185,129,0.1); color: #10B981; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">Aktif</span>
                            @else
                                <span style="background: rgba(239,68,68,0.1); color: #EF4444; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="um-date">{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="um-actions">
                                <button type="button" class="um-btn-edit" @click="openEdit({{ $user->id_user }})" title="Edit" id="btn-edit-{{ $user->id_user }}">
                                    <svg viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                                </button>
                                @if ($user->id_user !== auth()->id())
                                    <form method="POST" action="{{ auth()->user()->isBidan() ? route('bidan.kader.destroy', $user) : route('admin.users.destroy', $user) }}" class="um-delete-form" onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $user->nama_lengkap }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="um-btn-delete" title="Hapus" id="btn-delete-{{ $user->id_user }}">
                                            <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="um-empty">
                            <svg viewBox="0 0 24 24" class="um-empty-icon"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                            <p>Belum ada pengguna yang ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($users->hasPages())
        <div class="um-pagination">
            {{ $users->links() }}
        </div>
    @endif

    <!-- ===== CREATE/EDIT MODAL ===== -->
    <div class="um-modal-overlay" x-show="showModal" x-transition:enter="um-overlay-enter" x-transition:leave="um-overlay-leave" @click.self="showModal = false" style="display:none;">
        <div class="um-modal" x-show="showModal" x-transition:enter="um-modal-enter" x-transition:leave="um-modal-leave" @click.stop>
            <div class="um-modal-header">
                <h3 class="um-modal-title" x-text="isEdit ? 'Edit Pengguna' : 'Tambah Pengguna Baru'"></h3>
                <button type="button" class="um-modal-close" @click="showModal = false" id="btn-close-modal">
                    <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                </button>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="um-modal-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form :action="isEdit ? '{{ auth()->user()->isBidan() ? url('bidan/kader') : url('admin/users') }}/' + editId : '{{ auth()->user()->isBidan() ? route('bidan.kader.store') : route('admin.users.store') }}'" method="POST" class="um-modal-form" id="user-form" onsubmit="return validateUserForm()">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="um-form-grid">
                    <!-- Nama Lengkap -->
                    <div class="um-field">
                        <label for="modal_nama_lengkap" class="um-label">Nama Lengkap <span class="um-required">*</span></label>
                        <input type="text" name="nama_lengkap" id="modal_nama_lengkap" x-model="form.nama_lengkap" class="um-input" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <!-- Username -->
                    <div class="um-field">
                        <label for="modal_username" class="um-label">Username <span class="um-required">*</span></label>
                        <input type="text" name="username" id="modal_username" x-model="form.username" class="um-input" placeholder="Masukkan username" required>
                    </div>

                    <!-- Email -->
                    <div class="um-field">
                        <label for="modal_email" class="um-label">Alamat Email</label>
                        <input type="email" name="email" id="modal_email" x-model="form.email" class="um-input" placeholder="contoh@email.com">
                    </div>
                    <!-- Password -->
                    <div class="um-field">
                        <label for="modal_password" class="um-label">
                            Password
                            <span class="um-required" x-show="!isEdit">*</span>
                            <span class="um-hint" x-show="isEdit">(kosongkan jika tidak diubah)</span>
                        </label>
                        <div style="position: relative; display: flex; align-items: center;">
                            <input :type="showPassword ? 'text' : 'password'" name="password" id="modal_password" class="um-input" style="padding-right: 48px;" placeholder="Minimal 8 karakter" :required="!isEdit ? false : undefined" x-bind:required="!isEdit">
                            <button type="button" @click="showPassword = !showPassword" style="position: absolute; right: 12px; background: none; border: none; cursor: pointer; color: #94A3B8; display: grid; place-items: center; padding: 4px;">
                                <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: currentColor;" x-show="!showPassword"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                                <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: currentColor; display: none;" x-show="showPassword"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="um-field">
                        <label for="modal_role" class="um-label">Role <span class="um-required">*</span></label>
                        <select name="role" id="modal_role" x-model="form.role" class="um-input um-select" required>
                            <option value="">Pilih Role</option>
                            <option value="super admin">Super Admin</option>
                            <option value="bidan">Bidan</option>
                            <option value="kader">Kader</option>
                            <option value="orang tua">Orang Tua</option>
                            <option value="dinkes">Dinas Kesehatan</option>
                        </select>
                    </div>

                    <!-- Status Aktif (Edit Only) -->
                    <div class="um-field" x-show="isEdit">
                        <label for="modal_is_active" class="um-label" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="is_active" id="modal_is_active" x-model="form.is_active" value="1" style="width: 18px; height: 18px; cursor: pointer; accent-color: #10B981;">
                            <span style="font-weight: 600;">Status Akun Aktif</span>
                        </label>
                        <p style="font-size: 12px; color: #64748B; margin-top: 4px; margin-left: 26px;">Jika tidak aktif, pengguna ini tidak akan bisa login.</p>
                    </div>

                    <!-- Nomor Kontak -->
                    <div class="um-field">
                        <label for="modal_nomor_kontak" class="um-label">Nomor Kontak</label>
                        <input type="tel" name="nomor_kontak" id="modal_nomor_kontak" x-model="form.nomor_kontak" class="um-input" placeholder="08xxxxxxxxxx">
                    </div>

                    <!-- NIP Bidan (conditional) -->
                    <div class="um-field" x-show="form.role === 'bidan'">
                        <label for="modal_nip_bidan" class="um-label">NIP Bidan</label>
                        <input type="text" name="nip_bidan" id="modal_nip_bidan" x-model="form.nip_bidan" class="um-input" placeholder="18 digit NIP" maxlength="18" pattern="[0-9]{18}" title="NIP Bidan harus 18 digit angka" oninvalid="this.setCustomValidity('NIP Bidan harus terdiri dari 18 digit angka')" oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>

                    <!-- NIK Ortu (conditional) -->
                    <div class="um-field" x-show="form.role === 'orang tua'">
                        <label for="modal_nik_ortu" class="um-label">NIK Orang Tua</label>
                        <input type="text" name="nik_ortu" id="modal_nik_ortu" x-model="form.nik_ortu" class="um-input" placeholder="16 digit NIK" maxlength="16" minlength="16" pattern="[0-9]{16}" title="NIK harus 16 digit angka" oninvalid="this.setCustomValidity('NIK Orang Tua harus terdiri dari 16 digit angka')" oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>

                    <!-- Alamat Domisili (conditional) -->
                    <div class="um-field" x-show="form.role === 'orang tua'">
                        <label for="modal_alamat_domisili" class="um-label">Alamat Domisili Lengkap</label>
                        <textarea name="alamat_domisili" id="modal_alamat_domisili" x-model="form.alamat_domisili" class="um-input" rows="2" placeholder="Masukkan alamat lengkap domisili..."></textarea>
                    </div>

                    <!-- Kode Instansi Dinkes (conditional) -->
                    <div class="um-field" x-show="form.role === 'dinkes'">
                        <label for="modal_kode_instansi" class="um-label">Kode Instansi Dinkes</label>
                        <input type="text" name="kode_instansi_dinkes" id="modal_kode_instansi" x-model="form.kode_instansi_dinkes" class="um-input" placeholder="Masukkan kode instansi">
                    </div>

                    <!-- Kabupaten (conditional: bidan, kader, dinkes) -->
                    <div class="um-field" x-show="['bidan', 'kader', 'dinkes'].includes(form.role)">
                        <label for="modal_kabupaten_id" class="um-label">Kabupaten/Kota</label>
                        <select id="modal_kabupaten_id" x-model="form.kabupaten_id" class="um-input um-select" @change="form.puskesmas_id = ''; form.posyandu_id = ''">
                            <option value="">Pilih Kabupaten/Kota</option>
                            @foreach($kabupatenList as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kabupaten }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Wilayah Kerja (conditional: bidan, kader) -->
                    <div class="um-field" x-show="['bidan', 'kader'].includes(form.role)">
                        <label for="modal_puskesmas_id" class="um-label">Puskesmas (Tempat Tugas)</label>
                        <select name="puskesmas_id" id="modal_puskesmas_id" x-model="form.puskesmas_id" class="um-input um-select" @change="form.posyandu_id = ''">
                            <option value="">Pilih Puskesmas</option>
                            <template x-for="p in filteredPuskesmas" :key="p.id">
                                <option :value="p.id" x-text="p.nama_puskesmas"></option>
                            </template>
                        </select>
                    </div>

                    <div class="um-field" x-show="['kader'].includes(form.role)">
                        <label for="modal_posyandu_id" class="um-label">Posyandu (Tempat Tugas)</label>
                        <select name="posyandu_id" id="modal_posyandu_id" x-model="form.posyandu_id" class="um-input um-select">
                            <option value="">Pilih Posyandu</option>
                            <template x-for="p in filteredPosyandu" :key="p.id">
                                <option :value="p.id" x-text="p.nama_posyandu"></option>
                            </template>
                        </select>
                    </div>
                </div>

                <div class="um-modal-footer">
                    <button type="button" class="um-btn-cancel" @click="showModal = false">Batal</button>
                    <button type="submit" class="um-btn-save" id="btn-save-user">
                        <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        <span x-text="isEdit ? 'Simpan Perubahan' : 'Tambah Pengguna'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validateUserForm() {
    let roleSelect = document.getElementById('modal_role');
    let nikInput = document.getElementById('modal_nik_ortu');
    if (roleSelect && roleSelect.value === 'orang tua' && nikInput) {
        if (!/^\d{16}$/.test(nikInput.value.trim())) {
            alert('NIK Orang Tua harus terdiri dari tepat 16 digit angka.');
            return false;
        }
    }
    return true;
}

function userManager() {
    return {
        showModal: {{ $errors->any() ? 'true' : 'false' }},
        showPassword: false,
        isEdit: false,
        editId: null,
        kabupatenList: @json($kabupatenList),
        puskesmasList: @json($puskesmasList),
        posyanduList: @json($posyanduList),
        form: {
            nama_lengkap: '{{ old('nama_lengkap', '') }}',
            username: '{{ old('username', '') }}',
            role: '{{ old('role', '') }}',
            nomor_kontak: '{{ old('nomor_kontak', '') }}',
            nip_bidan: '{{ old('nip_bidan', '') }}',
            nik_ortu: '{{ old('nik_ortu', '') }}',
            kode_instansi_dinkes: '{{ old('kode_instansi_dinkes', '') }}',
            is_active: {{ old('is_active', 'true') === 'true' || old('is_active', '1') == '1' ? 'true' : 'false' }},
            kabupaten_id: '',
            puskesmas_id: '{{ old('puskesmas_id', '') }}',
            posyandu_id: '{{ old('posyandu_id', '') }}',
            email: '{{ old('email', '') }}',
            alamat_domisili: '{{ old('alamat_domisili', '') }}',
        },

        get filteredPuskesmas() {
            if (!this.form.kabupaten_id) return [];
            return this.puskesmasList.filter(p => p.kabupaten_id == this.form.kabupaten_id);
        },

        get filteredPosyandu() {
            if (!this.form.puskesmas_id) return [];
            return this.posyanduList.filter(p => p.puskesmas_id == this.form.puskesmas_id);
        },

        openCreate() {
            this.isEdit = false;
            this.editId = null;
            this.form = { nama_lengkap: '', username: '', role: '', nomor_kontak: '', nip_bidan: '', nik_ortu: '', kode_instansi_dinkes: '', is_active: true, kabupaten_id: '', puskesmas_id: '', posyandu_id: '', email: '', alamat_domisili: '' };
            this.showModal = true;
        },

        async openEdit(id) {
            this.isEdit = true;
            this.editId = id;
            try {
                const res = await fetch(`{{ auth()->user()->isBidan() ? '/bidan/kader/' : '/admin/users/' }}${id}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();
                let kab_id = '';
                if (data.kabupaten_id) {
                    kab_id = data.kabupaten_id;
                } else if (data.puskesmas_id) {
                    const foundPusk = this.puskesmasList.find(p => p.id == data.puskesmas_id);
                    if (foundPusk) kab_id = foundPusk.kabupaten_id;
                }

                this.form = {
                    nama_lengkap: data.nama_lengkap || '',
                    username: data.username || '',
                    role: data.role || '',
                    nomor_kontak: data.nomor_kontak || '',
                    nip_bidan: data.nip_bidan || '',
                    nik_ortu: data.nik_ortu || '',
                    kode_instansi_dinkes: data.kode_instansi_dinkes || '',
                    is_active: data.is_active === undefined ? true : !!data.is_active,
                    kabupaten_id: kab_id,
                    puskesmas_id: '',
                    posyandu_id: '',
                    email: data.email || '',
                    alamat_domisili: data.alamat_domisili || '',
                };

                this.$nextTick(() => {
                    this.form.puskesmas_id = data.puskesmas_id || '';
                    this.$nextTick(() => {
                        this.form.posyandu_id = data.posyandu_id || '';
                        
                        // Mark form state for dirty checking after Alpine has updated the DOM
                        setTimeout(() => {
                            const form = document.getElementById('user-form');
                            if (form && typeof window.markFormState === 'function') {
                                window.markFormState(form);
                            }
                        }, 50);
                    });
                });

                this.showModal = true;
            } catch (err) {
                alert('Gagal memuat data pengguna.');
            }
        }
    };
}
</script>
@endsection
