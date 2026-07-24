# 📖 README SKRIPSI — Dokumentasi Lengkap Project SatuKIA

> **SatuKIA** adalah sistem informasi kesehatan ibu dan anak berbasis web yang dibangun menggunakan framework Laravel.
> Sistem ini digunakan untuk memantau tumbuh kembang anak (balita), mencatat imunisasi, tindakan medis, dan menyediakan pelaporan bagi tenaga kesehatan.

---

## 📌 Daftar Isi

1. [Technology Stack (Tumpukan Teknologi)](#-1-technology-stack-tumpukan-teknologi)
2. [Daftar Fitur & Penjelasan](#-2-daftar-fitur--penjelasan)
3. [Penjelasan Lengkap Komponen Sistem](#-3-penjelasan-lengkap-komponen-sistem)
   - [Models (Model)](#-31-models-model)
   - [Controllers (Pengontrol)](#-32-controllers-pengontrol)
   - [Views (Tampilan)](#-33-views-tampilan)
   - [Migrations (Migrasi Database)](#-34-migrations-migrasi-database)
   - [Routes / web.php](#-35-routes--webphp)
   - [Middleware](#-36-middleware)
   - [Seeders (Data Awal)](#-37-seeders-data-awal)
   - [Mail (Email)](#-38-mail-email)
   - [File .env (Konfigurasi Lingkungan)](#-39-file-env-konfigurasi-lingkungan)
   - [bootstrap/app.php](#-310-bootstrapappphp)
4. [Sistem Role & Cara Mengetahui Siapa yang Login](#-4-sistem-role--cara-mengetahui-siapa-yang-login)
5. [Bagaimana Akun SuperAdmin Tercipta?](#-5-bagaimana-akun-superadmin-tercipta)
6. [Fitur IMT Otomatis — Cara Perhitungan & Lokasi Kode](#-6-fitur-imt-otomatis--cara-perhitungan--lokasi-kode)
7. [Fitur Serupa: Status Gizi & Status Stunting](#-7-fitur-serupa-status-gizi--status-stunting)
8. [Alur Registrasi & Login](#-8-alur-registrasi--login)
9. [Sistem Notifikasi](#-9-sistem-notifikasi)
10. [Sistem Laporan & PDF](#-10-sistem-laporan--pdf)
11. [Validasi Usia Imunisasi](#-11-validasi-usia-imunisasi)
12. [Struktur Wilayah (Kabupaten → Puskesmas → Posyandu)](#-12-struktur-wilayah-kabupaten--puskesmas--posyandu)

---

## 🧱 1. Technology Stack (Tumpukan Teknologi)

Bayangkan membangun rumah — kamu butuh bahan-bahan tertentu. Nah, project ini juga "dibangun" pakai bahan-bahan (teknologi) berikut:

### Backend (Otak / Dapur di belakang layar)

| Teknologi | Versi | Fungsi (Bahasa Bayi) |
|---|---|---|
| **PHP** | 8.3 | Bahasa pemrograman utama. Ini seperti "bahasa" yang dipakai untuk ngomong sama server. |
| **Laravel** | 13 | Framework (kerangka kerja) PHP. Bayangkan ini seperti "cetakan kue" — kamu tinggal isi adonannya, hasilnya rapi dan terstruktur. |
| **MySQL** | - | Database (gudang penyimpanan data). Semua data anak, user, pengukuran, dll disimpan di sini. |
| **Composer** | - | Manajer paket PHP. Ini tukang belanja yang mengunduh semua library/paket yang dibutuhkan. |

### Frontend (Wajah / Tampilan yang dilihat pengguna)

| Teknologi | Versi | Fungsi (Bahasa Bayi) |
|---|---|---|
| **Blade** | (bawaan Laravel) | Template engine. Ini cara Laravel menampilkan halaman HTML yang dinamis. Filenya berakhiran `.blade.php`. |
| **TailwindCSS** | 4 | Framework CSS. Alat untuk mempercantik tampilan — memberi warna, jarak, ukuran, dll. |
| **Vite** | 8 | Build tool. Ini "tukang bangunan" yang menggabungkan semua file CSS dan JS menjadi satu paket yang siap dipakai. |
| **JavaScript** | - | Bahasa pemrograman untuk membuat halaman web interaktif (misal: klik tombol, muncul form). |

### Paket/Library Tambahan

| Paket | Fungsi (Bahasa Bayi) |
|---|---|
| **barryvdh/laravel-dompdf** | Untuk membuat file PDF. Misalnya surat rekam medis anak yang bisa diunduh. |
| **laravel/tinker** | Alat debugging — seperti "ruang percobaan" untuk menjalankan kode PHP langsung di terminal. |
| **pestphp/pest** | Framework untuk testing (ujian kode). Memastikan kode bekerja dengan benar. |
| **laravel/pint** | Alat untuk merapikan format kode PHP supaya seragam dan rapi. |
| **laravel-vite-plugin** | Jembatan antara Laravel dan Vite supaya bisa bekerja bareng. |

### File Konfigurasi Penting

| File | Fungsi |
|---|---|
| `composer.json` | Daftar belanjaan paket PHP — berisi semua library yang dibutuhkan project. |
| `package.json` | Daftar belanjaan paket JavaScript/CSS — berisi TailwindCSS, Vite, dll. |
| `vite.config.js` | Pengaturan Vite — menentukan file CSS/JS mana yang harus di-compile. |
| `.env` | Pengaturan rahasia — password database, konfigurasi email, dll. |

---

## ✨ 2. Daftar Fitur & Penjelasan

### 🔐 A. Autentikasi (Login & Registrasi)

| Fitur | Penjelasan |
|---|---|
| **Login** | Semua user masuk lewat satu halaman login yang sama (`/login`). Sistem otomatis mengarahkan ke dashboard yang sesuai berdasarkan **role** (jabatan) mereka. |
| **Registrasi Mandiri** | Hanya **Orang Tua** yang bisa daftar sendiri lewat form registrasi. Role lain (Bidan, Kader, Dinkes) dibuat oleh Super Admin atau Bidan. |
| **Pengecekan Akun Aktif** | Kalau akun di-nonaktifkan (`is_active = false`), user tetap tidak bisa login walaupun password-nya benar. |
| **Session Timeout** | Sesi login otomatis habis dalam 10 menit (diatur di `.env`). |

### 👶 B. Manajemen Data Anak

| Fitur | Penjelasan |
|---|---|
| **CRUD Anak** | Bisa **Tambah**, **Lihat**, **Edit**, dan **Hapus** data anak. |
| **Data Lengkap** | Menyimpan NIK, nama, tempat/tanggal lahir, jenis kelamin, golongan darah, berat/panjang/lingkar kepala lahir, nama ayah/ibu, riwayat alergi, nomor BPJS, kontak darurat, alamat. |
| **Timeline Rekam Medis** | Halaman detail anak menampilkan semua riwayat pengukuran, tindakan medis, dan imunisasi dalam satu timeline kronologis. |
| **Filter & Pencarian** | Admin/Bidan bisa mencari anak berdasarkan nama/NIK dan memfilter berdasarkan status risiko. |
| **Akses Terbatas Orang Tua** | Orang Tua hanya bisa melihat dan mengelola data anak miliknya sendiri. |

### 📏 C. Pengukuran (oleh Kader)

| Fitur | Penjelasan |
|---|---|
| **Input Pengukuran** | Kader mencatat berat badan (kg), tinggi badan (cm), lingkar kepala (cm). |
| **IMT Otomatis** | Sistem **otomatis menghitung IMT** (Indeks Massa Tubuh) dari berat dan tinggi badan. Tidak perlu hitung manual! |
| **Flag Risiko Otomatis** | Berdasarkan hasil IMT, sistem otomatis menandai apakah anak **berisiko** (merah/kuning) atau **normal** (hijau). |
| **Status Gizi Otomatis** | Dari nilai IMT, sistem menentukan: Gizi Buruk, Gizi Kurang, Gizi Baik, Risiko Lebih, atau Gizi Lebih. |
| **Status Stunting Otomatis** | Dari nilai IMT, sistem menentukan: Stunting, Berisiko Stunting, atau Normal. |

### 💉 D. Imunisasi (oleh Bidan)

| Fitur | Penjelasan |
|---|---|
| **CRUD Imunisasi** | Bidan bisa menambah, mengedit, dan menghapus catatan imunisasi. |
| **Data Dicatat** | Nama vaksin, batch vaksin, lokasi suntikan, suhu tubuh, tanggal, catatan, lokasi Puskesmas/Posyandu. |
| **Validasi Usia Otomatis** | Sistem mengecek apakah usia anak sudah cukup untuk menerima vaksin tersebut. Kalau belum cukup umur, sistem menolak dan memberi peringatan. |
| **Notifikasi Otomatis** | Setelah imunisasi dicatat, notifikasi otomatis dikirim ke Orang Tua dan Kader terkait. |
| **Email + PDF** | Kalau Orang Tua punya email, sistem mengirim email dengan lampiran PDF hasil imunisasi. |

### 🩺 E. Tindakan Medis (oleh Bidan)

| Fitur | Penjelasan |
|---|---|
| **CRUD Tindakan Medis** | Bidan bisa menambah, mengedit, dan menghapus catatan tindakan medis. |
| **Data Dicatat** | Tanggal pemeriksaan, suhu tubuh, catatan pemeriksaan, diagnosa, resep obat, lokasi Puskesmas/Posyandu. |
| **Notifikasi Otomatis** | Setelah tindakan dicatat, notifikasi dikirim ke Orang Tua (in-app + WA link + email) dan Kader di posyandu terkait. |

### 🔔 F. Sistem Notifikasi

| Fitur | Penjelasan |
|---|---|
| **Notifikasi In-App** | Notifikasi muncul di dalam aplikasi (bisa ditandai "sudah dibaca"). |
| **WhatsApp Link** | Sistem membuat link WhatsApp yang sudah terisi pesan otomatis. Bidan tinggal klik untuk mengirim via WA. |
| **Email** | Sistem bisa mengirim email berisi informasi medis + lampiran PDF kepada Orang Tua. |
| **Pengingat Imunisasi** | Di dashboard Orang Tua, muncul pengingat vaksin yang belum dilakukan. Bisa di-dismiss (ditandai selesai). |

### 📊 G. Laporan

| Fitur | Penjelasan |
|---|---|
| **Laporan Terpadu** | Menggabungkan data pengukuran, tindakan medis, dan imunisasi dalam satu tabel laporan. |
| **Filter** | Bisa difilter berdasarkan Puskesmas, tanggal awal, tanggal akhir. |
| **Print** | Halaman print khusus yang bisa langsung dicetak dari browser (Ctrl+P). |
| **Export Excel** | Data bisa diunduh dalam format Excel (.xls). |
| **Submit ke Dinkes** | Bidan bisa memilih laporan tertentu lalu mengirim (submit) ke Dinas Kesehatan. Dinkes menerima notifikasi. |

### 📅 H. Jadwal Posyandu (oleh Kader)

| Fitur | Penjelasan |
|---|---|
| **CRUD Jadwal** | Kader bisa membuat, mengedit, dan menghapus jadwal posyandu. |
| **Data Dicatat** | Tanggal, waktu mulai, waktu selesai, lokasi, keterangan. |
| **Tampil di Dashboard** | Jadwal terdekat otomatis muncul di dashboard Kader dan Orang Tua. |

### 👤 I. Manajemen User

| Fitur | Penjelasan |
|---|---|
| **CRUD User (Super Admin)** | Super Admin bisa menambah, mengedit, dan menghapus semua jenis user. |
| **Kader Management (Bidan)** | Bidan bisa mengelola akun Kader (tambah, edit, hapus) — tapi hanya Kader, bukan role lain. |
| **Proteksi Hapus Diri Sendiri** | User tidak bisa menghapus akunnya sendiri (mencegah error). |

### 📥 J. Export PDF

| Fitur | Penjelasan |
|---|---|
| **Rekam Medis Anak (PDF)** | Semua riwayat tindakan medis & imunisasi anak bisa diunduh dalam satu file PDF. |
| **Tindakan Medis Satuan (PDF)** | Satu catatan tindakan medis bisa diunduh sebagai PDF terpisah. |
| **Imunisasi Satuan (PDF)** | Satu catatan imunisasi bisa diunduh sebagai PDF terpisah. |

### 🏥 K. Dashboard per Role

| Role | Dashboard Menampilkan |
|---|---|
| **Super Admin** | Halaman admin sederhana. |
| **Kader** | Total anak, anak berisiko, jadwal posyandu terdekat, tabel pasien prioritas (anak berisiko). |
| **Bidan** | Total anak, total pengukuran, anak berisiko, total bidan, tabel pasien prioritas. |
| **Orang Tua** | Daftar anak, grafik pertumbuhan (pengukuran), riwayat tindakan & imunisasi, pengingat vaksin, jadwal posyandu terdekat. |
| **Dinkes** | Total posyandu aktif, total balita, balita berisiko, persentase cakupan imunisasi, chart distribusi status gizi, daftar laporan dari Bidan. |

### 👤 L. Profil

| Fitur | Penjelasan |
|---|---|
| **Edit Profil** | Setiap role bisa mengedit profilnya sendiri (nama, kontak, foto, alamat, dll). |
| **Foto Profil** | User bisa mengunggah foto profil. |

---

## 🧩 3. Penjelasan Lengkap Komponen Sistem

### 📦 3.1 Models (Model)

> **Model** itu ibarat "peta" yang menjelaskan bentuk data di database. Setiap model merepresentasikan satu tabel di database.

#### `User.php` → Tabel: `tb_user`

**Bahasa bayi:** Ini adalah data siapa saja yang bisa login ke sistem.

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id_user` | Primary Key | ID unik setiap user. |
| `username` | String (unik) | Nama pengguna untuk login. |
| `password` | String (hashed) | Kata sandi (disimpan dalam bentuk terenkripsi, bukan teks biasa). |
| `nama_lengkap` | String | Nama lengkap pengguna. |
| `nomor_kontak` | String (nullable) | Nomor HP. |
| `role` | String | Jabatan: `super admin`, `bidan`, `kader`, `orang tua`, `dinkes`. |
| `nip_bidan` | String (nullable) | Nomor Induk Pegawai khusus Bidan (18 digit). |
| `id_posyandu_kader` | Integer (nullable) | ID posyandu tempat Kader bertugas. |
| `nik_ortu` | String (nullable) | NIK khusus Orang Tua (16 digit). |
| `kode_instansi_dinkes` | String (nullable) | Kode instansi khusus Dinkes. |
| `hak_akses_master` | JSON (nullable) | Hak akses khusus (contoh: `{"full_access": true}` untuk Super Admin). |
| `log_aktivitas` | JSON (nullable) | Catatan aktivitas user. |
| `is_active` | Boolean | Apakah akun aktif? Kalau `false`, tidak bisa login. |
| `wilayah_kerja` | String (nullable) | Wilayah kerja. |
| `email` | String (nullable) | Email (untuk menerima notifikasi email). |
| `foto_profil` | String (nullable) | Path file foto profil. |
| `alamat_domisili` | String (nullable) | Alamat tempat tinggal. |
| `puskesmas_id` | FK (nullable) | Puskesmas tempat user bertugas (Bidan/Admin). |
| `posyandu_id` | FK (nullable) | Posyandu tempat user bertugas (Kader). |
| `kabupaten_id` | FK (nullable) | Kabupaten user (untuk Dinkes). |

**Relasi (hubungan antar tabel):**
- `User` → punya banyak `Anak` (jika role = orang tua)
- `User` → punya banyak `TindakanMedis` (jika role = bidan)
- `User` → punya banyak `Imunisasi` (jika role = bidan)
- `User` → milik satu `Puskesmas`
- `User` → milik satu `Posyandu`
- `User` → milik satu `Kabupaten`

**Helper methods (fungsi pembantu):**
- `isSuperAdmin()` → cek apakah user role-nya "super admin"
- `isBidan()` → cek apakah user role-nya "bidan"
- `isOrangTua()` → cek apakah user role-nya "orang tua"
- `isKader()` → cek apakah user role-nya "kader"
- `isDinkes()` → cek apakah user role-nya "dinkes"

---

#### `Anak.php` → Tabel: `tb_anak`

**Bahasa bayi:** Ini adalah data anak-anak (balita) yang terdaftar dalam sistem.

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id_anak` | PK | ID unik setiap anak. |
| `id_user` | FK | ID orang tua (pemilik anak). |
| `nik_anak` | String (16, unik) | NIK anak. |
| `no_bpjs` | String (nullable) | Nomor BPJS. |
| `nama_anak` | String | Nama anak. |
| `anak_ke` | Integer (nullable) | Anak keberapa dalam keluarga. |
| `tempat_lahir` | String | Kota/tempat lahir. |
| `tanggal_lahir` | Date | Tanggal lahir. |
| `jenis_kelamin` | Enum | `Laki-laki` atau `Perempuan`. |
| `golongan_darah` | String (nullable) | A, B, AB, O, atau Tidak Tahu. |
| `berat_lahir` | Decimal (kg) | Berat saat lahir. |
| `panjang_lahir` | Decimal (cm) | Panjang saat lahir. |
| `lingkar_kepala_lahir` | Decimal (nullable, cm) | Lingkar kepala saat lahir. |
| `kondisi_lahir` | String (nullable) | Kondisi saat lahir (misal: normal, prematur). |
| `nama_ayah` | String (nullable) | Nama ayah. |
| `nama_ibu` | String (nullable) | Nama ibu. |
| `catatan` | Text (nullable) | Catatan tambahan. |
| `riwayat_alergi` | String (nullable) | Riwayat alergi anak. |
| `alamat_domisili` | String (nullable) | Alamat tempat tinggal. |
| `nomor_kontak_darurat` | String (nullable) | Nomor darurat yang bisa dihubungi. |

**Relasi:**
- `Anak` → milik satu `User` (orang tua) melalui `orangTua()`
- `Anak` → punya banyak `Pengukuran` melalui `pengukuran()`
- `Anak` → punya satu pengukuran terakhir melalui `latestPengukuran()`
- `Anak` → punya banyak `TindakanMedis` melalui `tindakanMedis()`
- `Anak` → punya banyak `Imunisasi` melalui `imunisasi()`

---

#### `Pengukuran.php` → Tabel: `tb_pengukuran`

**Bahasa bayi:** Ini adalah catatan setiap kali anak ditimbang / diukur di Posyandu.

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id_pengukuran` | PK | ID unik pengukuran. |
| `id_anak` | FK | Anak yang diukur. |
| `id_kader` | FK | Kader yang melakukan pengukuran. |
| `tanggal_pengukuran` | Date | Tanggal pengukuran. |
| `berat_badan` | Float (kg) | Berat badan anak. |
| `tinggi_badan` | Float (cm) | Tinggi badan anak. |
| `lingkar_kepala` | Float (nullable, cm) | Lingkar kepala anak. |
| `imt` | Float (nullable) | **IMT yang dihitung otomatis oleh sistem.** |
| `flag_risiko` | Boolean (default: 0) | `true` = anak berisiko, `false` = normal. |

**Relasi:**
- `Pengukuran` → milik satu `Anak`
- `Pengukuran` → milik satu `User` (kader) melalui `kader()`

**Accessor (perhitungan otomatis):**
- `status_gizi` → menghitung status gizi dari IMT (lihat bagian 7)
- `status_stunting` → menghitung status stunting dari IMT (lihat bagian 7)

---

#### `TindakanMedis.php` → Tabel: `tb_tindakan_medis`

**Bahasa bayi:** Ini adalah catatan setiap kali Bidan melakukan pemeriksaan/tindakan medis pada anak.

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id_tindakan` | PK | ID unik tindakan. |
| `id_anak` | FK | Anak yang diperiksa. |
| `id_bidan` | FK | Bidan yang memeriksa. |
| `tanggal_pemeriksaan` | Date | Tanggal pemeriksaan. |
| `suhu_tubuh` | Numeric | Suhu tubuh anak (°C). |
| `catatan_pemeriksaan` | String | Catatan hasil pemeriksaan. |
| `diagnosa` | String | Diagnosa Bidan. |
| `resep_obat` | String | Resep obat yang diberikan. |
| `puskesmas_id` | FK | Di Puskesmas mana. |
| `posyandu_id` | FK | Di Posyandu mana. |

**Relasi:** milik satu `Anak`, satu `User` (bidan), satu `Puskesmas`, satu `Posyandu`.

---

#### `Imunisasi.php` → Tabel: `tb_imunisasi`

**Bahasa bayi:** Ini adalah catatan setiap kali anak menerima vaksinasi/imunisasi.

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id_imunisasi` | PK | ID unik imunisasi. |
| `id_anak` | FK | Anak yang diimunisasi. |
| `id_bidan` | FK | Bidan yang memberikan imunisasi. |
| `nama_vaksin` | String | Nama vaksin (BCG, Polio 1, DPT-HB-Hib 1, dll). |
| `batch_vaksin` | String | Nomor batch vaksin. |
| `lokasi_suntikan` | String | Di bagian tubuh mana (misal: lengan kiri atas). |
| `suhu_tubuh` | Numeric | Suhu tubuh anak sebelum imunisasi. |
| `tanggal_pemberian` | Date | Tanggal pemberian imunisasi. |
| `catatan` | String | Catatan tambahan. |
| `puskesmas_id` | FK | Di Puskesmas mana. |
| `posyandu_id` | FK | Di Posyandu mana. |

**Relasi:** milik satu `Anak`, satu `User` (bidan), satu `Puskesmas`, satu `Posyandu`.

---

#### `Notifikasi.php` → Tabel: `tb_notifikasi`

**Bahasa bayi:** Ini adalah kotak masuk notifikasi untuk setiap user.

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id_notifikasi` | PK | ID unik. |
| `id_user` | FK | Untuk user siapa. |
| `judul` | String | Judul notifikasi. |
| `pesan` | String | Isi pesan. |
| `wa_link` | String (nullable) | Link WhatsApp yang sudah jadi. |
| `is_read` | Boolean | Sudah dibaca atau belum. |

---

#### `JadwalPosyandu.php` → Tabel: `tb_jadwal_posyandu`

**Bahasa bayi:** Ini adalah jadwal kegiatan Posyandu.

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id_jadwal` | PK | ID unik jadwal. |
| `posyandu_id` | FK | Untuk posyandu mana. |
| `tanggal` | Date | Tanggal kegiatan. |
| `waktu_mulai` | Time | Jam mulai. |
| `waktu_selesai` | Time | Jam selesai. |
| `lokasi` | String | Lokasi kegiatan. |
| `keterangan` | String | Keterangan tambahan. |

---

#### `TbLaporanDinkes.php` → Tabel: `tb_laporan_dinkes`

**Bahasa bayi:** Ini adalah laporan periodik yang dikirim Bidan ke Dinas Kesehatan.

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id` | PK | ID unik laporan. |
| `id_bidan` | FK | Bidan yang mengirim. |
| `nama_puskesmas` | String | Nama Puskesmas pengirim. |
| `periode_awal` | Date | Awal periode laporan. |
| `periode_akhir` | Date | Akhir periode laporan. |
| `status` | String | Status laporan (misal: "Terkirim"). |
| `data_serialized` | JSON | Seluruh isi data laporan disimpan dalam format JSON. |

---

#### `Kabupaten.php`, `Puskesmas.php`, `Posyandu.php`

**Bahasa bayi:** Ini adalah data wilayah yang membentuk hierarki:
- **Kabupaten** → punya banyak **Puskesmas**
- **Puskesmas** → punya banyak **Posyandu**
- **Posyandu** → punya banyak **User** (Kader) dan **JadwalPosyandu**

---

### 🎮 3.2 Controllers (Pengontrol)

> **Controller** itu ibarat "pelayan restoran." Dia menerima pesanan (request dari user), minta dapur masak (proses data dari model), lalu sajikan makanan (kirim response/view ke user).

#### Struktur Folder Controller

```
app/Http/Controllers/
├── Admin/
│   ├── AdminProfileController.php    → Edit profil Super Admin/Kader
│   └── AnakController.php            → CRUD anak (untuk Admin/Bidan)
├── Auth/
│   ├── LoginController.php           → Login & Logout
│   └── RegisterController.php        → Registrasi Orang Tua
├── Bidan/
│   ├── BidanProfileController.php    → Edit profil Bidan
│   ├── ImunisasiController.php       → CRUD Imunisasi
│   ├── NotificationController.php    → Kirim notifikasi ke Orang Tua
│   └── TindakanMedisController.php   → CRUD Tindakan Medis
├── Dinkes/
│   ├── DashboardController.php       → Dashboard Dinkes (statistik)
│   └── DinkesProfileController.php   → Edit profil Dinkes
├── Kader/
│   ├── JadwalPosyanduController.php  → CRUD Jadwal Posyandu
│   ├── KaderProfileController.php    → Edit profil Kader
│   └── PengukuranController.php      → Input pengukuran + hitung IMT
├── OrangTua/
│   ├── AnakController.php            → CRUD anak (untuk Orang Tua)
│   └── ProfileController.php         → Edit profil Orang Tua
├── DashboardController.php           → Dashboard Admin/Kader/Bidan/OrangTua
├── LaporanController.php             → Laporan terpadu + submit ke Dinkes
├── NotifikasiController.php          → Tandai semua notifikasi dibaca
├── PdfExportController.php           → Download PDF rekam medis
└── UserManagementController.php      → CRUD User (Super Admin & Bidan)
```

#### Penjelasan Controller Penting

**`LoginController.php`** — Mengatur proses login:
1. User memasukkan `username` + `password`.
2. Sistem cek ke database → kalau cocok, cek lagi apakah akun aktif (`is_active`).
3. Kalau aktif, redirect ke dashboard sesuai role (pakai `match`).
4. Kalau tidak aktif, logout paksa + tampilkan pesan error.

**`RegisterController.php`** — Mengatur registrasi:
1. Hanya untuk **Orang Tua**.
2. Membutuhkan: NIK (16 digit), nama lengkap, nomor kontak, username, password + konfirmasi.
3. Setelah berhasil daftar, langsung otomatis login dan masuk ke dashboard Orang Tua.
4. Role otomatis diset = `'orang tua'` (hardcoded, tidak bisa dipilih).

**`PengukuranController.php`** — ⭐ **Tempat IMT dihitung:**
1. Kader input: berat badan (kg), tinggi badan (cm).
2. Sistem hitung: `IMT = berat / (tinggi_m × tinggi_m)`.
3. Sistem tentukan warna: hijau/kuning/merah.
4. Sistem simpan: `imt` dan `flag_risiko` ke database.

**`LaporanController.php`** — Menggabungkan semua data:
1. Mengambil data `Pengukuran`, `TindakanMedis`, `Imunisasi`.
2. Menggabungkan ke dalam satu array "visits" berdasarkan `id_anak` + `tanggal`.
3. Bisa difilter berdasarkan Puskesmas dan rentang tanggal.
4. Bisa dicetak, di-export Excel, atau di-submit ke Dinkes.

**`UserManagementController.php`** — Mengelola user:
1. Super Admin bisa CRUD **semua role**.
2. Bidan hanya bisa CRUD **Kader** saja.
3. Ada proteksi agar user tidak bisa menghapus dirinya sendiri.

---

### 🖼️ 3.3 Views (Tampilan)

> **View** itu ibarat "piring penyajian." Data yang sudah diproses oleh Controller ditampilkan di sini agar bisa dilihat user.

```
resources/views/
├── auth/
│   └── login.blade.php                → Halaman login & register
├── dashboard/
│   ├── admin.blade.php                → Dashboard Super Admin
│   ├── admin/                         → Halaman admin tambahan
│   ├── bidan/
│   │   ├── index.blade.php            → Dashboard Bidan
│   │   ├── tindakan/                  → CRUD tindakan medis
│   │   └── imunisasi/                 → CRUD imunisasi
│   ├── dinkes/
│   │   ├── index.blade.php            → Dashboard Dinkes
│   │   └── laporan_detail.blade.php   → Detail laporan dari Bidan
│   ├── kader/
│   │   ├── index.blade.php            → Dashboard Kader
│   │   └── pengukuran/                → Form input pengukuran
│   ├── laporan/
│   │   ├── index.blade.php            → Halaman laporan
│   │   ├── print.blade.php            → Versi cetak
│   │   └── excel.blade.php            → Template export Excel
│   ├── orangtua/
│   │   ├── index.blade.php            → Dashboard Orang Tua
│   │   └── anak/                      → CRUD anak + detail timeline
│   └── users/
│       └── index.blade.php            → Halaman manajemen user
├── emails/
│   └── medical_result.blade.php       → Template email hasil medis
├── layouts/                           → Layout utama (header, sidebar, footer)
├── pdf/
│   ├── rekam_medis_anak.blade.php     → Template PDF rekam medis lengkap
│   ├── tindakan_medis.blade.php       → Template PDF tindakan medis
│   └── imunisasi.blade.php            → Template PDF imunisasi
└── welcome.blade.php                  → Landing page (halaman depan)
```

**Semua file view menggunakan ekstensi `.blade.php`** — ini adalah template engine bawaan Laravel yang memungkinkan kamu menulis HTML dicampur dengan PHP secara elegan.

---

### 🗃️ 3.4 Migrations (Migrasi Database)

> **Migration** itu ibarat "instruksi perakit meja." Dia berisi perintah untuk membuat tabel di database. Jadi kamu tidak perlu buat tabel manual di MySQL — cukup jalankan migration.

| File Migration | Tabel yang Dibuat/Diubah | Penjelasan |
|---|---|---|
| `create_users_table` | `users`, `password_reset_tokens`, `sessions` | Tabel bawaan Laravel (sessions dipakai karena `SESSION_DRIVER=database`). |
| `create_cache_table` | `cache`, `cache_locks` | Tabel cache (karena `CACHE_STORE=database`). |
| `create_jobs_table` | `jobs`, `job_batches`, `failed_jobs` | Tabel antrian pekerjaan (queue). |
| `create_tb_user_table` | `tb_user` | Tabel user utama (Super Admin, Bidan, Kader, Orang Tua, Dinkes). |
| `create_anaks_table` | `tb_anak` | Tabel data anak. |
| `add_status_and_wilayah_to_tb_user` | `tb_user` (alter) | Menambah kolom `is_active` dan `wilayah_kerja`. |
| `create_pengukurans_table` | `tb_pengukuran` | Tabel pengukuran anak (berat, tinggi, IMT, flag risiko). |
| `add_email_to_tb_user` | `tb_user` (alter) | Menambah kolom `email`. |
| `add_details_to_tb_anak` | `tb_anak` (alter) | Menambah kolom detail (golongan darah, BPJS, alergi, lingkar kepala lahir, dll). |
| `add_foto_profil_to_tb_user` | `tb_user` (alter) | Menambah kolom `foto_profil`. |
| `create_tindakan_medis_table` | `tb_tindakan_medis` | Tabel tindakan medis. |
| `create_imunisasi_table` | `tb_imunisasi` | Tabel imunisasi. |
| `create_notifikasis_table` | `tb_notifikasi` | Tabel notifikasi. |
| `add_medical_details_to_tindakan_and_imunisasi` | `tb_tindakan_medis`, `tb_imunisasi` (alter) | Menambah kolom tambahan medis. |
| `create_wilayah_tables` | `kabupatens`, `puskesmas`, `posyandus` | Tabel hierarki wilayah. |
| `add_location_to_tables` | `tb_user`, `tb_tindakan_medis`, `tb_imunisasi` (alter) | Menambah relasi lokasi (puskesmas_id, posyandu_id, kabupaten_id). |
| `add_kabupaten_id_to_tb_user` | `tb_user` (alter) | Menambah kolom `kabupaten_id`. |
| `create_tb_laporan_dinkes_table` | `tb_laporan_dinkes` | Tabel laporan ke Dinkes. |
| `create_jadwal_posyandus_table` | `tb_jadwal_posyandu` | Tabel jadwal posyandu. |
| `add_kontak_to_tb_anak_table` | `tb_anak` (alter) | Menambah kolom `alamat_domisili` dan `nomor_kontak_darurat`. |
| `add_alamat_domisili_to_tb_user_table` | `tb_user` (alter) | Menambah kolom `alamat_domisili`. |

**Cara menjalankan migration:**
```bash
php artisan migrate
```

---

### 🛣️ 3.5 Routes / web.php

> **Route** itu ibarat "alamat rumah." Ketika user mengetik URL di browser, route menentukan controller mana yang harus menangani request tersebut.

File: `routes/web.php`

#### Peta Lengkap Route

```
/                                    → Halaman welcome (landing page)

🔓 GUEST ROUTES (belum login):
/login              [GET]            → Tampilkan form login
/login              [POST]           → Proses login
/register           [POST]           → Proses registrasi orang tua

🔒 AUTHENTICATED ROUTES (sudah login):
/logout             [POST]           → Logout

📢 NOTIFIKASI (semua role):
/notifikasi/read-all [POST]          → Tandai semua notifikasi dibaca

👑 ADMIN ROUTES (role: super admin, kader) — prefix: /admin
/admin/dashboard                     → Dashboard admin/kader
/admin/anak                          → CRUD data anak (resource)
/admin/anak/{id}/rekam-medis-pdf     → Download PDF rekam medis
/admin/tindakan/{id}/pdf             → Download PDF tindakan
/admin/imunisasi/{id}/pdf            → Download PDF imunisasi

   🔐 SUPER ADMIN ONLY:
   /admin/users                      → CRUD user management

   /admin/profile                    → Edit profil admin

🏥 BIDAN ROUTES (role: bidan) — prefix: /bidan
/bidan/dashboard                     → Dashboard bidan
/bidan/anak                          → CRUD data anak (resource)
/bidan/anak/{id}/send-notification   → Kirim notifikasi WA ke ortu
/bidan/anak/{id}/send-system         → Kirim notifikasi sistem ke ortu
/bidan/tindakan                      → CRUD tindakan medis (resource)
/bidan/imunisasi                     → CRUD imunisasi (resource)
/bidan/anak/{id}/rekam-medis-pdf     → Download PDF rekam medis
/bidan/tindakan/{id}/pdf             → Download PDF tindakan
/bidan/imunisasi/{id}/pdf            → Download PDF imunisasi
/bidan/kader                         → CRUD kader (management)
/bidan/profile                       → Edit profil bidan

📋 KADER ROUTES (role: kader) — prefix: /kader
/kader/profile                       → Edit profil kader
/kader/pengukuran/create             → Form input pengukuran baru
/kader/pengukuran     [POST]         → Simpan pengukuran + hitung IMT
/kader/jadwal                        → CRUD jadwal posyandu (resource)

👨‍👩‍👧 ORANG TUA ROUTES (role: orang tua) — prefix: /orangtua
/orangtua/dashboard                  → Dashboard orang tua
/orangtua/dashboard/reminder/dismiss → Dismiss pengingat vaksin
/orangtua/profile                    → Edit profil
/orangtua/anak                       → CRUD anak (resource)
/orangtua/anak/{id}/rekam-medis-pdf  → Download PDF rekam medis
/orangtua/tindakan/{id}/pdf          → Download PDF tindakan
/orangtua/imunisasi/{id}/pdf         → Download PDF imunisasi

🏛️ DINKES ROUTES (role: dinkes) — prefix: /dinkes
/dinkes/dashboard                    → Dashboard Dinkes (statistik)
/dinkes/profile                      → Edit profil Dinkes
/dinkes/laporan/{id}                 → Lihat detail laporan

📊 SHARED ROUTES (role: bidan, dinkes):
/laporan                             → Halaman laporan terpadu
/laporan/print                       → Versi cetak laporan
/laporan/excel                       → Download Excel
/laporan/submit      [POST]          → Submit laporan ke Dinkes
```

---

### 🛡️ 3.6 Middleware

> **Middleware** itu ibarat "satpam gedung." Sebelum request masuk ke Controller, middleware mengecek dulu apakah request tersebut diizinkan.

#### `CheckRole.php`

**Lokasi:** `app/Http/Middleware/CheckRole.php`

**Cara kerja (bahasa bayi):**
1. Setiap route yang dilindungi punya daftar role yang boleh masuk.
2. Ketika ada request masuk, middleware ini mengecek: **"Apakah role user yang login ada di daftar yang diizinkan?"**
3. Kalau **YA** → request diteruskan ke Controller.
4. Kalau **TIDAK** → tampilkan error 403 ("Anda tidak memiliki akses ke halaman ini.").

**Contoh penggunaan di route:**
```php
// Hanya role 'bidan' yang bisa masuk
Route::middleware('role:bidan')->group(function () { ... });

// Role 'super admin' DAN 'kader' bisa masuk
Route::middleware('role:super admin,kader')->group(function () { ... });

// Role 'bidan' DAN 'dinkes' bisa masuk
Route::middleware('role:bidan,dinkes')->group(function () { ... });
```

#### `auth` Middleware (bawaan Laravel)

Mengecek apakah user sudah login. Kalau belum, redirect ke `/login`.

#### `guest` Middleware (bawaan Laravel)

Kebalikan dari `auth` — hanya user yang **belum login** yang bisa akses (halaman login & register).

#### Pendaftaran Middleware di `bootstrap/app.php`

```php
$middleware->alias([
    'role' => CheckRole::class,
]);
```

Middleware `role` didaftarkan sebagai alias di `bootstrap/app.php`, sehingga bisa dipakai di route dengan nama `role:nama_role`.

---

### 🌱 3.7 Seeders (Data Awal)

> **Seeder** itu ibarat "pengisi data contoh." Saat database masih kosong, seeder bisa mengisi data awal yang dibutuhkan.

#### `DatabaseSeeder.php`

File utama yang memanggil seeder lain. Saat ini hanya memanggil:
```php
$this->call([
    AdminUserSeeder::class,
]);
```

#### `AdminUserSeeder.php` ⭐ (PENTING!)

Ini adalah seeder yang **menciptakan akun Super Admin pertama kali**.

```php
User::updateOrCreate(
    ['username' => 'superadmin'],
    [
        'nama_lengkap' => 'Super Administrator',
        'password' => 'SuperAdmin@2026',
        'nomor_kontak' => '081200000000',
        'role' => 'super admin',
        'hak_akses_master' => ['full_access' => true],
    ]
);
```

#### `LocationSeeder.php`

Mengisi data wilayah contoh:
- **Kabupaten Bandung** → Puskesmas Bojongsoang → Posyandu Anggrek 1, Posyandu Melati 2
- **Kota Bandung** → Puskesmas Sukajadi → Posyandu Cempaka 3

---

### 📧 3.8 Mail (Email)

#### `MedicalResultMail.php`

**Lokasi:** `app/Mail/MedicalResultMail.php`

**Bahasa bayi:** Ini adalah "surat" yang dikirim lewat email ke Orang Tua setelah anaknya menerima tindakan medis atau imunisasi.

Isi surat:
- **Subject:** "Hasil Pemeriksaan / Imunisasi Anak"
- **Body:** Pesan berisi ringkasan tindakan/imunisasi (menggunakan view `emails.medical_result`).
- **Lampiran:** File PDF yang berisi detail lengkap.

**Konfigurasi email di `.env`:**
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=bidan.puskesmas.bojongsoang@gmail.com
MAIL_PASSWORD=xibsezonagzfqhaw         ← App Password Gmail
MAIL_FROM_ADDRESS=bidan.puskesmas.bojongsoang@gmail.com
MAIL_FROM_NAME="Puskesmas Bojongsoang"
```

---

### ⚙️ 3.9 File .env (Konfigurasi Lingkungan)

> **File `.env`** itu ibarat "buku pengaturan rahasia." Semua konfigurasi sensitif disimpan di sini dan **TIDAK BOLEH** di-share ke publik.

| Variabel | Nilai | Penjelasan |
|---|---|---|
| `APP_NAME` | SatuKIA | Nama aplikasi. |
| `APP_ENV` | local | Lingkungan: `local` (pengembangan), `production` (live). |
| `APP_DEBUG` | true | Mode debug aktif (tampilkan error detail). Di production harus `false`. |
| `APP_URL` | http://localhost | URL dasar aplikasi. |
| `DB_CONNECTION` | mysql | Tipe database yang dipakai. |
| `DB_HOST` | 127.0.0.1 | Alamat server database (localhost). |
| `DB_PORT` | 3306 | Port MySQL default. |
| `DB_DATABASE` | ta_terintegrasi | **Nama database yang harus dibuat di MySQL.** |
| `DB_USERNAME` | root | Username database. |
| `DB_PASSWORD` | *(kosong)* | Password database (kosong = default XAMPP/Laragon). |
| `SESSION_DRIVER` | database | Sesi login disimpan di database (bukan file). |
| `SESSION_LIFETIME` | 10 | **Sesi expired setelah 10 menit tidak aktif.** |
| `CACHE_STORE` | database | Cache disimpan di database. |
| `BCRYPT_ROUNDS` | 12 | Kekuatan enkripsi password. Semakin tinggi = semakin aman tapi lambat. |
| `MAIL_*` | smtp.gmail.com | Konfigurasi pengiriman email via Gmail SMTP. |

---

### 🏗️ 3.10 bootstrap/app.php

**Bahasa bayi:** Ini adalah "file penyala mesin" Laravel. Di sinilah:

1. **Route** didaftarkan (web.php, console.php).
2. **Middleware** `role` didaftarkan sebagai alias.
3. **Exception handling** dikonfigurasi — kalau user belum login dan coba akses halaman yang butuh login, dia akan di-redirect ke `/login` dengan pesan "Sesi Anda telah habis."

---

## 🔑 4. Sistem Role & Cara Mengetahui Siapa yang Login

### 5 Role dalam Sistem

| # | Role | Nilai di Database | Penjelasan |
|---|---|---|---|
| 1 | **Super Admin** | `'super admin'` | Boss besar. Bisa mengelola semua user dan semua data anak. |
| 2 | **Bidan** | `'bidan'` | Tenaga kesehatan yang melakukan tindakan medis & imunisasi. Bisa mengelola Kader. |
| 3 | **Kader** | `'kader'` | Relawan posyandu yang melakukan pengukuran (timbang/ukur anak). Bisa mengelola jadwal posyandu. |
| 4 | **Orang Tua** | `'orang tua'` | Orang tua/wali anak. Bisa mendaftarkan anak dan melihat rekam medis. |
| 5 | **Dinkes** | `'dinkes'` | Dinas Kesehatan. Hanya bisa melihat statistik dan menerima laporan dari Bidan. |

### Cara Sistem Mengetahui Role

1. **Di Database:** Setiap user punya kolom `role` di tabel `tb_user`. Isinya string biasa seperti `'bidan'`, `'kader'`, dll.

2. **Di Model User:** Ada helper methods:
   ```php
   $user->isSuperAdmin(); // return true/false
   $user->isBidan();      // return true/false
   $user->isKader();      // return true/false
   $user->isOrangTua();   // return true/false
   $user->isDinkes();     // return true/false
   ```

3. **Di Route (Middleware):** Middleware `role:` mengecek `$request->user()->role`:
   ```php
   // Di web.php
   Route::middleware('role:bidan')->group(...);
   ```

4. **Di Controller:** Bisa langsung cek:
   ```php
   if (auth()->user()->isBidan()) { ... }
   // atau
   if ($request->user()->role === 'super admin') { ... }
   ```

5. **Setelah Login:** Sistem otomatis redirect ke dashboard yang sesuai:
   ```php
   return match ($user->role) {
       'super admin' => redirect()->intended(route('admin.dashboard')),
       'bidan'       => redirect()->intended(route('bidan.dashboard')),
       'kader'       => redirect()->intended(route('admin.dashboard')),
       'orang tua'   => redirect()->intended(route('orangtua.dashboard')),
       'dinkes'      => redirect()->intended(route('dinkes.dashboard')),
       default       => redirect()->intended('/'),
   };
   ```

> **Catatan:** Kader diarahkan ke `admin.dashboard` karena mereka share dashboard yang sama dengan Super Admin, tapi di dalamnya ada pengecekan tambahan (`if ($role === 'kader')`) yang menampilkan konten berbeda.

---

## 🦸 5. Bagaimana Akun SuperAdmin Tercipta?

Ini pertanyaan yang sangat penting karena Super Admin adalah akun pertama yang harus ada di sistem. Tanpa Super Admin, tidak ada yang bisa login dan membuat akun lain!

### Jawaban: Lewat **Database Seeder**

Akun Super Admin **TIDAK** dibuat lewat form registrasi. Akun ini dibuat secara otomatis saat kamu menjalankan perintah seeding di terminal.

### Langkah-langkah:

**Langkah 1:** Buat database `ta_terintegrasi` di MySQL.

**Langkah 2:** Jalankan migration untuk membuat semua tabel:
```bash
php artisan migrate
```

**Langkah 3:** Jalankan seeder untuk membuat akun Super Admin:
```bash
php artisan db:seed
```

**Langkah 4:** Akan muncul output di terminal:
```
╔══════════════════════════════════════════════╗
║       SUPER ADMIN CREDENTIALS CREATED       ║
╠══════════════════════════════════════════════╣
║  Username : superadmin                      ║
║  Password : SuperAdmin@2026                 ║
╚══════════════════════════════════════════════╝
```

### Cara Kerja Seeder-nya:

**File:** `database/seeders/AdminUserSeeder.php`

```php
User::updateOrCreate(
    ['username' => 'superadmin'],       // Cari user dengan username ini
    [
        'nama_lengkap' => 'Super Administrator',
        'password' => 'SuperAdmin@2026', // Otomatis di-hash oleh Laravel
        'nomor_kontak' => '081200000000',
        'role' => 'super admin',
        'hak_akses_master' => ['full_access' => true],
    ]
);
```

**Penjelasan `updateOrCreate`:**
- Kalau belum ada user dengan `username = 'superadmin'` → **BUAT BARU**.
- Kalau sudah ada → **UPDATE** data-datanya.
- Jadi aman kalau dijalankan berkali-kali, tidak akan bikin duplikat.

**Kenapa password-nya tidak dienkripsi manual?**
Karena di model `User.php`, ada cast:
```php
'password' => 'hashed',
```
Artinya setiap kali password diset (baik lewat seeder maupun form), Laravel **otomatis meng-hash** password-nya menggunakan Bcrypt.

### Siapa yang bisa membuat akun lain?

| Akun yang Dibuat | Dibuat Oleh |
|---|---|
| Super Admin | Seeder (atau Super Admin lewat User Management) |
| Bidan | Super Admin |
| Kader | Super Admin atau Bidan |
| Orang Tua | Registrasi mandiri (form) atau Super Admin |
| Dinkes | Super Admin |

---

## 🧮 6. Fitur IMT Otomatis — Cara Perhitungan & Lokasi Kode

### Apa itu IMT?

**IMT (Indeks Massa Tubuh)** atau dalam bahasa Inggris **BMI (Body Mass Index)** adalah angka yang menunjukkan perbandingan berat badan dan tinggi badan seseorang. Dari angka ini, kita bisa tahu apakah anak tersebut **gizi baik**, **kurus**, atau **gemuk**.

### Rumus IMT

```
IMT = Berat Badan (kg) / (Tinggi Badan (m) × Tinggi Badan (m))
```

**Contoh:**
- Berat badan = 10 kg
- Tinggi badan = 75 cm = 0.75 m
- IMT = 10 / (0.75 × 0.75) = 10 / 0.5625 = **17.78**

### Dimana Kode IMT Otomatis Berada?

**File utama:** `app/Http/Controllers/Kader/PengukuranController.php` — method `store()` (baris 28-79)

```php
public function store(Request $request): RedirectResponse
{
    // 1. Validasi input dari Kader
    $validated = $request->validate([
        'id_anak'            => ['required', 'exists:tb_anak,id_anak'],
        'tanggal_pengukuran' => ['required', 'date'],
        'berat_badan'        => ['required', 'numeric', 'min:0.1', 'max:100'],
        'tinggi_badan'       => ['required', 'numeric', 'min:10', 'max:200'],
        'lingkar_kepala'     => ['nullable', 'numeric', 'min:10', 'max:100'],
    ]);

    // 2. HITUNG IMT OTOMATIS
    $tinggiInMeters = $validated['tinggi_badan'] / 100;   // cm → meter
    $imt = $validated['berat_badan'] / ($tinggiInMeters * $tinggiInMeters);

    // 3. TENTUKAN WARNA & STATUS (flagging)
    $imtColor = 'hijau';           // default = normal (aman)
    $statusText = 'Normal';
    $flagRisiko = false;

    if ($imt < 13.5 || $imt > 19) {
        // 🔴 MERAH: Gizi Buruk atau Gizi Lebih → Perlu Perhatian Serius
        $imtColor = 'merah';
        $statusText = 'Perlu Perhatian';
        $flagRisiko = true;
    } elseif (($imt >= 13.5 && $imt < 14.5) || ($imt > 18 && $imt <= 19)) {
        // 🟡 KUNING: Gizi Kurang atau Risiko Lebih → Hampir Perlu Perhatian
        $imtColor = 'kuning';
        $statusText = 'Hampir Perlu Perhatian';
        $flagRisiko = true;
    }
    // Kalau tidak masuk kondisi di atas → tetap HIJAU (normal)

    // 4. SIMPAN KE DATABASE
    Pengukuran::create([
        'id_anak'            => $validated['id_anak'],
        'id_kader'           => $request->user()->id_user,
        'tanggal_pengukuran' => $validated['tanggal_pengukuran'],
        'berat_badan'        => $validated['berat_badan'],
        'tinggi_badan'       => $validated['tinggi_badan'],
        'lingkar_kepala'     => $validated['lingkar_kepala'] ?? null,
        'imt'                => round($imt, 2),      // Dibulatkan 2 desimal
        'flag_risiko'        => $flagRisiko,           // true/false
    ]);

    // 5. KEMBALIKAN RESPONSE DENGAN INFO IMT
    return redirect()->route('kader.pengukuran.create')
        ->with([
            'success'    => 'Data pengukuran berhasil disimpan.',
            'imt_status' => $statusText,    // "Normal" / "Perlu Perhatian" / dst
            'imt_value'  => round($imt, 2), // Nilai IMT aktual
            'imt_color'  => $imtColor,      // "hijau" / "kuning" / "merah"
        ]);
}
```

### Tabel Klasifikasi IMT

| Nilai IMT | Warna | Status | `flag_risiko` |
|---|---|---|---|
| < 13.5 | 🔴 Merah | Perlu Perhatian (Gizi Buruk) | `true` |
| 13.5 – 14.4 | 🟡 Kuning | Hampir Perlu Perhatian (Gizi Kurang) | `true` |
| 14.5 – 18.0 | 🟢 Hijau | Normal (Gizi Baik) | `false` |
| 18.1 – 19.0 | 🟡 Kuning | Hampir Perlu Perhatian (Risiko Lebih) | `true` |
| > 19.0 | 🔴 Merah | Perlu Perhatian (Gizi Lebih) | `false`→`true` |

### Alur Lengkap IMT

```
Kader buka form pengukuran → isi berat & tinggi → klik simpan
         ↓
PengukuranController::store() dipanggil
         ↓
Tinggi dikonversi ke meter (÷ 100)
         ↓
IMT = berat / (tinggi_m²)
         ↓
Cek range → tentukan warna + flag_risiko
         ↓
Simpan ke tabel tb_pengukuran (kolom: imt, flag_risiko)
         ↓
Redirect kembali dengan pesan sukses + info IMT + warna
```

---

## 📊 7. Fitur Serupa: Status Gizi & Status Stunting

Selain perhitungan IMT di Controller, ada juga **perhitungan otomatis** di **Model** yang disebut **Accessor**.

### Lokasi Kode: `app/Models/Pengukuran.php`

#### Status Gizi (baris 46-60)

```php
public function getStatusGiziAttribute()
{
    $imt = $this->imt;
    if ($imt < 13.5) {
        return 'Gizi Buruk';
    } elseif ($imt >= 13.5 && $imt < 14.5) {
        return 'Gizi Kurang';
    } elseif ($imt > 18 && $imt <= 19) {
        return 'Risiko Lebih';
    } elseif ($imt > 19) {
        return 'Gizi Lebih';
    }
    return 'Gizi Baik';   // 14.5 – 18.0
}
```

**Bahasa bayi:** Setiap kali kamu akses `$pengukuran->status_gizi`, Laravel otomatis menghitung berdasarkan nilai IMT yang tersimpan. Kamu tidak perlu memanggil fungsi khusus — cukup akses seperti properti biasa.

| IMT | Status Gizi |
|---|---|
| < 13.5 | Gizi Buruk |
| 13.5 – 14.4 | Gizi Kurang |
| 14.5 – 18.0 | Gizi Baik ✅ |
| 18.1 – 19.0 | Risiko Lebih |
| > 19.0 | Gizi Lebih |

#### Status Stunting (baris 62-71)

```php
public function getStatusStuntingAttribute()
{
    if ($this->imt < 13.5) {
        return 'Stunting';
    } elseif ($this->imt >= 13.5 && $this->imt < 14.5) {
        return 'Berisiko Stunting';
    }
    return 'Normal';
}
```

| IMT | Status Stunting |
|---|---|
| < 13.5 | Stunting |
| 13.5 – 14.4 | Berisiko Stunting |
| ≥ 14.5 | Normal ✅ |

---

## 🚪 8. Alur Registrasi & Login

### Registrasi (Hanya Orang Tua)

```
User buka /login → klik tab "Daftar"
         ↓
Isi form: NIK (16 digit), Nama Lengkap, No. Kontak, Username, Password, Konfirmasi Password
         ↓
POST /register → RegisterController::register()
         ↓
Validasi → Buat akun dengan role = 'orang tua' (otomatis, tidak bisa dipilih)
         ↓
Auto-login → Redirect ke Dashboard Orang Tua
```

### Login (Semua Role)

```
User buka /login → isi Username + Password
         ↓
POST /login → LoginController::login()
         ↓
Cek credentials → Kalau salah → Error "Username atau password salah"
         ↓
Cek is_active → Kalau false → Logout + Error "Akun dinonaktifkan"
         ↓
Cek role → Redirect ke dashboard yang sesuai:
  - super admin, kader → /admin/dashboard
  - bidan             → /bidan/dashboard
  - orang tua         → /orangtua/dashboard
  - dinkes            → /dinkes/dashboard
```

---

## 🔔 9. Sistem Notifikasi

### 3 Channel Notifikasi

1. **In-App Notification** — Muncul di dalam aplikasi (bell icon). Disimpan di tabel `tb_notifikasi`. Bisa ditandai dibaca.

2. **WhatsApp Link** — Sistem membuat URL WhatsApp API yang sudah berisi pesan otomatis. Bidan tinggal klik → WhatsApp terbuka → pesan sudah terisi otomatis → tinggal kirim.
   ```
   https://api.whatsapp.com/send?phone=6281234567890&text=Halo...
   ```

3. **Email + PDF** — Jika Orang Tua punya email di profil, sistem mengirim email melalui Gmail SMTP beserta lampiran PDF.

### Kapan Notifikasi Dikirim?

| Event | Penerima | Channel |
|---|---|---|
| Bidan input tindakan medis | Orang Tua + Kader di posyandu | In-App + WA Link + Email+PDF |
| Bidan input imunisasi | Orang Tua + Kader di posyandu | In-App + WA Link + Email+PDF |
| Bidan klik "Kirim Notifikasi" | Orang Tua | In-App + WA + Email |
| Bidan klik "Panggilan Sistem" | Orang Tua | In-App + Email |
| Bidan submit laporan ke Dinkes | Semua user Dinkes | In-App |
| Orang Tua dismiss pengingat | Orang Tua sendiri | In-App (sebagai catatan) |

---

## 📄 10. Sistem Laporan & PDF

### Laporan Terpadu

**Controller:** `LaporanController.php`

Laporan menggabungkan 3 jenis data dalam satu tabel:
1. **Pengukuran** — data dari Kader
2. **Tindakan Medis** — data dari Bidan
3. **Imunisasi** — data dari Bidan

Penggabungan dilakukan berdasarkan **`id_anak` + `tanggal`** — jadi kalau anak yang sama diukur dan diimunisasi di tanggal yang sama, datanya muncul di satu baris.

### Export PDF (DomPDF)

**Controller:** `PdfExportController.php`

Menggunakan library `barryvdh/laravel-dompdf` untuk mengkonversi view Blade menjadi file PDF yang bisa diunduh.

Ada 3 jenis PDF:
1. **Rekam Medis Lengkap** — semua riwayat anak (tindakan + imunisasi).
2. **Tindakan Medis Satuan** — detail satu tindakan medis.
3. **Imunisasi Satuan** — detail satu imunisasi.

**Security:** Orang Tua hanya bisa download PDF untuk anak miliknya sendiri (ada pengecekan `auth()->id() !== $anak->id_user`).

---

## 💉 11. Validasi Usia Imunisasi

**Lokasi:** `app/Http/Controllers/Bidan/ImunisasiController.php` — method `store()` dan `update()`

Sebelum imunisasi disimpan, sistem mengecek apakah usia anak sudah memenuhi syarat minimum untuk vaksin tersebut:

| Vaksin | Usia Minimum |
|---|---|
| Hepatitis B0 | 0 bulan (baru lahir) |
| BCG, Polio 1 | 1 bulan |
| DPT-HB-Hib 1, Polio 2 | 2 bulan |
| DPT-HB-Hib 2, Polio 3 | 3 bulan |
| DPT-HB-Hib 3, Polio 4 | 4 bulan |
| Campak / MR | 9 bulan |

**Cara kerja:**
1. Ambil tanggal lahir anak.
2. Hitung selisih bulan antara tanggal lahir dan tanggal pemberian vaksin.
3. Bandingkan dengan usia minimum.
4. Kalau belum cukup umur → tolak dan tampilkan pesan: *"Usia anak (X bulan) belum mencukupi untuk vaksin Y (Minimal Z bulan)"*.

### Pengingat Imunisasi di Dashboard Orang Tua

**Lokasi:** `app/Http/Controllers/DashboardController.php` — method `orangTuaDashboard()`

Sistem juga memiliki jadwal vaksin berdasarkan bulan:
```php
$jadwalVaksinByBulan = [
    0 => ['Hepatitis B0'],
    1 => ['BCG', 'Polio 1'],
    2 => ['DPT-HB-Hib 1', 'Polio 2'],
    3 => ['DPT-HB-Hib 2', 'Polio 3'],
    4 => ['DPT-HB-Hib 3', 'Polio 4'],
    9 => ['Campak / MR'],
];
```

Sistem cek: vaksin mana yang **belum dilakukan** → tampilkan sebagai pengingat di dashboard Orang Tua. Pengingat muncul kalau jadwalnya dalam 7 hari ke depan atau sudah lewat (terlambat). Pengingat bisa di-dismiss oleh Orang Tua.

---

## 🗺️ 12. Struktur Wilayah (Kabupaten → Puskesmas → Posyandu)

Sistem ini memiliki hierarki wilayah 3 level:

```
📍 Kabupaten (contoh: Kabupaten Bandung)
   └── 🏥 Puskesmas (contoh: Puskesmas Bojongsoang)
       ├── 🏠 Posyandu (contoh: Posyandu Anggrek 1)
       └── 🏠 Posyandu (contoh: Posyandu Melati 2)
```

### Siapa yang terhubung ke mana?

| Role | Terhubung ke | Lewat Kolom |
|---|---|---|
| **Bidan** | Puskesmas | `puskesmas_id` |
| **Kader** | Posyandu | `posyandu_id` / `id_posyandu_kader` |
| **Dinkes** | Kabupaten | `kabupaten_id` |
| **Orang Tua** | Posyandu (opsional) | `posyandu_id` |
| **Super Admin** | Tidak terhubung (akses semua) | - |

### Tabel Database

| Tabel | Kolom Penting |
|---|---|
| `kabupatens` | `id`, `nama_kabupaten` |
| `puskesmas` | `id`, `kabupaten_id` (FK), `nama_puskesmas` |
| `posyandus` | `id`, `puskesmas_id` (FK), `nama_posyandu` |

---

## 📝 Ringkasan Cepat

| Aspek | Detail |
|---|---|
| **Nama App** | SatuKIA |
| **Database** | MySQL → `ta_terintegrasi` |
| **Total Models** | 11 (User, Anak, Pengukuran, TindakanMedis, Imunisasi, Notifikasi, JadwalPosyandu, TbLaporanDinkes, Kabupaten, Puskesmas, Posyandu) |
| **Total Controllers** | 17 (termasuk sub-folder) |
| **Total Migrations** | 21 |
| **Total Seeders** | 3 (DatabaseSeeder, AdminUserSeeder, LocationSeeder) |
| **Total Roles** | 5 (Super Admin, Bidan, Kader, Orang Tua, Dinkes) |
| **Login pertama** | `superadmin` / `SuperAdmin@2026` (dari seeder) |
| **Registrasi mandiri** | Hanya Orang Tua |
| **IMT dihitung di** | `PengukuranController::store()` |
| **Status Gizi dihitung di** | `Pengukuran::getStatusGiziAttribute()` |
| **Session timeout** | 10 menit |
| **Email provider** | Gmail SMTP |
| **PDF Library** | barryvdh/laravel-dompdf |

---

> 📌 **Dokumen ini dibuat otomatis dari analisis kode sumber project SatuKIA.**
> Terakhir diperbarui: 24 Juli 2026
