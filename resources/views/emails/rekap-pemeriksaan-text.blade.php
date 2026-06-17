Halo, {{ $ibuHamil->nama_lengkap }},

Ini adalah pesan otomatis dari Puskesmas Bojongsoang.

Berikut kami lampirkan dokumen PDF yang berisi Rekapitulasi Pemeriksaan Kehamilan (ANC) Anda yang terbaru.
Dokumen ini berisi grafik perkembangan janin dan detail lengkap dari seluruh riwayat pemeriksaan Anda.

@if($tanggalBerikutnya)
--- PENGINGAT JADWAL PEMERIKSAAN ---
Berdasarkan usia kehamilan Anda, jadwal pemeriksaan ANC Anda berikutnya adalah pada:
{{ $tanggalBerikutnya }}
------------------------------------
@endif

Mohon simpan dokumen ini dengan baik sebagai arsip medis pribadi Anda.

Jika ada pertanyaan atau keluhan terkait kehamilan Anda, silakan hubungi Bidan yang menangani Anda.

Terima kasih,
Puskesmas Bojongsoang
Sistem Monitoring KIA (SatuKIA)
