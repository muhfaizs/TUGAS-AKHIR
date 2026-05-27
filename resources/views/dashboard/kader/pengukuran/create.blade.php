@extends('layouts.dashboard')

@section('title', 'Input Pengukuran')
@section('page_title', 'Input Pengukuran Anak')
@section('page_subtitle', 'Masukkan data antropometri terbaru')

@section('content')
<div x-data="pengukuranForm()" class="pengukuran-container" style="max-width: 600px; margin: 0 auto; background: #fff; padding: 32px; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
    
    @if (session('success'))
        @php
            $bg = 'rgba(16,185,129,0.1)';
            $text = '#059669'; // Hijau
            if(session('imt_color') == 'merah') {
                $bg = 'rgba(239,68,68,0.1)';
                $text = '#DC2626';
            } elseif(session('imt_color') == 'kuning') {
                $bg = 'rgba(245,158,11,0.1)';
                $text = '#D97706';
            }
        @endphp
        <div style="padding: 16px; background: {{ $bg }}; color: {{ $text }}; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 600;">
            {{ session('success') }}
            @if(session('imt_value'))
                <br>
                IMT: <strong>{{ session('imt_value') }}</strong> &mdash; {{ session('imt_status') }}
            @endif
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

    <form method="POST" action="{{ route('kader.pengukuran.store') }}">
        @csrf

        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- Pilih Anak -->
            <div>
                <label for="id_anak" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Pilih Anak <span style="color: #EF4444;">*</span></label>
                <select x-model="selectedAnakId" name="id_anak" id="id_anak" required style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; font-size: 15px; appearance: none; background: url('data:image/svg+xml;utf8,<svg viewBox=\"0 0 24 24\" fill=\"%2394A3B8\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>') no-repeat right 12px center; background-size: 24px;">
                    <option value="">-- Pilih Nama Anak --</option>
                    @foreach($anakList as $anak)
                        <option value="{{ $anak->id_anak }}">
                            {{ $anak->nama_anak }} (NIK: {{ $anak->nik_anak }})
                        </option>
                    @endforeach
                </select>

                <!-- Dynamic Info Box -->
                <template x-if="selectedAnak">
                    <div style="margin-top: 12px; padding: 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; font-size: 14px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <div style="color: #64748B; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Tgl Lahir</div>
                                <strong style="color: #334155;" x-text="formatDate(selectedAnak.tgl_lahir)"></strong>
                            </div>
                            <div>
                                <div style="color: #64748B; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Usia Bayi</div>
                                <strong style="color: #0F766E;"><span x-text="umurBulan"></span> Bulan</strong>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Tanggal Pengukuran -->
            <div>
                <label for="tanggal_pengukuran" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Tanggal Pengukuran <span style="color: #EF4444;">*</span></label>
                <input x-model="measurementDate" type="date" name="tanggal_pengukuran" id="tanggal_pengukuran" required style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; font-size: 15px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <!-- Berat Badan -->
                <div>
                    <label for="berat_badan" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Berat Badan (kg) <span style="color: #EF4444;">*</span></label>
                    <input type="number" step="0.01" name="berat_badan" id="berat_badan" value="{{ old('berat_badan') }}" required placeholder="Contoh: 12.5" style="width: 100%; padding: 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; font-size: 20px; text-align: center; font-weight: 700; color: #0F172A;">
                </div>

                <!-- Tinggi Badan -->
                <div>
                    <label for="tinggi_badan" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Tinggi/Panjang (cm) <span style="color: #EF4444;">*</span></label>
                    <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan" value="{{ old('tinggi_badan') }}" required placeholder="Contoh: 85.0" style="width: 100%; padding: 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; font-size: 20px; text-align: center; font-weight: 700; color: #0F172A;">
                </div>
            </div>

            <!-- Lingkar Kepala -->
            <div>
                <label for="lingkar_kepala" style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Lingkar Kepala (cm)</label>
                <input type="number" step="0.1" name="lingkar_kepala" id="lingkar_kepala" value="{{ old('lingkar_kepala') }}" placeholder="Opsional, Contoh: 45.0" style="width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 12px; font-family: inherit; font-size: 15px;">
            </div>

            <div style="margin-top: 16px;">
                <button type="submit" style="width: 100%; padding: 16px; background: linear-gradient(135deg, #0D9488, #0F766E); color: #fff; border: none; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; transition: all 0.3s; box-shadow: 0 8px 16px rgba(13,148,136,0.2);">
                    Simpan Pengukuran
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function pengukuranForm() {
    return {
        selectedAnakId: '{{ old('id_anak') }}',
        measurementDate: '{{ old('tanggal_pengukuran', date('Y-m-d')) }}',
        children: {
            @foreach($anakList as $anak)
            '{{ $anak->id_anak }}': {
                nama: '{!! addslashes($anak->nama_anak) !!}',
                tgl_lahir: '{{ $anak->tanggal_lahir ? $anak->tanggal_lahir->format('Y-m-d') : '' }}'
            },
            @endforeach
        },
        get selectedAnak() {
            return this.children[this.selectedAnakId] || null;
        },
        formatDate(dateString) {
            if (!dateString) return '-';
            const d = new Date(dateString);
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        },
        get umurBulan() {
            if (!this.selectedAnak || !this.selectedAnak.tgl_lahir || !this.measurementDate) return '-';
            const mDate = new Date(this.measurementDate);
            const bDate = new Date(this.selectedAnak.tgl_lahir);
            if (mDate < bDate) return '0 (Belum lahir)';
            
            let months = (mDate.getFullYear() - bDate.getFullYear()) * 12;
            months -= bDate.getMonth();
            months += mDate.getMonth();
            
            if (mDate.getDate() < bDate.getDate()) {
                months--;
            }
            return months >= 0 ? months : 0;
        }
    }
}
</script>
@endsection
