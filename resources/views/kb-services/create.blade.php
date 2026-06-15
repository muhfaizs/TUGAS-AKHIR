@extends('layouts.app')

@section('title', 'Input Pelayanan KB')
@section('header_subtitle', 'Kelola data pelayanan KB untuk pasien')

@section('content')
<div class="min-h-screen bg-transparent">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-[#105448] to-[#1c7c6b] rounded-2xl p-8 mb-8 shadow-lg text-white flex flex-wrap gap-4 justify-between items-center relative overflow-hidden">
            <!-- Decorative shapes -->
            <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white opacity-5 rounded-full"></div>
            <div class="absolute bottom-0 right-32 -mb-12 w-32 h-32 bg-black opacity-10 rounded-full"></div>
            
            <div class="relative z-10">
                <h1 class="text-3xl font-bold mb-2">Input Pelayanan KB</h1>
                <p class="text-teal-100 text-sm">Pilih pasien dan catat riwayat kunjungan</p>
            </div>
            <a href="{{ route('kb-services.index') }}" class="relative z-10 bg-white text-[#117a65] px-6 py-2.5 rounded-xl font-bold shadow hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center gap-2 no-underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
    </div>

    <div class="bg-white rounded-3xl shadow border border-gray-100 overflow-hidden mb-8">
        <div class="px-8 py-8">
                @if ($errors->any())
                    <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 p-5 text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('kb-services.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <section class="rounded-3xl bg-slate-50 p-6">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Pilih Akseptor</h3>
                            <div>
                                <label class="block text-slate-700 font-medium mb-2">Akseptor KB *</label>
                                <div class="relative">
                                    <input type="text" id="acceptor_search" placeholder="Cari nama, NIK, atau nomor HP pasien..." class="w-full rounded-2xl border-none bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-[#117a65]" autocomplete="off" required oninvalid="this.setCustomValidity('Mohon pilih Pasien KB terlebih dahulu')" oninput="this.setCustomValidity('')">
                                    <input type="hidden" name="kb_acceptor_id" id="kb_acceptor_id" value="{{ old('kb_acceptor_id', $selectedAcceptorId ?? '') }}">
                                    <div id="search_results" class="absolute z-10 w-full mt-1 bg-white border border-gray-100 rounded-2xl shadow-lg hidden overflow-hidden max-h-60 overflow-y-auto">
                                        <!-- Hasil pencarian akan muncul di sini -->
                                    </div>
                                </div>
                                @error('kb_acceptor_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const searchInput = document.getElementById('acceptor_search');
                                        const hiddenInput = document.getElementById('kb_acceptor_id');
                                        const resultsDiv = document.getElementById('search_results');
                                        
                                        // Set initial value if exist
                                        const initialId = hiddenInput.value;
                                        if (initialId) {
                                            @foreach($acceptors as $acceptor)
                                                if ('{{ $acceptor->id }}' === initialId) {
                                                    searchInput.value = '{{ $acceptor->full_name }} ({{ $acceptor->nik }})';
                                                }
                                            @endforeach
                                        }

                                        let debounceTimer;

                                        searchInput.addEventListener('input', function() {
                                            clearTimeout(debounceTimer);
                                            const query = this.value;
                                            
                                            if (query.length < 2) {
                                                resultsDiv.classList.add('hidden');
                                                hiddenInput.value = ''; 
                                                return;
                                            }

                                            debounceTimer = setTimeout(() => {
                                                fetch(`/api/kb-services/search?q=${encodeURIComponent(query)}`)
                                                    .then(res => res.json())
                                                    .then(data => {
                                                        resultsDiv.innerHTML = '';
                                                        if (data.length === 0) {
                                                            resultsDiv.innerHTML = '<div class="px-4 py-3 text-gray-500 text-sm">Tidak ditemukan pasien dengan pencarian tersebut.</div>';
                                                        } else {
                                                            data.forEach(item => {
                                                                const div = document.createElement('div');
                                                                div.className = 'px-4 py-3 hover:bg-[#eef7f5] cursor-pointer border-b border-gray-50 last:border-0 transition-colors';
                                                                div.innerHTML = `<div class="font-medium text-slate-800">${item.full_name}</div><div class="text-xs text-slate-500">NIK: ${item.nik} | HP: ${item.phone || '-'}</div>`;
                                                                div.addEventListener('click', () => {
                                                                    searchInput.value = item.full_name + ' (' + item.nik + ')';
                                                                    hiddenInput.value = item.id;
                                                                    resultsDiv.classList.add('hidden');
                                                                });
                                                                resultsDiv.appendChild(div);
                                                            });
                                                        }
                                                        resultsDiv.classList.remove('hidden');
                                                    });
                                            }, 300);
                                        });

                                        document.addEventListener('click', function(e) {
                                            if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
                                                resultsDiv.classList.add('hidden');
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </section>

                        <section class="rounded-3xl bg-slate-50 p-6">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Jenis Metode KB</h3>
                            <div>
                                <label class="block text-slate-700 font-medium mb-2">Metode KB *</label>
                                <select name="service_method" required class="w-full rounded-2xl border-none bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-[#117a65]">
                                    <option value="">Pilih Metode...</option>
                                    <option value="IUD" @selected(old('service_method') == 'IUD')>IUD (Intrauterine Device)</option>
                                    <option value="Implant" @selected(old('service_method') == 'Implant')>Implant</option>
                                    <option value="Pil" @selected(old('service_method') == 'Pil')>Pil</option>
                                    <option value="Suntik" @selected(old('service_method') == 'Suntik')>Suntik</option>
                                    <option value="Kondom" @selected(old('service_method') == 'Kondom')>Kondom</option>
                                </select>
                                @error('service_method') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </section>

                        <section class="rounded-3xl bg-slate-50 p-6">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Layanan</h3>
                            <div class="grid gap-4 md:grid-cols-3">
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Tanggal Pelayanan *</label>
                                    <input type="date" name="service_date" value="{{ old('service_date', date('Y-m-d')) }}" class="w-full rounded-2xl border-none bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-[#117a65]" required>
                                    @error('service_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Lokasi Layanan</label>
                                    <select name="location" class="w-full rounded-2xl border-none bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-[#117a65]">
                                        <option value="puskesmas" @selected(old('location') == 'puskesmas')>Puskesmas</option>
                                        <option value="kader" @selected(old('location') == 'kader')>Kader</option>
                                        <option value="rumah" @selected(old('location') == 'rumah')>Rumah</option>
                                        <option value="posyandu" @selected(old('location') == 'posyandu')>Posyandu</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Nomor Batch (Alat)</label>
                                    <input type="text" name="batch_number" value="{{ old('batch_number') }}" placeholder="Nomor seri alat/obat" class="w-full rounded-2xl border-none bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-[#117a65]">
                                </div>
                            </div>
                        </section>

                        <section class="rounded-3xl bg-slate-50 p-6">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Pemeriksaan Kesehatan</h3>
                            <div class="grid gap-4 md:grid-cols-3 mb-4">
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Tekanan Darah</label>
                                    <input type="text" name="blood_pressure" value="{{ old('blood_pressure') }}" placeholder="120/80" class="w-full rounded-2xl border-none bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-[#117a65]">
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Berat Badan (kg)</label>
                                    <input type="number" name="weight" value="{{ old('weight') }}" step="0.1" placeholder="65.5" class="w-full rounded-2xl border-none bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-[#117a65]">
                                </div>
                            </div>
                            <div>
                                <label class="block text-slate-700 font-medium mb-2">Temuan Klinis</label>
                                <textarea name="clinical_findings" rows="3" placeholder="Hasil pemeriksaan fisik klinis" class="w-full rounded-2xl border-none bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-[#117a65]">{{ old('clinical_findings') }}</textarea>
                            </div>
                        </section>

                        <section class="rounded-3xl bg-slate-50 p-6">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Kontraindikasi & Efek Samping</h3>
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Kontraindikasi</label>
                                    <textarea name="contraindication" rows="3" placeholder="Kondisi kesehatan yang tidak sesuai" class="w-full rounded-2xl border-none bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-[#117a65]">{{ old('contraindication') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Efek Samping / Reaksi</label>
                                    <textarea name="side_effects" rows="3" placeholder="Efek samping yang mungkin timbul" class="w-full rounded-2xl border-none bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-[#117a65]">{{ old('side_effects') }}</textarea>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-3xl bg-slate-50 p-6">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Jadwal Follow-up</h3>
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Tanggal Follow-up</label>
                                    <input type="date" name="follow_up_date" value="{{ old('follow_up_date') }}" class="w-full rounded-2xl border-none bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-[#117a65]">
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Tipe Follow-up</label>
                                    <select name="follow_up_type" class="w-full rounded-2xl border-none bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-[#117a65]">
                                        <option value="">Pilih...</option>
                                        <option value="phone" @selected(old('follow_up_type') == 'phone')>Telepon</option>
                                        <option value="visit" @selected(old('follow_up_type') == 'visit')>Kunjungan</option>
                                        <option value="sms" @selected(old('follow_up_type') == 'sms')>SMS/Pesan</option>
                                    </select>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-3xl bg-slate-50 p-6">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Catatan Tambahan</h3>
                            <div>
                                <label class="block text-slate-700 font-medium mb-2">Catatan</label>
                                <textarea name="notes" rows="4" placeholder="Catatan penting lainnya" class="w-full rounded-2xl border-none bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-[#117a65]">{{ old('notes') }}</textarea>
                            </div>
                        </section>

                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end mt-8">
                            <a href="{{ route('kb-services.index') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 no-underline">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#117a65] hover:bg-[#0f6b58] px-6 py-3 text-sm font-semibold text-white transition shadow-sm hover:shadow-md">
                                Simpan Layanan KB
                            </button>
                        </div>
                    </div>
                </form>
            </div>
    </div>
</div>
@endsection
