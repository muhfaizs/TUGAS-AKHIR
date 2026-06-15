@extends('layouts.app')

@section('title', 'Edit Layanan KB')

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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Kontraindikasi</label>
                            <textarea name="contraindication" rows="3" placeholder="Kondisi kesehatan yang tidak sesuai"
                                      class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600">{{ old('contraindication', $kbService->contraindication) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Efek Samping / Reaksi</label>
                            <textarea name="side_effects" rows="3" placeholder="Efek samping yang mungkin timbul"
                                      class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-600">{{ old('side_effects', $kbService->side_effects) }}</textarea>
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
                <div class="flex gap-2 justify-between">
                    <a href="{{ route('kb-services.show', $kbService->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">
                        Batal
                    </a>
                    <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded">
                        Perbarui Layanan KB
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
