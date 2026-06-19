@extends('layouts.dashboard')

@section('title', 'Input Pelayanan KB')
@section('page_title', 'Input Pelayanan KB')
@section('page_subtitle', 'Kelola data pelayanan KB untuk pasien')

@section('content')
<div class="min-h-screen bg-transparent">
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
                        <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
                            <h3 class="text-lg font-bold text-slate-800 mb-5">Pilih Akseptor</h3>
                            <div>
                                <label class="block text-slate-700 font-medium mb-2">Akseptor KB *</label>
                                <div class="relative">
                                    <input type="text" id="acceptor_search" placeholder="Cari nama, NIK, atau nomor HP pasien..." class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500" autocomplete="off" required oninvalid="this.setCustomValidity('Mohon pilih Pasien KB terlebih dahulu')" oninput="this.setCustomValidity('')">
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
                                                fetch(`/kb-acceptors/search?q=${encodeURIComponent(query)}`)
                                                    .then(res => res.json())
                                                    .then(data => {
                                                        resultsDiv.innerHTML = '';
                                                        if (data.length === 0) {
                                                            resultsDiv.innerHTML = '<div class="px-4 py-3 text-gray-500 text-sm">Tidak ditemukan pasien dengan pencarian tersebut.</div>';
                                                        } else {
                                                            data.forEach(item => {
                                                                const div = document.createElement('div');
                                                                div.className = 'px-4 py-3 hover:bg-slate-50 cursor-pointer border-b border-gray-50 last:border-0 transition-colors';
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

                        <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
                            <h3 class="text-lg font-bold text-slate-800 mb-5">Jenis Metode KB</h3>
                            <div>
                                <label class="block text-slate-700 font-medium mb-2">Metode KB *</label>
                                <select name="service_method" required class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500">
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

                        <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
                            <h3 class="text-lg font-bold text-slate-800 mb-5">Informasi Layanan</h3>
                            <div class="grid gap-6 md:grid-cols-3">
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Tanggal Pelayanan *</label>
                                    <input type="date" name="service_date" value="{{ old('service_date', date('Y-m-d')) }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500" required>
                                    @error('service_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Lokasi Layanan</label>
                                    <select name="location" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500">
                                        <option value="puskesmas" @selected(old('location') == 'puskesmas')>Puskesmas</option>
                                        <option value="kader" @selected(old('location') == 'kader')>Kader</option>
                                        <option value="rumah" @selected(old('location') == 'rumah')>Rumah</option>
                                        <option value="posyandu" @selected(old('location') == 'posyandu')>Posyandu</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Nomor Batch (Alat)</label>
                                    <input type="text" name="batch_number" value="{{ old('batch_number') }}" placeholder="Nomor seri alat/obat" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500">
                                </div>
                            </div>
                        </section>

                        <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
                            <h3 class="text-lg font-bold text-slate-800 mb-5">Pemeriksaan Kesehatan</h3>
                            <div class="grid gap-6 md:grid-cols-2 mb-4">
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Tekanan Darah</label>
                                    <input type="text" name="blood_pressure" value="{{ old('blood_pressure') }}" placeholder="120/80" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500">
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Berat Badan (kg)</label>
                                    <input type="number" name="weight" value="{{ old('weight') }}" step="0.1" placeholder="65.5" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-slate-700 font-medium mb-2">Temuan Klinis</label>
                                <textarea name="clinical_findings" rows="3" placeholder="Hasil pemeriksaan fisik klinis" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500">{{ old('clinical_findings') }}</textarea>
                            </div>
                        </section>

                        <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
                            <h3 class="text-lg font-bold text-slate-800 mb-5">Kontraindikasi & Efek Samping</h3>
                            <div class="grid gap-6 md:grid-cols-2" 
                                 x-data="{ 
                                    contraSelected: [], 
                                    contraLainnya: '',
                                    sideSelected: [],
                                    sideLainnya: '',
                                    init() {
                                        const oldContra = `{{ old('contraindication') }}`;
                                        const contraOpts = ['Hipertensi', 'Diabetes Melitus', 'Penyakit Jantung', 'Riwayat Stroke', 'Migrain Berat', 'Kanker Payudara', 'Gangguan Hati', 'Gangguan Pembekuan Darah', 'Merokok usia >35 tahun', 'Sedang Hamil', 'Tidak ada kontraindikasi'];
                                        if(oldContra) {
                                            let parts = oldContra.split(',').map(s => s.trim());
                                            this.contraSelected = parts.filter(p => contraOpts.includes(p));
                                            this.contraLainnya = parts.filter(p => !contraOpts.includes(p)).join(', ');
                                        }
                                        
                                        const oldSide = `{{ old('side_effects') }}`;
                                        const sideOpts = ['Mual', 'Pusing', 'Sakit kepala', 'Berat badan meningkat', 'Perdarahan', 'Menstruasi tidak teratur', 'Nyeri panggul', 'Jerawat', 'Nyeri payudara', 'Tidak ada efek samping'];
                                        if(oldSide) {
                                            let parts = oldSide.split(',').map(s => s.trim());
                                            this.sideSelected = parts.filter(p => sideOpts.includes(p));
                                            this.sideLainnya = parts.filter(p => !sideOpts.includes(p)).join(', ');
                                        }
                                    },
                                    get contraResult() {
                                        let res = this.contraSelected.join(', ');
                                        if(this.contraLainnya) res += (res ? ', ' : '') + this.contraLainnya;
                                        return res;
                                    },
                                    get sideResult() {
                                        let res = this.sideSelected.join(', ');
                                        if(this.sideLainnya) res += (res ? ', ' : '') + this.sideLainnya;
                                        return res;
                                    }
                                }">
                                
                                <input type="hidden" name="contraindication" :value="contraResult">
                                <input type="hidden" name="side_effects" :value="sideResult">

                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Kontraindikasi</label>
                                    <div class="space-y-2 mb-3 max-h-60 overflow-y-auto border border-slate-200 rounded-xl p-4 bg-slate-50/50 custom-scrollbar">
                                        @php
                                            $contraOptions = ['Hipertensi', 'Diabetes Melitus', 'Penyakit Jantung', 'Riwayat Stroke', 'Migrain Berat', 'Kanker Payudara', 'Gangguan Hati', 'Gangguan Pembekuan Darah', 'Merokok usia >35 tahun', 'Sedang Hamil', 'Tidak ada kontraindikasi'];
                                        @endphp
                                        @foreach($contraOptions as $opt)
                                        <label class="flex items-start gap-3 cursor-pointer group">
                                            <div class="relative flex items-center mt-0.5">
                                                <input type="checkbox" value="{{ $opt }}" x-model="contraSelected" class="peer h-4 w-4 cursor-pointer appearance-none rounded border border-slate-300 checked:border-blue-600 checked:bg-blue-600 transition-all focus:ring-blue-500">
                                                <svg class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-3 h-3 text-white pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                            <span class="text-sm text-slate-700 group-hover:text-slate-900">{{ $opt }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    <label class="block text-slate-700 text-sm font-medium mb-1">Tambahkan (Lainnya):</label>
                                    <textarea x-model="contraLainnya" rows="2" placeholder="Lainnya..." class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500"></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Efek Samping / Reaksi</label>
                                    <div class="space-y-2 mb-3 max-h-60 overflow-y-auto border border-slate-200 rounded-xl p-4 bg-slate-50/50 custom-scrollbar">
                                        @php
                                            $sideOptions = ['Mual', 'Pusing', 'Sakit kepala', 'Berat badan meningkat', 'Perdarahan', 'Menstruasi tidak teratur', 'Nyeri panggul', 'Jerawat', 'Nyeri payudara', 'Tidak ada efek samping'];
                                        @endphp
                                        @foreach($sideOptions as $opt)
                                        <label class="flex items-start gap-3 cursor-pointer group">
                                            <div class="relative flex items-center mt-0.5">
                                                <input type="checkbox" value="{{ $opt }}" x-model="sideSelected" class="peer h-4 w-4 cursor-pointer appearance-none rounded border border-slate-300 checked:border-blue-600 checked:bg-blue-600 transition-all focus:ring-blue-500">
                                                <svg class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-3 h-3 text-white pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                            <span class="text-sm text-slate-700 group-hover:text-slate-900">{{ $opt }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    <label class="block text-slate-700 text-sm font-medium mb-1">Catatan Tambahan:</label>
                                    <textarea x-model="sideLainnya" rows="2" placeholder="Catatan tambahan..." class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500"></textarea>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
                            <h3 class="text-lg font-bold text-slate-800 mb-5">Jadwal Follow-up</h3>
                            <div class="grid gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Tanggal Follow-up</label>
                                    <input type="date" name="follow_up_date" value="{{ old('follow_up_date') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500">
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-medium mb-2">Tipe Follow-up</label>
                                    <select name="follow_up_type" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500">
                                        <option value="">Pilih...</option>
                                        <option value="phone" @selected(old('follow_up_type') == 'phone')>Telepon</option>
                                        <option value="visit" @selected(old('follow_up_type') == 'visit')>Kunjungan</option>
                                        <option value="sms" @selected(old('follow_up_type') == 'sms')>SMS/Pesan</option>
                                    </select>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
                            <h3 class="text-lg font-bold text-slate-800 mb-5">Catatan Tambahan</h3>
                            <div>
                                <label class="block text-slate-700 font-medium mb-2">Catatan</label>
                                <textarea name="notes" rows="4" placeholder="Catatan penting lainnya" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-slate-900 shadow-sm outline-none transition focus:ring-2 focus:ring-teal-500 focus:bg-white focus:border-teal-500">{{ old('notes') }}</textarea>
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

