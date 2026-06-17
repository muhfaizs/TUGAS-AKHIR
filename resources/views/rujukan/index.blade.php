@extends('layouts.app')

@section('title', 'Surat Rujukan - SatuKIA')
@section('header_title', 'Surat Rujukan')
@section('header_subtitle', 'Manajemen rujukan pasien dengan risiko sangat tinggi')

@section('content')
<div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Daftar Pasien Rujukan</h3>
            <p class="text-sm text-slate-500">Ibu hamil dengan status risiko "Sangat Tinggi"</p>
        </div>
    </div>

    @if($pasienRujukan->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="rujukanTable">
            <thead>
                <tr>
                    <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">NAMA PASIEN</th>
                    <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">USIA / ALAMAT</th>
                    <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">HPHT / HPL</th>
                    <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100">TINDAKAN MEDIS / KELUHAN</th>
                    <th class="pb-4 font-bold text-slate-500 text-xs tracking-wider uppercase border-b border-slate-100 text-right">AKSI</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach($pasienRujukan as $pasien)
                <tr class="hover:bg-slate-50 transition-colors border-b border-slate-50">
                    <td class="py-4 font-bold text-slate-800">
                        <a href="{{ route('ibu-hamil.show', $pasien->id) }}" class="hover:text-teal-600 transition-colors">{{ $pasien->nama_lengkap }}</a>
                    </td>
                    <td class="py-4 text-slate-600">{{ $pasien->umur }} Thn<br><span class="text-xs text-slate-400">{{ Str::limit($pasien->alamat, 30) }}</span></td>
                    <td class="py-4 text-slate-600">{{ $pasien->hpht ? \Carbon\Carbon::parse($pasien->hpht)->translatedFormat('d M Y') : '-' }}<br><span class="text-xs text-emerald-600 font-medium">{{ $pasien->hpl ? \Carbon\Carbon::parse($pasien->hpl)->translatedFormat('d M Y') : '-' }}</span></td>
                    <td class="py-4 text-slate-600"><span class="block max-w-[200px] truncate" title="{{ $pasien->tindakan_medis }}">{{ $pasien->tindakan_medis ?: 'Belum ada tindakan.' }}</span></td>
                    <td class="py-4 text-right">
                        <button type="button" onclick="openCetakModal({{ $pasien->id }}, '{{ addslashes($pasien->nama_lengkap) }}')" class="inline-flex items-center gap-2 bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-sm shadow-rose-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak Surat
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-12">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h4 class="text-lg font-bold text-slate-700 mb-2">Tidak Ada Pasien Rujukan</h4>
        <p class="text-slate-500">Saat ini tidak ada data ibu hamil dengan status risiko "Sangat Tinggi".</p>
    </div>
    @endif
</div>

<!-- Modal Cetak Surat -->
<div id="cetak-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden transition-opacity">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl relative">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-slate-800">Cetak Surat Rujukan</h3>
            <button type="button" onclick="closeCetakModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <p class="text-slate-500 text-sm mb-6">Pasien: <strong id="nama_pasien_modal" class="text-slate-800"></strong></p>

        <form id="formCetak" method="POST" action="">
            @csrf
            <div class="mb-6">
                <label for="rumah_sakit" class="block text-sm font-bold text-slate-700 mb-2">Rumah Sakit Tujuan <span class="text-rose-500">*</span></label>
                <input type="text" id="rumah_sakit" name="rumah_sakit" required placeholder="Contoh: RSUD Kota / Dokter Spesialis Kandungan" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block p-3 transition-colors">
                <p class="text-xs text-slate-400 mt-2">Nama rumah sakit akan dicetak pada bagian tujuan surat.</p>
            </div>
            
            <div class="flex gap-4">
                <button type="button" onclick="closeCetakModal()" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button type="submit" onclick="setTimeout(closeCetakModal, 1000);" class="flex-1 px-4 py-2.5 bg-rose-500 text-white rounded-xl font-bold hover:bg-rose-600 transition-colors shadow-sm shadow-rose-200">
                    Cetak & Download
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openCetakModal(pasienId, namaPasien) {
        document.getElementById('nama_pasien_modal').innerText = namaPasien;
        // Update form action
        const form = document.getElementById('formCetak');
        form.action = `/rujukan/${pasienId}/cetak`;
        document.getElementById('cetak-modal').classList.remove('hidden');
    }

    function closeCetakModal() {
        document.getElementById('cetak-modal').classList.add('hidden');
        document.getElementById('rumah_sakit').value = '';
    }

    // Initialize datatable
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("rujukanTable")) {
            new simpleDatatables.DataTable("#rujukanTable", {
                searchable: true,
                fixedHeight: true,
                perPage: 10,
                labels: {
                    placeholder: "Cari data...",
                    perPage: "data per halaman",
                    noRows: "Tidak ada data ditemukan",
                    info: "Menampilkan {start} sampai {end} dari {rows} data"
                }
            });
        }
    });
</script>
@endpush
