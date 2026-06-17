@extends('layouts.app')

@section('title', 'Detail Layanan KB')

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
                <a href="{{ route('kb-acceptors.show', $kbService->acceptor->id) }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white text-sm px-4 py-2 rounded no-underline flex items-center justify-center border-none h-10 font-medium">
                    Kembali ke Akseptor
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

        <!-- Follow-up -->
        <div class="bg-green-50 p-6 rounded-lg mb-8 border border-green-200">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Jadwal Follow-up</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Tanggal Follow-up</label>
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
