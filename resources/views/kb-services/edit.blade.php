@extends('layouts.dashboard')

@section('title', 'Edit Layanan KB')
@section('page_title', 'Edit Layanan KB')

@section('content')
<div class="bg-white">
    <div class="max-w-4xl mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Layanan KB</h1>
            <p class="text-gray-600">Perbarui data layanan KB untuk {{ $kbService->acceptor->full_name }}</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kb-services.update', $kbService->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Akseptor Selection -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Akseptor</h2>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Akseptor KB *</label>
                        <select name="kb_acceptor_id" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600">
                            <option value="">-- Pilih akseptor --</option>
                            @foreach($acceptors as $acceptor)
                                <option value="{{ $acceptor->id }}" 
                                        @selected(old('kb_acceptor_id', $kbService->kb_acceptor_id) == $acceptor->id)>
                                    {{ $acceptor->full_name }} ({{ $acceptor->nik }})
                                </option>
                            @endforeach
                        </select>
                        @error('kb_acceptor_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Metode KB -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Jenis Metode KB</h2>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Metode KB *</label>
                        <select name="service_method" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600">
                            <option value="">Pilih Metode...</option>
                            <option value="IUD" @selected(old('service_method', $kbService->service_method) == 'IUD')>IUD (Intrauterine Device)</option>
                            <option value="Implant" @selected(old('service_method', $kbService->service_method) == 'Implant')>Implant</option>
                            <option value="Pil" @selected(old('service_method', $kbService->service_method) == 'Pil')>Pil</option>
                            <option value="Suntik" @selected(old('service_method', $kbService->service_method) == 'Suntik')>Suntik</option>
                            <option value="Kondom" @selected(old('service_method', $kbService->service_method) == 'Kondom')>Kondom</option>
                        </select>
                        @error('service_method') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Lokasi & Batch -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Informasi Layanan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Pelayanan *</label>
                            <input type="date" name="service_date" value="{{ old('service_date', $kbService->service_date->format('Y-m-d')) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600">
                            @error('service_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Lokasi Layanan</label>
                            <input type="text" name="location" value="{{ old('location', $kbService->location) }}" placeholder="Puskesmas, Klinik, dll"
                                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nomor Batch (Alat)</label>
                            <input type="text" name="batch_number" value="{{ old('batch_number', $kbService->batch_number) }}" placeholder="Nomor seri alat/obat"
                                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600">
                        </div>
                    </div>
                </div>

                <!-- Kesehatan -->
                <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Pemeriksaan Kesehatan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tekanan Darah</label>
                            <input type="text" name="blood_pressure" value="{{ old('blood_pressure', $kbService->blood_pressure) }}" placeholder="120/80"
                                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Berat Badan (kg)</label>
                            <input type="number" name="weight" value="{{ old('weight', $kbService->weight) }}" step="0.1" placeholder="65.5"
                                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600">
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Temuan Klinis</label>
                        <textarea name="clinical_findings" rows="3" placeholder="Hasil pemeriksaan fisik klinis"
                                  class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600">{{ old('clinical_findings', $kbService->clinical_findings) }}</textarea>
                    </div>
                </div>

                <!-- Kontraindikasi & Efek Samping -->
                <div class="bg-red-50 p-6 rounded-lg border border-red-200">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Kontraindikasi & Efek Samping</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4"
                         x-data="{ 
                            contraSelected: [], 
                            contraLainnya: '',
                            sideSelected: [],
                            sideLainnya: '',
                            init() {
                                const oldContra = `{{ old('contraindication', $kbService->contraindication ?? '') }}`;
                                const contraOpts = ['Hipertensi', 'Diabetes Melitus', 'Penyakit Jantung', 'Riwayat Stroke', 'Migrain Berat', 'Kanker Payudara', 'Gangguan Hati', 'Gangguan Pembekuan Darah', 'Merokok usia >35 tahun', 'Sedang Hamil', 'Tidak ada kontraindikasi'];
                                if(oldContra) {
                                    let parts = oldContra.split(',').map(s => s.trim());
                                    this.contraSelected = parts.filter(p => contraOpts.includes(p));
                                    this.contraLainnya = parts.filter(p => !contraOpts.includes(p)).join(', ');
                                }
                                
                                const oldSide = `{{ old('side_effects', $kbService->side_effects ?? '') }}`;
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
                            <label class="block text-gray-700 font-medium mb-2">Kontraindikasi</label>
                            <div class="space-y-2 mb-3 max-h-60 overflow-y-auto border border-gray-300 rounded bg-white p-3">
                                @php
                                    $contraOptions = ['Hipertensi', 'Diabetes Melitus', 'Penyakit Jantung', 'Riwayat Stroke', 'Migrain Berat', 'Kanker Payudara', 'Gangguan Hati', 'Gangguan Pembekuan Darah', 'Merokok usia >35 tahun', 'Sedang Hamil', 'Tidak ada kontraindikasi'];
                                @endphp
                                @foreach($contraOptions as $opt)
                                <label class="flex items-start gap-2 cursor-pointer">
                                    <input type="checkbox" value="{{ $opt }}" x-model="contraSelected" class="mt-1 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $opt }}</span>
                                </label>
                                @endforeach
                            </div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Tambahkan (Lainnya):</label>
                            <textarea x-model="contraLainnya" rows="2" placeholder="Lainnya..." class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Efek Samping / Reaksi</label>
                            <div class="space-y-2 mb-3 max-h-60 overflow-y-auto border border-gray-300 rounded bg-white p-3">
                                @php
                                    $sideOptions = ['Mual', 'Pusing', 'Sakit kepala', 'Berat badan meningkat', 'Perdarahan', 'Menstruasi tidak teratur', 'Nyeri panggul', 'Jerawat', 'Nyeri payudara', 'Tidak ada efek samping'];
                                @endphp
                                @foreach($sideOptions as $opt)
                                <label class="flex items-start gap-2 cursor-pointer">
                                    <input type="checkbox" value="{{ $opt }}" x-model="sideSelected" class="mt-1 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $opt }}</span>
                                </label>
                                @endforeach
                            </div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Catatan Tambahan:</label>
                            <textarea x-model="sideLainnya" rows="2" placeholder="Catatan tambahan..." class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Follow-up -->
                <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Jadwal Follow-up</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Follow-up</label>
                            <input type="date" name="follow_up_date" value="{{ old('follow_up_date', $kbService->follow_up_date?->format('Y-m-d')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tipe Follow-up</label>
                            <select name="follow_up_type" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600">
                                <option value="">Pilih...</option>
                                <option value="Phone" @selected(old('follow_up_type', $kbService->follow_up_type) == 'Phone')>Telepon</option>
                                <option value="Visit" @selected(old('follow_up_type', $kbService->follow_up_type) == 'Visit')>Kunjungan</option>
                                <option value="SMS" @selected(old('follow_up_type', $kbService->follow_up_type) == 'SMS')>SMS/Pesan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Catatan -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Catatan Tambahan</h2>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Catatan</label>
                        <textarea name="notes" rows="4" placeholder="Catatan penting lainnya"
                                  class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600">{{ old('notes', $kbService->notes) }}</textarea>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 justify-end mt-8 border-t border-gray-100 pt-6">
                    <a href="{{ route('kb-services.show', $kbService->id) }}" 
                       class="px-6 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl shadow-sm transition-all flex items-center justify-center">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-[#117a65] hover:bg-[#0e6352] text-white font-semibold rounded-xl shadow-sm transition-all flex items-center justify-center">
                        Perbarui Layanan KB
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

