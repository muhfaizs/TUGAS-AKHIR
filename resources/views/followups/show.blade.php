@extends('layouts.dashboard')

@section('title', 'Detail Tindak Lanjut Akseptor')

@section('content')
<div class="min-h-screen bg-transparent">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-[#105448] to-[#1c7c6b] rounded-2xl p-8 mb-8 shadow-lg text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white opacity-5 rounded-full"></div>
        <div class="relative z-10 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Detail Tindak Lanjut</h1>
                <p class="text-teal-100 text-sm">Pemantauan dan follow-up akseptor KB</p>
            </div>
            <a href="{{ route('followups.index') }}" class="bg-white/20 hover:bg-white/30 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors border border-white/30 inline-flex items-center gap-2 no-underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Kolom Kiri: Informasi -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Info Akseptor -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-3 border-gray-50 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Informasi Akseptor
                </h3>
                <div class="space-y-4">
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Nama Akseptor</div>
                        <div class="font-semibold text-gray-900">{{ $service->acceptor->full_name }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 mb-1">NIK</div>
                        <div class="font-medium text-gray-700">{{ $service->acceptor->nik }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Nomor Telepon</div>
                        <div class="font-medium text-gray-700">{{ $service->acceptor->phone ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Alamat</div>
                        <div class="font-medium text-gray-700 text-sm">{{ $service->acceptor->address ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pelayanan Terakhir -->
            <div class="bg-gradient-to-br from-teal-50 to-blue-50 rounded-2xl p-6 shadow-sm border border-teal-100">
                <h3 class="text-lg font-bold text-teal-900 mb-4 border-b border-teal-200/50 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Pelayanan Terakhir
                </h3>
                <div class="space-y-4">
                    <div>
                        <div class="text-xs text-teal-700/70 mb-1">Metode KB</div>
                        <div class="inline-block px-3 py-1 bg-teal-600 text-white text-xs font-bold rounded-full">{{ $service->service_method }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-teal-700/70 mb-1">Tanggal Pelayanan</div>
                        <div class="font-semibold text-teal-900">{{ $service->created_at->format('d F Y') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-teal-700/70 mb-1">Lokasi</div>
                        <div class="font-medium text-teal-800 text-sm">{{ ucfirst($service->location ?? 'Puskesmas') }} ({{ $service->puskesmasData->name ?? '-' }})</div>
                    </div>
                    <div>
                        <div class="text-xs text-teal-700/70 mb-1">Jadwal Kontrol Saat Ini</div>
                        <div class="font-bold text-red-600">{{ $service->follow_up_date ? \Carbon\Carbon::parse($service->follow_up_date)->format('d F Y') : '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form Follow Up -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 bg-gray-50/50 p-6">
                    <h2 class="text-xl font-bold text-gray-900">Form Hasil Follow-Up</h2>
                    <p class="text-sm text-gray-500 mt-1">Catat hasil pantauan dan keluhan yang dialami akseptor.</p>
                </div>

                <form action="{{ route('followups.store', $service->id) }}" method="POST" class="p-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Follow-Up <span class="text-red-500">*</span></label>
                            <input type="date" name="follow_up_date" required value="{{ old('follow_up_date', $followUp->follow_up_date ?? now()->format('Y-m-d')) }}"
                                class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent outline-none transition-all">
                            @error('follow_up_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kehadiran <span class="text-red-500">*</span></label>
                            <select name="attendance_status" required class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent outline-none transition-all">
                                <option value="hadir" @selected(old('attendance_status', $followUp->attendance_status ?? '') == 'hadir')>Hadir</option>
                                <option value="tidak_hadir" @selected(old('attendance_status', $followUp->attendance_status ?? '') == 'tidak_hadir')>Tidak Hadir</option>
                            </select>
                            @error('attendance_status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kondisi Akseptor Saat Ini</label>
                            <input type="text" name="condition" placeholder="Contoh: Baik, Tekanan darah normal" value="{{ old('condition', $followUp->condition ?? '') }}"
                                class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Keluhan yang Dirasakan</label>
                            <textarea name="complaints" rows="3" placeholder="Kosongkan jika tidak ada keluhan"
                                class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent outline-none transition-all">{{ old('complaints', $followUp->complaints ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Efek Samping</label>
                            <textarea name="side_effects" rows="3" placeholder="Efek samping dari metode KB yang digunakan"
                                class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent outline-none transition-all">{{ old('side_effects', $followUp->side_effects ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Bidan</label>
                            <textarea name="notes" rows="3" placeholder="Catatan tambahan atau saran medis"
                                class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent outline-none transition-all">{{ old('notes', $followUp->notes ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-6 border border-slate-200 mb-8">
                        <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Jadwal Kontrol Berikutnya
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2">Tanggal Kontrol</label>
                                <input type="date" name="next_control_date" value="{{ old('next_control_date', $followUp->next_control_date ?? '') }}"
                                    class="w-full px-4 py-2 bg-white border-none rounded-lg focus:ring-2 focus:ring-slate-400 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2">Keterangan Kontrol</label>
                                <input type="text" name="next_control_notes" placeholder="Contoh: Lepas IUD, Suntik ulang" value="{{ old('next_control_notes', $followUp->next_control_notes ?? '') }}"
                                    class="w-full px-4 py-2 bg-white border-none rounded-lg focus:ring-2 focus:ring-slate-400 outline-none transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between pt-6 border-t border-gray-100">
                        <div class="flex items-center gap-3">
                            <label class="text-sm font-semibold text-gray-700">Tandai Follow-Up Selesai?</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="status" value="belum_selesai">
                                <input type="checkbox" name="status" value="selesai" class="sr-only peer" @checked(old('status', $followUp->status ?? 'selesai') == 'selesai')>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#117a65]"></div>
                            </label>
                        </div>

                        <div class="flex gap-3 mt-4 sm:mt-0">
                            <a href="{{ route('followups.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors no-underline">Batal</a>
                            <button type="submit" class="px-6 py-2.5 bg-[#117a65] text-white font-bold rounded-xl shadow-sm hover:bg-[#0f6b58] hover:-translate-y-0.5 transition-all">Simpan Hasil Follow-Up</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection

