@extends('layouts.app')

@section('title', 'Detail Data Pasien - ' . $kbAcceptor->full_name)

@section('content')
<div class="bg-white">
    <div class="max-w-6xl mx-auto px-6 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $kbAcceptor->full_name }}</h1>
                <p class="text-gray-600 mt-1">
                    <span class="badge px-3 py-1 rounded-full text-sm font-medium
                        @if($kbAcceptor->is_verified)
                            bg-green-100 text-green-800
                        @else
                            bg-yellow-100 text-yellow-800
                        @endif">
                        {{ $kbAcceptor->is_verified ? 'Terverifikasi' : 'Menunggu Verifikasi' }}
                    </span>
                </p>
            </div>
            <div class="flex flex-wrap gap-3 items-center">
                @if(auth()->check() && auth()->user()->role === 'kader' && $kbAcceptor->registered_by === auth()->id())
                    @if(!$kbAcceptor->is_verified)
                        @if(!$kbAcceptor->verification_requested_at)
                            <form action="{{ route('kb-acceptors.submit', $kbAcceptor->id) }}" method="POST" class="inline-block m-0">
                                @csrf
                                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2 rounded-lg text-sm font-medium border-0 cursor-pointer inline-flex items-center justify-center transition-colors">
                                    Kirim ke Bidan
                                </button>
                            </form>
                        @else
                            <span class="inline-flex items-center justify-center rounded-lg bg-yellow-100 px-5 py-2 text-sm font-medium text-yellow-800">
                                Sudah dikirim ke Bidan
                            </span>
                        @endif
                    @endif
                @elseif(auth()->check() && auth()->user()->role === 'bidan')
                    @if(!$kbAcceptor->is_verified && $kbAcceptor->verification_requested_at)
                        <form action="{{ route('kb-acceptors.verify', $kbAcceptor->id) }}" method="POST" class="inline-block m-0">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-sm font-medium border-0 cursor-pointer inline-flex items-center justify-center transition-colors">
                                Verifikasi
                            </button>
                        </form>
                    @endif
                @endif
                <a href="{{ route('kb-acceptors.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg text-sm font-medium no-underline inline-flex items-center justify-center transition-colors">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Main Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Left Column -->
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-4">Data Identitas</h2>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-600">NIK</label>
                            <p class="font-medium">{{ $kbAcceptor->nik }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Nomor KK</label>
                            <p class="font-medium">{{ $kbAcceptor->kk_number ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Tanggal Lahir</label>
                            <p class="font-medium">{{ $kbAcceptor->date_of_birth ? \Carbon\Carbon::parse($kbAcceptor->date_of_birth)->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Usia</label>
                            <p class="font-medium">{{ $kbAcceptor->age }} tahun</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Jenis Kelamin</label>
                            <p class="font-medium">{{ $kbAcceptor->gender == 'M' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Status Perkawinan</label>
                            <p class="font-medium">{{ ucfirst($kbAcceptor->marital_status) }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Agama</label>
                            <p class="font-medium">{{ $kbAcceptor->religion }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Pendidikan</label>
                            <p class="font-medium">{{ $kbAcceptor->education ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-4">Kontak & Pekerjaan</h2>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm text-gray-600">Nomor Telepon</label>
                            <p class="font-medium">{{ $kbAcceptor->phone }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Email</label>
                            <p class="font-medium">{{ $kbAcceptor->email ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Pekerjaan</label>
                            <p class="font-medium">{{ $kbAcceptor->occupation ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Puskesmas</label>
                            <p class="font-medium">{{ $kbAcceptor->puskesmas->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Golongan Darah</label>
                            <p class="font-medium">{{ $kbAcceptor->blood_type ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address Info -->
        <div class="bg-gray-50 p-6 rounded-lg mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Alamat</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Alamat Lengkap</label>
                    <p class="font-medium">{{ $kbAcceptor->address }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Desa/Kelurahan</label>
                    <p class="font-medium">{{ $kbAcceptor->village }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Kecamatan</label>
                    <p class="font-medium">{{ $kbAcceptor->district }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Kabupaten/Kota</label>
                    <p class="font-medium">{{ $kbAcceptor->sub_district }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Kode Pos</label>
                    <p class="font-medium">{{ $kbAcceptor->postal_code }}</p>
                </div>
            </div>
        </div>

        <!-- Health Info -->
        <div class="bg-gray-50 p-6 rounded-lg mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Kesehatan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Riwayat Penyakit</label>
                    <p class="font-medium">{{ $kbAcceptor->health_history ?: '-' }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Alergi</label>
                    <p class="font-medium">{{ $kbAcceptor->allergies ?: '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Metadata -->
        <div class="bg-gray-50 p-4 rounded-lg text-xs text-gray-600">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="font-medium">Terdaftar Oleh:</label>
                    <p>{{ $kbAcceptor->registeredBy->name }}</p>
                </div>
                <div>
                    <label class="font-medium">Tanggal Daftar:</label>
                    <p>{{ $kbAcceptor->registered_at->format('d/m/Y H:i') }}</p>
                </div>
                @if($kbAcceptor->is_verified)
                    <div>
                        <label class="font-medium">Diverifikasi Oleh:</label>
                        <p>{{ $kbAcceptor->verifiedBy->name ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="font-medium">Tanggal Verifikasi:</label>
                        <p>{{ $kbAcceptor->verified_at ? $kbAcceptor->verified_at->format('d/m/Y H:i') : '-' }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
