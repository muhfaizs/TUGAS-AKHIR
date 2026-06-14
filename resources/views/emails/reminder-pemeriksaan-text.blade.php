Halo, {{ $ibuHamil->nama_lengkap }},

Ini adalah pengingat dari Puskesmas Bojongsoang bahwa Anda memiliki jadwal pemeriksaan kehamilan (ANC) berikutnya pada:

Tanggal: {{ \Carbon\Carbon::parse($tanggalKembali)->translatedFormat('l, d F Y') }}

@if($catatan)
Catatan Tambahan dari Bidan:
{{ $catatan }}
@endif

Mohon untuk datang tepat waktu. Pemeriksaan rutin sangat penting untuk memantau kesehatan Anda dan perkembangan janin.

Jika ada pertanyaan atau kendala, silakan hubungi Bidan yang menangani Anda.

Terima kasih,
Puskesmas Bojongsoang
Sistem Monitoring KIA (SatuKIA)
