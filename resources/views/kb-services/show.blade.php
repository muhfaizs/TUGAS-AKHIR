@extends('layouts.dashboard')

@section('title', 'Detail Layanan KB')
@section('page_title', 'Riwayat Pelayanan KB')

@section('content')
<div class="bg-white">
    <div class="max-w-6xl mx-auto px-6 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Layanan KB - {{ $kbService->acceptor->full_name }}</h1>
                <p class="text-gray-600 mt-1">
                    <span class="badge px-3 py-1 rounded-full text-sm font-medium
                        @if($kbService->is_verified)
                            bg-green-100 text-green-800
                        @else
                            bg-yellow-100 text-yellow-800
                        @endif">
                        {{ $kbService->is_verified ? 'Terverifikasi' : 'Pending Verifikasi' }}
                    </span>
                    <span class="badge px-3 py-1 rounded-full text-sm font-medium ml-2
                        @if($kbService->risk_level == 'Tinggi')
                            bg-red-100 text-red-800
                        @elseif($kbService->risk_level == 'Sedang')
                            bg-yellow-100 text-yellow-800
                        @else
                            bg-green-100 text-green-800
                        @endif">
                        @if($kbService->risk_level == 'Tinggi')
                            <span class="w-2 h-2 rounded-full bg-red-500 inline-block mr-1"></span>
                        @elseif($kbService->risk_level == 'Sedang')
                            <span class="w-2 h-2 rounded-full bg-yellow-500 inline-block mr-1"></span>
                        @else
                            <span class="w-2 h-2 rounded-full bg-green-500 inline-block mr-1"></span>
                        @endif
                        Risiko {{ $kbService->risk_level }}
                    </span>
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('kb-services.edit', $kbService->id) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded no-underline flex items-center justify-center border-none h-10 font-medium">
                    Edit
                </a>
                @if(!$kbService->is_verified)
                    <form action="{{ route('kb-services.verify', $kbService->id) }}" method="POST" class="m-0 flex items-center">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded flex items-center justify-center border-none h-10 font-medium">
                            Verifikasi
                        </button>
                    </form>
                @endif
                <form action="{{ route('kb-services.destroy', $kbService->id) }}" method="POST" class="m-0 flex items-center">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded flex items-center justify-center border-none h-10 font-medium" 
                            onclick="return confirm('Yakin hapus layanan ini?')">
                        Hapus
                    </button>
                </form>
                <a href="{{ route('kb-services.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white text-sm px-4 py-2 rounded no-underline flex items-center justify-center border-none h-10 font-medium">
                    Kembali
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Akseptor Info -->
        <div class="bg-blue-50 p-6 rounded-lg mb-8 border border-blue-200">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Informasi Akseptor</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Nama</label>
                    <p class="font-medium">{{ $kbService->acceptor->full_name }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">NIK</label>
                    <p class="font-medium">{{ $kbService->acceptor->nik }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Puskesmas</label>
                    <p class="font-medium">{{ $kbService->puskesmasData->name }}</p>
                </div>
            </div>
        </div>

        <!-- Metode KB -->
        <div class="bg-teal-50 p-6 rounded-lg mb-8 border border-teal-200">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Metode KB</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Metode</label>
                    <p class="text-2xl font-bold text-teal-600">{{ $kbService->service_method }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Lokasi Layanan</label>
                    <p class="font-medium">{{ $kbService->location ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Nomor Batch</label>
                    <p class="font-medium">{{ $kbService->batch_number ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Pemeriksaan Kesehatan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Pemeriksaan Kesehatan</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-600">Tekanan Darah</label>
                        <p class="font-medium">{{ $kbService->blood_pressure ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Berat Badan</label>
                        <p class="font-medium">{{ $kbService->weight ? $kbService->weight . ' kg' : '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Temuan Klinis</label>
                        <p class="font-medium text-sm">{{ $kbService->clinical_findings ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 p-6 rounded-lg border border-red-200">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Kontraindikasi & Efek Samping</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-600">Kontraindikasi</label>
                        <p class="font-medium text-sm">{{ $kbService->contraindication ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Efek Samping</label>
                        <p class="font-medium text-sm">{{ $kbService->side_effects ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hasil Follow-up -->
        <div class="bg-green-50 p-6 rounded-lg mb-8 border border-green-200">
            <div class="flex items-center justify-between mb-4 border-b border-green-200 pb-3">
                <h2 class="text-lg font-bold text-gray-900">Hasil Follow-up</h2>
                @if($kbService->followUp && $kbService->followUp->status == 'selesai')
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-green-300">Selesai</span>
                @else
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-yellow-300">Belum Selesai / Belum Ada</span>
                @endif
            </div>

            @if($kbService->followUp)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Tanggal Follow-up</label>
                        <p class="font-medium mt-1">{{ $kbService->followUp->follow_up_date ? \Carbon\Carbon::parse($kbService->followUp->follow_up_date)->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Kehadiran</label>
                        <p class="font-medium mt-1">
                            @if($kbService->followUp->attendance_status == 'hadir')
                                <span class="text-green-600">Hadir</span>
                            @elseif($kbService->followUp->attendance_status == 'tidak_hadir')
                                <span class="text-red-600">Tidak Hadir</span>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Kondisi Akseptor</label>
                        <p class="font-medium mt-1">{{ $kbService->followUp->condition ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Keluhan</label>
                        <p class="font-medium mt-1">{{ $kbService->followUp->complaints ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Efek Samping</label>
                        <p class="font-medium mt-1">{{ $kbService->followUp->side_effects ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Catatan Bidan</label>
                        <p class="font-medium mt-1">{{ $kbService->followUp->notes ?: '-' }}</p>
                    </div>
                </div>

                <!-- Jadwal Kontrol Berikutnya dari Follow Up -->
                <div class="mt-6 bg-white bg-opacity-50 p-4 rounded-lg border border-green-100">
                    <h3 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Jadwal Kontrol Berikutnya
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Tanggal Kontrol</label>
                            <p class="font-medium mt-1">{{ $kbService->followUp->next_control_date ? \Carbon\Carbon::parse($kbService->followUp->next_control_date)->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Keterangan</label>
                            <p class="font-medium mt-1">{{ $kbService->followUp->next_control_notes ?: '-' }}</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Tampilan jika belum ada hasil follow up -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Jadwal Follow-up Saat Ini</label>
                        <p class="font-medium">
                            @if($kbService->follow_up_date)
                                {{ \Carbon\Carbon::parse($kbService->follow_up_date)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Tipe Follow-up</label>
                        <p class="font-medium">{{ $kbService->follow_up_type ?? '-' }}</p>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-500 italic">
                    Belum ada hasil follow-up yang dicatat secara rinci untuk layanan KB ini.
                </div>
            @endif
        </div>

        <!-- Catatan -->
        @if($kbService->notes)
            <div class="bg-yellow-50 p-6 rounded-lg mb-8 border border-yellow-200">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Catatan</h2>
                <p class="text-gray-700">{{ $kbService->notes }}</p>
            </div>
        @endif

        <!-- Petugas Info -->
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Informasi Petugas</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <label class="text-sm text-gray-600">Petugas (Bidan)</label>
                        <p class="font-medium">{{ $kbService->bidan->name }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="text-sm text-gray-600">Dibuat Tanggal</label>
                        <p class="font-medium">{{ $kbService->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Oleh</label>
                        <p class="font-medium">{{ $kbService->creator->name }}</p>
                    </div>
                </div>
                <div>
                    @if($kbService->is_verified)
                        <div class="mb-4">
                            <label class="text-sm text-gray-600">Diverifikasi Tanggal</label>
                            <p class="font-medium">{{ $kbService->verified_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Oleh</label>
                            <p class="font-medium">{{ $kbService->verifier->name ?? '-' }}</p>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 p-3 rounded">
                            <p class="font-medium">Menunggu verifikasi bidan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

