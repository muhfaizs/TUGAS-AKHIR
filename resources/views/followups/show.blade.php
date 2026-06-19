@extends('layouts.dashboard')

@section('title', 'Detail Tindak Lanjut Akseptor')
@section('page_title', 'Tindak Lanjut')

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
            <a href="{{ route('kb-services.jadwal-kontrol') }}" class="bg-white/20 hover:bg-white/30 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors border border-white/30 inline-flex items-center gap-2 no-underline">
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
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden" 
                 x-data="{
                     attendance: '{{ old('attendance_status', $followUp->attendance_status ?? 'hadir') }}',
                     complaints: `{{ old('complaints', $followUp->complaints ?? '') }}`,
                     sideEffects: {{ json_encode(old('side_effects', $followUp->side_effects ?? '') ? array_map('trim', explode(',', old('side_effects', $followUp->side_effects ?? ''))) : []) }},
                     sideEffectsLain: '',
                     dangerSigns: {{ json_encode(old('danger_signs', $followUp->danger_signs ?? '') ? array_map('trim', explode(',', old('danger_signs', $followUp->danger_signs ?? ''))) : []) }},
                     bidanActions: {{ json_encode(old('bidan_actions', $followUp->bidan_actions ?? '') ? array_map('trim', explode(',', old('bidan_actions', $followUp->bidan_actions ?? ''))) : []) }},
                     kbDecision: '{{ old('kb_method_decision', $followUp->kb_method_decision ?? 'Dilanjutkan') }}',
                     status: '{{ old('status', $followUp->status ?? 'Belum Ditindaklanjuti') }}',
                     
                     init() {
                         this.$watch('dangerSigns', () => this.autoUpdate());
                         this.$watch('sideEffects', () => this.autoUpdate());
                         this.$watch('complaints', () => this.autoUpdate());
                         this.$watch('attendance', () => this.autoUpdate());
                         
                         // Inisialisasi awal
                         this.autoUpdate();
                     },
                     
                     get riskLevel() {
                         if (this.dangerSigns.length > 0 && !this.dangerSigns.includes('Tidak ada')) return 'Risiko Tinggi';
                         if (this.complaints && this.complaints.length > 5) return 'Risiko Tinggi';
                         if (this.sideEffects.length > 0 && !this.sideEffects.includes('Tidak ada')) return 'Risiko Sedang';
                         return 'Risiko Rendah';
                     },
                     
                     autoUpdate() {
                         if (this.riskLevel === 'Risiko Tinggi') {
                             this.status = 'Perlu Rujukan';
                             if(!this.bidanActions.includes('Rujukan ke rumah sakit') && !this.bidanActions.includes('Rujukan ke dokter')) {
                                 // Saran rujukan
                             }
                         } else if (this.attendance === 'tidak_hadir') {
                             // Jika tidak hadir tapi belum selesai
                         }
                     },
                     
                     get sideEffectsResult() {
                         let res = this.sideEffects.filter(s => s !== 'Lainnya').join(', ');
                         if(this.sideEffects.includes('Lainnya') && this.sideEffectsLain) {
                             res += (res ? ', ' : '') + this.sideEffectsLain;
                         }
                         return res;
                     }
                 }">
                
                <div class="border-b border-gray-100 bg-gray-50/50 p-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Form Hasil Follow-Up</h2>
                        <p class="text-sm text-gray-500 mt-1">Catat hasil pantauan dan keluhan yang dialami akseptor.</p>
                    </div>
                    <!-- Badge Risiko -->
                    <div class="px-4 py-2 rounded-xl font-bold border"
                         :class="{
                             'bg-red-50 text-red-700 border-red-200': riskLevel === 'Risiko Tinggi',
                             'bg-yellow-50 text-yellow-700 border-yellow-200': riskLevel === 'Risiko Sedang',
                             'bg-green-50 text-green-700 border-green-200': riskLevel === 'Risiko Rendah'
                         }">
                        <span class="w-2 h-2 rounded-full inline-block mr-1" :class="{'bg-red-500': riskLevel === 'Risiko Tinggi', 'bg-yellow-500': riskLevel === 'Risiko Sedang', 'bg-green-500': riskLevel === 'Risiko Rendah'}"></span>
                        <span x-text="riskLevel"></span>
                    </div>
                </div>
                
                <div x-show="riskLevel === 'Risiko Tinggi'" x-transition class="bg-red-50 p-4 border-b border-red-200 flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <h4 class="text-sm font-bold text-red-800">Peringatan: Akseptor memerlukan penanganan lebih lanjut.</h4>
                        <p class="text-xs text-red-700 mt-1">Sistem menyarankan rujukan ke fasilitas lanjutan atau percepatan jadwal kontrol.</p>
                    </div>
                </div>

                <div x-show="attendance === 'tidak_hadir'" x-transition class="bg-yellow-50 p-4 border-b border-yellow-200 flex items-start gap-3">
                    <svg class="w-6 h-6 text-yellow-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <h4 class="text-sm font-bold text-yellow-800">Perhatian: Akseptor Tidak Hadir</h4>
                        <p class="text-xs text-yellow-700 mt-1">Disarankan untuk menjadwalkan ulang kontrol atau melakukan pemantauan melalui telepon.</p>
                    </div>
                </div>

                <form action="{{ route('followups.store', $service->id) }}" method="POST" class="p-6">
                    @csrf
                    
                    <input type="hidden" name="risk_level" :value="riskLevel">
                    <input type="hidden" name="side_effects" :value="sideEffectsResult">
                    <input type="hidden" name="danger_signs" :value="dangerSigns.join(', ')">
                    <input type="hidden" name="bidan_actions" :value="bidanActions.join(', ')">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">1. Tanggal Follow-Up <span class="text-red-500">*</span></label>
                            <input type="date" name="follow_up_date" required value="{{ old('follow_up_date', $followUp->follow_up_date ?? now()->format('Y-m-d')) }}"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent outline-none transition-all">
                            @error('follow_up_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">2. Kehadiran <span class="text-red-500">*</span></label>
                            <select name="attendance_status" x-model="attendance" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent outline-none transition-all">
                                <option value="hadir">Hadir</option>
                                <option value="tidak_hadir">Tidak Hadir</option>
                            </select>
                            
                            <div x-show="attendance === 'tidak_hadir'" x-transition class="mt-3">
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Alasan Tidak Hadir</label>
                                <select name="absence_reason" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#117a65] outline-none text-sm">
                                    <option value="">Pilih Alasan...</option>
                                    <option value="Lupa jadwal" @selected(old('absence_reason', $followUp->absence_reason ?? '') == 'Lupa jadwal')>Lupa jadwal</option>
                                    <option value="Sedang sakit" @selected(old('absence_reason', $followUp->absence_reason ?? '') == 'Sedang sakit')>Sedang sakit</option>
                                    <option value="Tidak ada transportasi" @selected(old('absence_reason', $followUp->absence_reason ?? '') == 'Tidak ada transportasi')>Tidak ada transportasi</option>
                                    <option value="Pindah domisili" @selected(old('absence_reason', $followUp->absence_reason ?? '') == 'Pindah domisili')>Pindah domisili</option>
                                    <option value="Menolak kontrol" @selected(old('absence_reason', $followUp->absence_reason ?? '') == 'Menolak kontrol')>Menolak kontrol</option>
                                    <option value="Lainnya" @selected(old('absence_reason', $followUp->absence_reason ?? '') == 'Lainnya')>Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8 mb-8 border-t border-gray-100 pt-6">
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">3. Kondisi Akseptor Saat Ini</label>
                            <textarea name="condition" rows="2" placeholder="Contoh: Kondisi baik, Tekanan darah normal, Tidak ada keluhan"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent outline-none transition-all">{{ old('condition', $followUp->condition ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">4. Keluhan yang Dirasakan</label>
                            <textarea name="complaints" x-model="complaints" rows="2" placeholder="Contoh: Nyeri perut, Sakit kepala, Mual. Kosongkan jika tidak ada."
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent outline-none transition-all"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- 5. Efek Samping -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">5. Efek Samping</label>
                                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 max-h-48 overflow-y-auto space-y-2">
                                    @php
                                        $effects = ['Tidak ada', 'Perdarahan ringan', 'Perdarahan tidak teratur', 'Nyeri perut', 'Pusing', 'Mual', 'Berat badan meningkat', 'Berat badan menurun', 'Nyeri payudara', 'Gangguan menstruasi', 'Jerawat', 'Perubahan suasana hati', 'Rambut rontok', 'Nyeri panggul', 'Lainnya'];
                                    @endphp
                                    @foreach($effects as $effect)
                                    <label class="flex items-start gap-2 cursor-pointer">
                                        <input type="checkbox" value="{{ $effect }}" x-model="sideEffects" class="mt-1 w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="text-sm text-gray-700">{{ $effect }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                <div x-show="sideEffects.includes('Lainnya')" class="mt-2">
                                    <input type="text" x-model="sideEffectsLain" placeholder="Efek samping lainnya..." class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#117a65] outline-none">
                                </div>
                            </div>

                            <!-- 7. Tanda Bahaya -->
                            <div>
                                <label class="block text-sm font-semibold text-red-600 mb-2">7. Tanda Bahaya (Terkait Risiko)</label>
                                <div class="bg-red-50/50 border border-red-100 rounded-xl p-4 max-h-48 overflow-y-auto space-y-2">
                                    @php
                                        $dangers = ['Perdarahan berat', 'Nyeri panggul hebat', 'Demam tinggi', 'Tekanan darah tinggi', 'Sesak napas', 'Pusing berat', 'Penurunan kesadaran', 'Tidak ada'];
                                    @endphp
                                    @foreach($dangers as $danger)
                                    <label class="flex items-start gap-2 cursor-pointer">
                                        <input type="checkbox" value="{{ $danger }}" x-model="dangerSigns" class="mt-1 w-4 h-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                        <span class="text-sm text-gray-800">{{ $danger }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="space-y-6 mb-8 border-t border-gray-100 pt-6">
                        <!-- 8. Tindak Lanjut Bidan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">8. Tindak Lanjut Bidan</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @php
                                    $actions = ['Monitoring rutin', 'Pemeriksaan ulang', 'Konseling KB', 'Penyesuaian metode KB', 'Jadwal kontrol dipercepat', 'Observasi khusus', 'Rujukan ke dokter', 'Rujukan ke rumah sakit'];
                                @endphp
                                @foreach($actions as $action)
                                <label class="flex items-center gap-2 cursor-pointer bg-gray-50 border border-gray-200 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                                    <input type="checkbox" value="{{ $action }}" x-model="bidanActions" class="w-4 h-4 text-[#117a65] focus:ring-[#117a65] border-gray-300 rounded">
                                    <span class="text-xs text-gray-700 font-medium">{{ $action }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- 9. Keputusan Metode KB -->
                        <div class="bg-blue-50/30 border border-blue-100 rounded-xl p-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">9. Keputusan Penggunaan Metode KB</label>
                            <div class="flex flex-wrap gap-4 mb-4">
                                @foreach(['Dilanjutkan', 'Diganti', 'Dihentikan sementara', 'Dihentikan permanen'] as $dec)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="kb_method_decision" value="{{ $dec }}" x-model="kbDecision" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="text-sm text-gray-800">{{ $dec }}</span>
                                </label>
                                @endforeach
                            </div>
                            
                            <div x-show="kbDecision === 'Diganti'" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 pt-4 border-t border-blue-100">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Metode KB Baru</label>
                                    <select name="new_kb_method" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                                        <option value="">Pilih Metode...</option>
                                        <option value="Pil KB" @selected(old('new_kb_method', $followUp->new_kb_method ?? '') == 'Pil KB')>Pil KB</option>
                                        <option value="Suntik 1 bulan" @selected(old('new_kb_method', $followUp->new_kb_method ?? '') == 'Suntik 1 bulan')>Suntik 1 bulan</option>
                                        <option value="Suntik 3 bulan" @selected(old('new_kb_method', $followUp->new_kb_method ?? '') == 'Suntik 3 bulan')>Suntik 3 bulan</option>
                                        <option value="Implant" @selected(old('new_kb_method', $followUp->new_kb_method ?? '') == 'Implant')>Implant</option>
                                        <option value="IUD" @selected(old('new_kb_method', $followUp->new_kb_method ?? '') == 'IUD')>IUD</option>
                                        <option value="Kondom" @selected(old('new_kb_method', $followUp->new_kb_method ?? '') == 'Kondom')>Kondom</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Alasan Perubahan</label>
                                    <select name="method_change_reason" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                                        <option value="">Pilih Alasan...</option>
                                        <option value="Efek samping" @selected(old('method_change_reason', $followUp->method_change_reason ?? '') == 'Efek samping')>Efek samping</option>
                                        <option value="Tidak cocok" @selected(old('method_change_reason', $followUp->method_change_reason ?? '') == 'Tidak cocok')>Tidak cocok</option>
                                        <option value="Risiko tinggi" @selected(old('method_change_reason', $followUp->method_change_reason ?? '') == 'Risiko tinggi')>Risiko tinggi</option>
                                        <option value="Keinginan pasien" @selected(old('method_change_reason', $followUp->method_change_reason ?? '') == 'Keinginan pasien')>Keinginan pasien</option>
                                        <option value="Anjuran bidan" @selected(old('method_change_reason', $followUp->method_change_reason ?? '') == 'Anjuran bidan')>Anjuran bidan</option>
                                        <option value="Lainnya" @selected(old('method_change_reason', $followUp->method_change_reason ?? '') == 'Lainnya')>Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- 10. Jadwal Kontrol Berikutnya -->
                    <div class="bg-slate-50 rounded-xl p-6 border border-slate-200 mb-8">
                        <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            10. Jadwal Kontrol Berikutnya
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2">Tanggal Kontrol</label>
                                <input type="date" name="next_control_date" value="{{ old('next_control_date', $followUp->next_control_date ?? '') }}"
                                    class="w-full px-4 py-2 bg-white border-gray-300 border rounded-lg focus:ring-2 focus:ring-slate-400 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2">Keterangan Kontrol</label>
                                <input type="text" name="next_control_notes" placeholder="Contoh: Lepas IUD, Suntik ulang, Evaluasi efek samping" value="{{ old('next_control_notes', $followUp->next_control_notes ?? '') }}"
                                    class="w-full px-4 py-2 bg-white border-gray-300 border rounded-lg focus:ring-2 focus:ring-slate-400 outline-none transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6 mb-8 border-t border-gray-100 pt-6">
                        <!-- 11. Status Follow Up -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">11. Status Follow-Up</label>
                            <select name="status" x-model="status" required class="w-full md:w-1/2 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent outline-none transition-all">
                                <option value="Belum Ditindaklanjuti">Belum Ditindaklanjuti</option>
                                <option value="Dalam Pemantauan">Dalam Pemantauan</option>
                                <option value="Perlu Kontrol Ulang">Perlu Kontrol Ulang</option>
                                <option value="Perlu Rujukan">Perlu Rujukan</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        
                        <!-- 12. Catatan Bidan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">12. Catatan Bidan</label>
                            <textarea name="notes" rows="3" placeholder="Catatan tambahan, saran medis, atau ringkasan rujukan..."
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#117a65] focus:border-transparent outline-none transition-all">{{ old('notes', $followUp->notes ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-end pt-6 border-t border-gray-100 gap-3">
                        <a href="{{ route('kb-services.jadwal-kontrol') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors no-underline">Batal</a>
                        <button type="submit" class="px-6 py-2.5 bg-[#117a65] text-white font-bold rounded-xl shadow-sm hover:bg-[#0f6b58] hover:-translate-y-0.5 transition-all">Simpan Hasil Follow-Up</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
